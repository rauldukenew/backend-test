<?php

namespace App\Services\MerchantIntegration;
use App\DTO\Payment\PaymentDTO;

class MerchantBRequestHandler extends MerchantRequestHandler
{
    public function handleRequest(array $requestData): PaymentDTO
    {
        $this->verifySignature(
            $requestData,
            $requestData['project'],
            $this->merchantConfig['id'],
            $this->merchantConfig['key'],
            $this->merchantConfig['algo'],
            $this->merchantConfig['delimiter']
        );
        return new PaymentDTO(
            $requestData['project'],
            $requestData['invoice'],
            $requestData['status'],
            $requestData['amount'],
            $requestData['amount_paid']);
    }
}
