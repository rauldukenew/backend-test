<?php

namespace App\Services\MerchantIntegration;

use App\DTO\Payment\PaymentDTO;


class MerchantARequestHandler extends MerchantRequestHandler
{
    public function handleRequest(array $requestData): PaymentDTO
    {
        $this->verifySignature(
            $requestData,
            $requestData['merchant_id'],
            $this->merchantConfig['id'],
            $this->merchantConfig['key'],
            $this->merchantConfig['algo'],
            $this->merchantConfig['delimiter']
        );
        return new PaymentDTO(
            $requestData['merchant_id'],
            $requestData['payment_id'],
            $requestData['status'],
            $requestData['amount'],
            $requestData['amount_paid']);
    }
}
