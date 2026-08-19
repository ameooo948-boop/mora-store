<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeGateway implements PaymentGatewayInterface
{
    public function pay(
        Order $order,
        Payment $payment,
    ): mixed {

        Stripe::setApiKey(
            config('services.stripe.secret')
        );

        $session = Session::create([

            'mode' => 'payment',

            'payment_method_types' => ['card'],

            'line_items' => [[

                'quantity' => 1,

                'price_data' => [

                    'currency' => 'usd',

                    'unit_amount' => (int) ($payment->amount * 100),

                    'product_data' => [

                        'name' => "Order #{$order->id}",

                    ],

                ],

            ]],

            'success_url' => route(
                'payments.success',
                ['payment' => $payment->id]
            ),

            'cancel_url' => route(
                'payments.cancel',
                ['payment' => $payment->id]
            ),

            'metadata' => [

                'payment_id' => $payment->id,

                'order_id' => $order->id,

            ],

        ]);

        $payment->update([
            'transaction_id' => $session->id,
            'gateway_response' => $session->toArray(),
        ]);

        return $session->url;
    }
}
