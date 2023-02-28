# BulkSMS PHP integration

PHP client for BulkSMS [sms sending API](https://dashboard.bulksms.link/api). 

Client allows sending sms messages in batches or one by one.

## Getting Started
### Installation

```shell
composer require krisciunaskarolis/bulksms
```

### Authentication

You have to create BulkSMS account first. More information [here](https://dashboard.bulksms.link/api). After registration you have to create APIKEY, which will be used for authentication.

### Sending messages
To send messages:

```php
$smsSender = new \Krisciunas\BulkSms\Sender\SmsSender();
$recipientPhoneNumbers = [
    '37066666661', 
    '37066666662',
    '37066666663'
];
$messages = [];

foreach ($recipientPhoneNumbers as $phoneNumber) {
    $messages[] = new \Krisciunas\BulkSms\Message\SmsMessage(
        //Sender name (sender ID), sender must be confirmed before sending SMS message
        sender: 'Test', 
        //Phone number of recipient
        recipientPhoneNumber: $phoneNumber,
        message: 'This is test message for first recipient!', //Message
        //Should message be opened on receiver's screen
        flash: \Krisciunas\BulkSms\Message\SmsMessageInterface::FLASH_NOT_REQUIRED, 
        //Is it test message
        test: \Krisciunas\BulkSms\Message\SmsMessageInterface::TEST_MODE_SUCCESS, 
    );
}

$result = $smsSender->send('[API_KEY]', $messages); //replace [API_KEY] with your BulkSMS API key
```

### Getting result

To get statuses of messages sent:

```php
$result = $smsSender->send('[API_KEY]', $messages); //replace [API_KEY] with your BulkSMS API key

foreach ($result as $logRecord) {
    $status = $logRecord->getStatusCode();
    $messageId = $logRecord->getMessageId();
    $recipientPhoneNumber = $logRecord->getRecipientPhoneNumber();
    $isAccepted = $logRecord->isAccepted();
}
```

## Examples

You can find working example in `src/examples/sendSmsMessages.php`

Replace `[API_KEY]` with yours and run example:

```
php sendSmsMessages.php
```

## Limitations

According to BulkSMS, maximum number of messages allowed in single request is 1000.

## Authors
- [Karolis Kriščiūnas](mailto:karolis.krisciunas@gmail.com)