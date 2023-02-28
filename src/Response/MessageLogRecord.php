<?php

declare(strict_types=1);

namespace Krisciunas\BulkSms\Response;

class MessageLogRecord implements MessageLogRecordInterface
{
    public function __construct(
        private readonly ?int $messageId,
        private readonly ?string $recipientPhoneNumber,
        private readonly ?bool $accepted,
        private readonly ?int $statusCode,
    ) {
    }

    public function getMessageId(): ?int
    {
        return $this->messageId;
    }

    public function getRecipientPhoneNumber(): ?string
    {
        return $this->recipientPhoneNumber;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }
}