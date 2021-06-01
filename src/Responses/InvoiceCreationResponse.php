<?php


namespace CBS\Client\Responses;


use Psr\Http\Message\ResponseInterface;

class InvoiceCreationResponse
{
    private ResponseInterface $response;
    private array $responseData;


    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->responseData = json_decode($response->getBody()->getContents(), true);
    }

    public function isSuccess(): bool
    {
        return !$this->responseData['Error'];
    }

    public function isError(): bool
    {
        return !$this->isSuccess();
    }

    public function customerPrimaryContactId(): ?string
    {
        return $this->responseData['ResponseObject']['CustomerPrimaryContactId'] ?? null;
    }

    public function customerId(): ?string
    {
        return $this->responseData['ResponseObject']['CustomerId'] ?? null;
    }

    public function recipient(): ?string
    {
        return $this->responseData['ResponseObject']['Recipient'] ?? null;
    }

    public function payerId(): ?string
    {
        return $this->responseData['ResponseObject']['PayerId'] ?? null;
    }

    public function email(): ?string
    {
        return $this->responseData['ResponseObject']['Email'] ?? null;
    }

    public function phoneNumber(): ?string
    {
        return $this->responseData['ResponseObject']['PhoneNumber'] ?? null;
    }

    public function tin(): ?string
    {
        return $this->responseData['ResponseObject']['TIN'] ?? null;
    }

    public function mdaName(): ?string
    {
        return $this->responseData['ResponseObject']['MDAName'] ?? null;
    }

    public function revenueHeadName(): ?string
    {
        return $this->responseData['ResponseObject']['RevenueHeadName'] ?? null;
    }

    public function externalRefNumber(): ?string
    {
        return $this->responseData['ResponseObject']['ExternalRefNumber'] ?? null;
    }

    public function paymentURL(): ?string
    {
        return $this->responseData['ResponseObject']['PaymentURL'] ?? null;
    }

    public function description(): ?string
    {
        return $this->responseData['ResponseObject']['Description'] ?? null;
    }

    public function requestReference(): ?string
    {
        return $this->responseData['ResponseObject']['RequestReference'] ?? null;
    }

    public function isDuplicateRequestReference(): ?bool
    {
        return $this->responseData['ResponseObject']['IsDuplicateRequestReference'] ?? null;
    }

    public function invoiceNumber(): ?bool
    {
        return $this->responseData['ResponseObject']['InvoiceNumber'] ?? null;
    }

    public function invoicePreviewUrl(): ?bool
    {
        return $this->responseData['ResponseObject']['InvoicePreviewUrl'] ?? null;
    }

    public function amountDue(): ?float
    {
        return $this->responseData['ResponseObject']['AmountDue'] ?? null;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}