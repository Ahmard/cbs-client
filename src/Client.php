<?php


namespace CBS\Client;


use Guzwrap\Request;
use Guzwrap\Wrapper\Form;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class Client
{
    protected string $endpointUri;

    protected string $clientId;

    protected string $secretKey;

    protected array $inputs = [
        'RevenueHeadId' => null,
        'TaxEntityInvoice' => [
            'Amount' => null,
            "InvoiceDescription" => null,
            "AdditionalDetails" => [],
            "CategoryId" => null,
            "TaxEntity" => [
                'Recipient' => null,
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


    public static function create(string $clientId, string $secretKey): Client
    {
        return new Client($clientId, $secretKey);
    }

    public static function formatMoney(int $money): string
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


    public function revenueHeadId(int $id): Client
    {
        $this->inputs['RevenueHeadId'] = $id;
        return $this;
    }

    public function requestReference(string $refId): Client
    {
        $this->inputs['RequestReference'] = $refId;
        return $this;
    }

    public function callBackUrl(string $url): Client
    {
        $this->inputs['CallBackURL'] = $url;
        return $this;
    }

    public function externalRefNumber(int $refNumber): Client
    {
        $this->inputs['ExternalRefNumber'] = $refNumber;
        return $this;
    }

    public function endpoint(string $endpointUri): Client
    {
        $this->endpointUri = $endpointUri;
        return $this;
    }

    public function recipient(Recipient $recipient): Client
    {
        $this->inputs = array_merge(
            $this->inputs,
            $recipient->getRecipientData()
        );

        return $this;
    }

    public function invoice(Invoice $invoice): Client
    {
        $this->inputs = array_merge(
            $this->inputs,
            $invoice->getInvoiceData()
        );

        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function execute()
    {
        $response = Request::uri($this->endpointUri)->body(json_encode($this->inputs))
            ->exec();


        return $response;
    }
}