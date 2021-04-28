<?php


namespace CBS\Client;


class Invoice
{
    protected array $invoiceData = [
        'TaxEntityInvoice' => [
            'Amount' => null,
            "InvoiceDescription" => null,
            "AdditionalDetails" => [],
            "CategoryId" => null
        ]
    ];

    public static function create(): Invoice
    {
        return new Invoice();
    }

    public function amount(float $amount): Invoice
    {
        $amount = Client::formatMoney($amount);
        $this->invoiceData['TaxEntityInvoice']['Amount'] = $amount;

        return $this;
    }

    public function invoiceDescription(string $desc): Invoice
    {
        $this->invoiceData['TaxEntityInvoice']['InvoiceDescription'] = $desc;
        return $this;
    }

    public function additionalDetails(array $details = []): Invoice
    {
        $this->invoiceData['TaxEntityInvoice']['AdditionalDetails'] = $details;
        return $this;
    }

    public function categoryId(int $id): Invoice
    {
        $this->invoiceData['TaxEntityInvoice']['CategoryId'] = $id;
        return $this;
    }

    /**
     * @return array|array[]
     */
    public function getInvoiceData(): array
    {
        return $this->invoiceData;
    }
}