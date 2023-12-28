<?php

namespace App\Services\MerchantIntegration;

use App\Services\MerchantIntegration\Payment\PaymentService;

class MerchantIntegrationService
{
    public function __construct(
        protected MerchantRequestHandlerFactory    $merchantRequestHandlerFactory,
        protected PaymentService                   $paymentService,
        protected MerchantDailyLimitCheckerService $checkerService
    )
    {
    }

    public function handlePaymentUpdateProcess(array $requestData, array $merchantConfig): void
    {
        if ($this->checkerService
            ->checkMerchantHasLimit(
                $merchantConfig['id'],
                $merchantConfig['limit'])
        ) {
            $merchantRequestHandler = $this->merchantRequestHandlerFactory
                ->getMerchantRequestHandler(
                    $merchantConfig
                );
            $paymentData = $merchantRequestHandler->handleRequest($requestData);
            $this->paymentService->update($paymentData);
        };
    }
}
