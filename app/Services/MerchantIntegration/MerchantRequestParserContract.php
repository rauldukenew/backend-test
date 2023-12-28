<?php

namespace App\Services\MerchantIntegration;


use Illuminate\Http\Request;

interface MerchantRequestParserContract
{
    public function parseRequest(Request $request): array;
}
