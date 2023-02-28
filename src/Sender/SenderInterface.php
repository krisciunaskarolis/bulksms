<?php

namespace Krisciunas\BulkSms\Sender;

use Krisciunas\BulkSms\Exception\LimitationsException;
use Krisciunas\BulkSms\Message\SmsMessageInterface;
use Krisciunas\BulkSms\Response\MessageLogRecordInterface;
use Psr\Http\Client\ClientExceptionInterface;

interface SenderInterface
{
    public const BASE_URL = 'https://dashboard.bulksms.link';
    public const DEFAULT_TIMEOUT = 10;

    /**
     * @param SmsMessageInterface[] $messages
     * @return MessageLogRecordInterface[]
     * @throws ClientExceptionInterface
     * @throws LimitationsException
     */
    public function send(string $apiToken, array $messages): array;
}