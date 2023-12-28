<?php

namespace App\Http\Controllers;

use App\Services\MerchantIntegration\MerchantIntegrationService;
use App\Services\MerchantIntegration\MerchantRequestParserFactory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected MerchantRequestParserFactory $merchantRequestParserFactory,
        protected MerchantIntegrationService $merchantIntegrationService
    )
    {
    }
    public function merchantCallback(Request $request, string $merchant): void
    {
        if(!isset(config('merchant')[$merchant])) {
            abort(404, 'Merchant not found');
        }
        $merchantConfig = config('merchant')[$merchant];
        $requestParser = $this->merchantRequestParserFactory
            ->getMerchantRequestParser($merchantConfig['requestParser']);
        $parsedRequest = $requestParser->parseRequest($request);
        $this->merchantIntegrationService
            ->handlePaymentUpdateProcess($parsedRequest, $merchantConfig);
    }
}
