<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function pay(Order $order, Payment $payment): mixed;
}
