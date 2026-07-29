<?php

namespace App\Services\Payments;
 
use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;

class CashOnDeliveryGateway implements PaymentGatewayInterface
{
    public function pay(
        Order $order,
        Payment $payment,
    ): mixed {

        return route('orders.show', $order);
    }
}
