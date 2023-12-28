<?php

namespace App\Services\MerchantIntegration;


use Illuminate\Http\Request;

class DummyMerchantRequestParser implements MerchantRequestParserContract
{
    public function parseRequest(Request $request): array {
        return $request->all();
    }
}
