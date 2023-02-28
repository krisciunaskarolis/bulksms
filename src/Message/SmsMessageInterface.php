<?php

namespace Krisciunas\BulkSms\Message;

interface SmsMessageInterface
{
    public const FLASH_REQUIRED = 1;

    public const FLASH_NOT_REQUIRED = 0;

    public const TEST_MODE_DISABLED = 0;

    public const TEST_MODE_SUCCESS = 1;

    public const TEST_MODE_FAILURE = 2;

    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function getSender(): string;

    public function getRecipientPhoneNumber(): string;

    public function getMessage(): string;

    public function getTest(): int;

    public function getValidity(): ?int;

    public function getDlr(): ?string;

    public function getSchedule(): ?string;

    public function getFlash(): int;
}