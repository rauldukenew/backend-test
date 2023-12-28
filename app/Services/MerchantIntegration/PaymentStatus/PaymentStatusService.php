<?php

namespace App\Services\MerchantIntegration\PaymentStatus;

use App\Models\PaymentStatus;

class PaymentStatusService
{
    public function firstOrCreate(string $title): PaymentStatus
    {
        return PaymentStatus::firstOrCreate([
            'title' => $title
        ]);
    }
}
