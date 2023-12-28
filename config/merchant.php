<?php

return [
    'merchantA' => [
        'id' => env('MERCHANT_A_ID'),
        'key' => env('MERCHANT_A_KEY'),
        'algo' => env('MERCHANT_A_ALGO'),
        'delimiter' => env('MERCHANT_A_DELIMITER'),
        'requestHandler' => 'App\Services\MerchantIntegration\MerchantARequestHandler',
        'requestParser' => 'App\Services\MerchantIntegration\DummyMerchantRequestParser',
        'limit' => 1000
    ],
    'merchantB' => [
        'id' => env('MERCHANT_B_ID'),
        'key' => env('MERCHANT_B_KEY'),
        'algo' => env('MERCHANT_B_ALGO'),
        'delimiter' => env('MERCHANT_B_DELIMITER'),
        'requestHandler' => 'App\Services\MerchantIntegration\MerchantBRequestHandler',
        'requestParser' => 'App\Services\MerchantIntegration\MerchantBRequestParser',
        'limit' => 500
    ],
];
