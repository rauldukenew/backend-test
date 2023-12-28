<?php

namespace App\Services\MerchantIntegration\Payment;

use App\DTO\Payment\PaymentDTO;
use App\Exceptions\PaymentNotFoundException;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Services\MerchantIntegration\Merchant\MerchantService;
use App\Services\MerchantIntegration\PaymentStatus\PaymentStatusService;

class PaymentService
{
    public function __construct(
        protected MerchantService      $merchantService,
        protected PaymentStatusService $paymentStatusService
    )
    {
    }

    public function update(
        PaymentDTO $paymentDTO,
    ): Payment
    {
        $merchantId = $this->merchantService->firstOrCreate($paymentDTO->merchantId);
        $payment = Payment::where('payment_id', $paymentDTO->paymentId)
            ->where('merchant_id', $merchantId->id)
            ->first();
        if (!$payment) {
            abort(404, "Payment not found");
        }
        $paymentStatusId = $this->paymentStatusService
            ->firstOrCreate($this->getMySystemStatusName($paymentDTO->paymentStatus));
        $payment->update(
            [
                'merchant_id' => $merchantId->id,
                'payment_status_id' => $paymentStatusId->id,
                'amount' => $paymentDTO->amount,
                'amount_paid' => $paymentDTO->amount_paid,
            ]
        );
        return $payment;
    }

    private function getMySystemStatusName(string $statusName): string {
        $merchantStatusNameMappings = config('paymentStatusNameMappings');
        return $merchantStatusNameMappings[$statusName] ?? $statusName;
    }
}

