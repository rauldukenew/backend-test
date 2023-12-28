<?php

namespace App\Services\MerchantIntegration;

class MerchantRequestHandlerFactory
{
    public function getMerchantRequestHandler(
        array $merchantConfig,
    ): MerchantRequestHandlerContract
    {
        $requestHandlerName = $merchantConfig['requestHandler'];
        return new $requestHandlerName($merchantConfig);
    }
}
