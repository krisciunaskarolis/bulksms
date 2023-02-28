<?php

declare(strict_types=1);

namespace Krisciunas\BulkSms\Request;

use GuzzleHttp\Psr7\Request;
use Krisciunas\BulkSms\Message\SmsMessageInterface;
use Psr\Http\Message\RequestInterface;

class SmsSendingRequestBuilder implements RequestBuilderInterface
{
    private const ACTION = 'api-v1';

    private const METHOD = 'POST';

    public function build(string $apiToken, array $messages): RequestInterface
    {
        return new Request(
            self::METHOD,
            self::ACTION,
            [
                'BulkSMS-Token' => $apiToken,
                'Content-Type' => 'application/json',
                'Accept'=> 'application/json',
            ],
            $this->getPayload($messages),
        );
    }

    /**
     * @param SmsMessageInterface[] $messages
     */
    private function getPayload(array $messages): string
    {
        $payload = [];

        foreach ($messages as $message) {
            $payload[] = (object) $this->buildMessageData($message);
        }

        return json_encode($payload);
    }

    private function buildMessageData(SmsMessageInterface $message): object
    {
        $data = [
            'from' => $message->getSender(),
            'to' => $message->getRecipientPhoneNumber(),
            'message' => $message->getMessage(),
            'test' => $message->getTest(),
            'validity' => $message->getValidity(),
        ];

        if ($message->getDlr()) {
            $data['dlr'] = $message->getDlr();
        }

        if ($message->getSchedule()) {
            $data['schedule'] = $message->getSchedule();
        }

        return (object) $data;
    }
}