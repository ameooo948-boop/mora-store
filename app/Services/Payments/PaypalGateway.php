<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;

class PaypalGateway implements PaymentGatewayInterface
{
    public function pay(
        Order $order,
        Payment $payment,
        array $context = [],
    ): mixed {

        throw new \RuntimeException(
            'PayPal gateway is not implemented yet.'
        );
    }
}
