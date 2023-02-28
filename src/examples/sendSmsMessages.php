<?php

require '../../vendor/autoload.php';

$smsSender = new \Krisciunas\BulkSms\Sender\SmsSender();
$recipientPhoneNumbers = ['37066666661', '37066666662', '37066666663'];
$messages = [];

foreach ($recipientPhoneNumbers as $phoneNumber) {
    $messages[] = new \Krisciunas\BulkSms\Message\SmsMessage(
        sender:               'Test', //Sender name (sender ID), sender must be confirmed before sending SMS message
        recipientPhoneNumber: $phoneNumber, //Phone number of recipient
        message:              'This is test message for first recipient!', //Message
        flash:                \Krisciunas\BulkSms\Message\SmsMessageInterface::FLASH_NOT_REQUIRED, //Should message be opened on receiver's screen
        test:                 \Krisciunas\BulkSms\Message\SmsMessageInterface::TEST_MODE_SUCCESS, //Is it test message
    );
}

$result = $smsSender->send('[API_KEY]', $messages); //replace [API_KEY] with your BulkSMS API key

foreach ($result as $logRecord) {
    $status = $logRecord->getStatusCode();
    $messageId = $logRecord->getMessageId();
    $recipientPhoneNumber = $logRecord->getRecipientPhoneNumber();
    $isAccepted = $logRecord->isAccepted();
}

