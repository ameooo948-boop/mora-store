<?php

namespace App\DTOs\Order;

use App\Enums\PaymentMethod;

final readonly class PlaceOrderData
{
    public function __construct(
        public int $addressId,
        public PaymentMethod $paymentMethod,
        public ?string $couponCode = null,
    ) {}
}
