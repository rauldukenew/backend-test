<?php

namespace App\Services\MerchantIntegration;

interface MerchantRequestHandlerContract
{
    public function handleRequest(array $requestData);
}
