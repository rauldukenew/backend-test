<?php

namespace App\DTO\Payment;
class PaymentDTO
{
    public function __construct(
        public int $merchantId,
        public int $paymentId,
        public string $paymentStatus,
        public int $amount,
        public int $amount_paid,
    )
    {

    }
}
