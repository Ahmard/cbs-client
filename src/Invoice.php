<?php


namespace CBS\Client;


use CBS\Client\Responses\InvoiceCreationResponse;
use Guzwrap\Request;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class Invoice
{
    protected string $endpointUri;

    protected string $clientId;

    protected string $secretKey;

    protected array $inputs = [
        'RevenueHeadId' => 16,
        'Invoice' => 'sdjsdklsjdsldk',
        'TaxEntityInvoice' => [
            'Amount' => null,
            "InvoiceDescription" => null,
            "AdditionalDetails" => [],
            "CategoryId" => 1,
            "TaxEntity" => [
                'Invoice' => null,
                'Email' => null,
                'Address' => null,
                'PhoneNumber' => null,
                'TaxPayerIdentificationNumber' => null,
                'RCNumber' => null,
                'PayerId' => null
            ]
        ],
        "ExternalRefNumber" => null,
        "RequestReference" => null,
        "CallBackURL" => null
    ];


    public static function create(string $clientId, string $secretKey): Invoice
    {
        return new Invoice($clientId, $secretKey);
    }

    /**
     * @param string|float|int $money
     * @return string
     */
    public static function formatMoney($money): string
    {
        return number_format($money, 2, '.', '');
    }

    public function __construct(string $clientId, string $secretKey)
    {
        $this->clientId = $clientId;
        $this->secretKey = $secretKey;
    }


    protected function generateSignature(): string
    {
        $SignatureString = $this->inputs['RevenueHeadId'] .
            self::formatMoney($this->inputs['TaxEntityInvoice']['Amount']) .
            $this->inputs['CallBackURL'] .
            $this->clientId;

        return base64_encode(
            hash_hmac('sha256', $SignatureString, $this->secretKey, true)
        );
    }


    public function revenueHeadId(int $id): Invoice
    {
        $this->inputs['RevenueHeadId'] = $id;
        return $this;
    }

    /**
     * When passed, it must be unique per
     * request. It must also be
     * deterministic for the calling
     * application to generate i.e. for the
     * same request this value must always
     * be the same
     *
     * @param string $refId
     * @return $this
     */
    public function requestReference(string $refId): Invoice
    {
        $this->inputs['RequestReference'] = $refId;
        return $this;
    }

    public function callBackUrl(string $url): Invoice
    {
        $this->inputs['CallBackURL'] = $url;
        return $this;
    }

    public function externalRefNumber(int $refNumber): Invoice
    {
        $this->inputs['ExternalRefNumber'] = $refNumber;
        return $this;
    }

    public function endpoint(string $endpointUri): Invoice
    {
        $this->endpointUri = $endpointUri;
        return $this;
    }

    /**
     * Invoice amount to be generated.
     * Some revenue heads allow tax
     * payers to input the amount to be
     * paid for, while some have a fixed
     * amount. For cases where an amount
     * is required, this value must be set to
     * be greater than 0.00. for cases
     * where the amount is fixed, if an
     * amount is supplied, the supplied
     * amount is used for invoice
     * generation
     * Invoice desc
     *
     * @param float $amount
     * @return $this
     */
    public function amount(float $amount): Invoice
    {
        $amount = Invoice::formatMoney($amount);
        $this->inputs['TaxEntityInvoice']['Amount'] = $amount;

        return $this;
    }

    public function invoiceDescription(string $desc): Invoice
    {
        $this->inputs['TaxEntityInvoice']['InvoiceDescription'] = $desc;
        return $this;
    }

    public function additionalDetails(array $details = []): Invoice
    {
        $this->inputs['TaxEntityInvoice']['AdditionalDetails'] = $details;
        return $this;
    }

    public function categoryId(int $id): Invoice
    {
        $this->inputs['TaxEntityInvoice']['CategoryId'] = $id;
        return $this;
    }

    /**
     * Name of the invoice recipient
     *
     * @param string $Client
     * @return $this
     */
    public function recipient(string $Client): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['Recipient'] = $Client;
        return $this;
    }

    /**
     * Email address of the recipient
     *
     * @param string $email
     * @return $this
     */
    public function email(string $email): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['Email'] = $email;
        return $this;
    }

    /**
     * Address of the recipient
     *
     * @param string $address
     * @return $this
     */
    public function address(string $address): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['Address'] = $address;
        return $this;
    }

    /**
     * Invoice mobile number
     *
     * @param string $phoneNumber
     * @return $this
     */
    public function phoneNumber(string $phoneNumber): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['PhoneNumber'] = $phoneNumber;
        return $this;
    }

    /**
     * TIN - Tax payer identification number
     *
     * @param int $taxPayerIdentificationNumber
     * @return $this
     */
    public function TaxPayerIdentificationNumber(int $taxPayerIdentificationNumber): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['TaxPayerIdentificationNumber'] = $taxPayerIdentificationNumber;
        return $this;
    }

    /**
     * RC Number
     *
     * @param string $rc
     * @return $this
     */
    public function rcNumber(string $rc): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['RCNumber'] = $rc;
        return $this;
    }

    /**
     * Central Billing System identification
     * number
     *
     * @param int $id
     * @return $this
     */
    public function payerId(int $id): Invoice
    {
        $this->inputs['TaxEntityInvoice']['TaxEntity']['PayerId'] = $id;
        return $this;
    }

    /**
     * @return InvoiceCreationResponse
     * @throws GuzzleException
     * @throws JsonException
     */
    public function execute(): InvoiceCreationResponse
    {
        $response = Request::post($this->endpointUri)
            ->header([
                'ClientId' => $this->clientId,
                'Signature' => $this->generateSignature(),
            ])
            ->json($this->inputs)
            ->exec();

        return new InvoiceCreationResponse($response);
    }
}