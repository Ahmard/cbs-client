<?php


namespace CBS\Client;


class Webhook
{
    private array $inputs;


    public static function capture(): Webhook
    {
        $contents = (string)file_get_contents('php://input');
        return new self(json_decode($contents, true));
    }

    public static function exit(): void
    {
        exit(200);
    }

    public function __construct(array $inputs)
    {
        $this->inputs = $inputs;
    }

    public function invoiceNumber(): ?string
    {
        return $this->inputs['InvoiceNumber'] ?? null;
    }

    /**
     * Payment ref returned from the
     * payment channel
     *
     * @return string|null
     */
    public function paymentRef(): ?string
    {
        return $this->inputs['PaymentRef'] ?? null;
    }

    public function paymentDate(): ?string
    {
        return $this->inputs['PaymentDate'] ?? null;
    }

    public function bankCode(): ?string
    {
        return $this->inputs['BankCode'] ?? null;
    }

    public function bankName(): ?string
    {
        return $this->inputs['BankName'] ?? null;
    }

    public function bankBranch(): ?string
    {
        return $this->inputs['BankBranch'] ?? null;
    }

    public function channel(): ?string
    {
        return $this->inputs['Channel'] ?? null;
    }

    public function paymentProvider(): ?string
    {
        return $this->inputs['PaymentProvider'] ?? null;
    }

    /**
     * Amount paid against the invoice
     *
     * @return string|null
     */
    public function amountPaid(): ?string
    {
        return $this->inputs['AmountPaid'] ?? null;
    }

    public function transactionDate(): ?string
    {
        return $this->inputs['TransactionDate'] ?? null;
    }

    /**
     * HMAC hash on the concat of
     * InvoiceNumber, PaymentRef,
     * AmountPaid (2 decimal places) and
     * Request Reference
     *
     * @return string|null
     */
    public function hmac(): ?string
    {
        return $this->inputs['Mac'] ?? null;
    }

    /**
     * Returns json-decoded input
     *
     * @return array
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }
}