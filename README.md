# CBS Client
Central Billing System(CBS) Client.

## Installation
```
composer require ahmard/cbs-client
```

## Usage

```php
use CBS\Client\Client;
use CBS\Client\Invoice;
use CBS\Client\Recipient;

require 'vendor/autoload.php';

$recipient = Recipient::create()
    ->recipient('John Doe')
    ->phoneNumber('07012345678')
    ->address('Recipient home address')
    ->email('test@example.com');

$invoice = Invoice::create()
    ->amount(3455)
    ->invoiceDescription('Initial Payment for application')
    ->categoryId(6);

$clientId = '';
$clientSecret = '';

$client = Client::create($clientId, $clientSecret)
    ->recipient($recipient)
    ->invoice($invoice)
    ->endpoint('http://localhost:8001')
    ->callBackUrl('http://localhost:8002/webhook')
    ->requestReference('Testing')
    ->execute();
```