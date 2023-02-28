<?php

declare(strict_types=1);

namespace Krisciunas\BulkSms\Sender;

use GuzzleHttp\Client;
use Krisciunas\BulkSms\Exception\LimitationsException;
use Krisciunas\BulkSms\Request\RequestBuilderInterface;
use Krisciunas\BulkSms\Request\SmsSendingRequestBuilder;
use Krisciunas\BulkSms\Response\MessageLogRecord;
use Krisciunas\BulkSms\Response\MessageLogRecordInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class SmsSender implements SenderInterface
{
    private const MESSAGES_IN_ONE_REQUEST_LIMIT = 1000;

    public function __construct(
        private ?ClientInterface $client = null,
        private ?RequestBuilderInterface $requestBuilder = null
    ) {
        if (null === $this->client) {
            $this->client = new Client(['base_uri' => self::BASE_URL, 'timeout' => self::DEFAULT_TIMEOUT]);
        }

        if (null === $this->requestBuilder) {
            $this->requestBuilder = new SmsSendingRequestBuilder();
        }
    }

    /**
     * @inheritDoc*
     */
    public function send(string $apiToken, array $messages): array
    {
        if (self::MESSAGES_IN_ONE_REQUEST_LIMIT < count($messages)) {
            throw new LimitationsException('10000 or less messages are allowed in one request.');
        }

        $request = $this->requestBuilder->build($apiToken, $messages);
        $response = $this->client->sendRequest($request);

        return $this->parseResponse($response);
    }

    /**
     * @return MessageLogRecordInterface[]
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $parsedResponse = json_decode($response->getBody()->getContents(), true);

        $result = [];

        foreach ($parsedResponse as $data) {
            $result[] = new MessageLogRecord(
                $data['MessageId'] ?? null,
                $data['to'] ?? null,
                $data['accepted'] ?? null,
                $data['error'] ?? null,
            );
        }

        return $result;
    }
}