<?php


namespace CBS\Client;


class Recipient
{
    protected array $recipientData = [
        'TaxEntityInvoice' => [
            'Recipient' => null,
            'Email' => null,
            'Address' => null,
            'PhoneNumber' => null,
            'TaxPayerIdentificationNumber' => null,
            'RCNumber' => null,
            'PayerId' => null
        ]
    ];

    public static function create(): Recipient
    {
        return new Recipient();
    }

    /**
     * Name of the invoice recipient
     *
     * @param string $recipient
     * @return $this
     */
    public function recipient(string $recipient): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['Recipient'] = $recipient;
        return $this;
    }

    /**
     * Recipient Email address
     *
     * @param string $email
     * @return $this
     */
    public function email(string $email): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['Email'] = $email;
        return $this;
    }

    /**
     * Recipient address
     *
     * @param string $address
     * @return $this
     */
    public function address(string $address): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['Address'] = $address;
        return $this;
    }

    /**
     * Recipient mobile number
     *
     * @param string $phoneNumber
     * @return $this
     */
    public function phoneNumber(string $phoneNumber): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['PhoneNumber'] = $phoneNumber;
        return $this;
    }

    /**
     * TIN - Tax payer identification number
     *
     * @param int $taxPayerIdentificationNumber
     * @return $this
     */
    public function TaxPayerIdentificationNumber(int $taxPayerIdentificationNumber): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['TaxPayerIdentificationNumber'] = $taxPayerIdentificationNumber;
        return $this;
    }

    /**
     * RC Number
     *
     * @param string $rc
     * @return $this
     */
    public function rcNumber(string $rc): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['RCNumber'] = $rc;
        return $this;
    }

    /**
     * Payer ID
     *
     * @param int $id
     * @return $this
     */
    public function payerId(int $id): Recipient
    {
        $this->recipientData['TaxEntityInvoice']['PayerId'] = $id;
        return $this;
    }

    /**
     * @return array|\null[][]
     */
    public function getRecipientData(): array
    {
        return $this->recipientData;
    }
}