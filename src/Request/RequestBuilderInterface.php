<?php

namespace Krisciunas\BulkSms\Request;

use Psr\Http\Message\RequestInterface;

interface RequestBuilderInterface
{
    public function build(string $apiToken, array $messages): RequestInterface;
}