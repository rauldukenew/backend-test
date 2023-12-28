<?php

namespace App\Services\MerchantIntegration;


use Illuminate\Http\Request;

class MerchantBRequestParser implements MerchantRequestParserContract
{
    public function parseRequest(Request $request): array {
        $authorizationKey = $request->header('authorization');
        $requestData = $request->all();
        $requestData['sign'] = $authorizationKey;
        return $requestData;
    }
}
