# CBS Client
Central Billing System(CBS) Client.

## Installation
```
composer require ahmard/cbs-client
```

## Usage

```php
use CBS\Client\Invoice;

require 'vendor/autoload.php';

$clientId = '';
$clientSecret = '';

$invoice = Invoice::create($clientId, $clientSecret)
        ->revenueHeadId(16)
        ->amount(3455)
        ->invoiceDescription('Payment Description')
        ->categoryId(1)
        ->endpoint('')
        ->callBackUrl('http://tatsuniya.test/webhook')
        ->requestReference(uniqid())
        ->phoneNumber('07035636394')
        ->address('Malumfashi')
        ->email('gizo@tatsuniya.test')
        ->recipient('Gizon Tastuniya')
        ->execute();

if ($invoice->isSuccess()){
    header("Location: {$invoice->paymentURL()}");
}else{
    echo $invoice->getResponse()->getBody()->getContents();
}
```