<?php

namespace App\Services\MerchantIntegration\Merchant;

use App\Models\Merchant;

class MerchantService
{
    public function firstOrCreate(int $merchantId): Merchant
    {
        return Merchant::firstOrCreate([
            'merchant_id' => $merchantId
        ]);
    }
}
