<?php

namespace Krisciunas\BulkSms\Response;

interface MessageLogRecordInterface
{
    public function getMessageId(): ?int;

    public function getRecipientPhoneNumber(): ?string;

    public function isAccepted(): ?bool;

    public function getStatusCode(): ?int;
}