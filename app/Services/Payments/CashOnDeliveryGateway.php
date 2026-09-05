<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;

class CashOnDeliveryGateway implements PaymentGatewayInterface
{
    public function pay(Order $order, Payment $payment, array $context = []): mixed
    {
        return ($context['channel'] ?? 'web') === 'api'
            ? url("/api/orders/{$order->id}")
            : route('orders.show', $order);
    }
}
