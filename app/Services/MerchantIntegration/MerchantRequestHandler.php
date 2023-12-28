<?php

namespace App\Services\MerchantIntegration;

abstract class MerchantRequestHandler implements MerchantRequestHandlerContract
{
    public function __construct(
        protected array $merchantConfig
    )
    {
    }

    public function generateSignature(
        array $requestData,
        string $key,
        string $algo='md5',
        string $delimiter='.'
    ): string
    {
        ksort($requestData);
        $dataString = implode($delimiter, $requestData);
        $dataString .= $key;
        return hash($algo, $dataString);
    }
    public function verifySignature(
        array $requestData,
        int $requestMerchantId,
        int $configMerchantId,
        string $key,
        string $algo,
        string $delimiter
    ): void {
        $sign = $requestData['sign'];
        unset($requestData['sign']);
        $generatedSignature = $this->generateSignature($requestData, $key, $algo, $delimiter);
        if(($generatedSignature !== $sign) || ($configMerchantId !== $requestMerchantId)){
            abort(403, "Invalid signature");
        };
    }
}
