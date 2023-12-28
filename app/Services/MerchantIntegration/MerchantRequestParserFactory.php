<?php

namespace App\Services\MerchantIntegration;

class MerchantRequestParserFactory
{
    public function getMerchantRequestParser(string $merchantRequestParserName): MerchantRequestParserContract
    {
        return new $merchantRequestParserName();
    }
}
