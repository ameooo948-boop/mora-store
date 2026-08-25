<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;
use InvalidArgumentException;
use Stripe\Checkout\Session;
use Stripe\Refund;
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

        $currency = strtolower(
            (string) setting('currency', 'EGP')
        );

        $allowedCurrencies = [
            'egp',
            'usd',
            'sar',
        ];

        if (! in_array($currency, $allowedCurrencies, true)) {
            throw new InvalidArgumentException(
                "Unsupported payment currency: {$currency}"
            );
        }

        $session = Session::create([

            'mode' => 'payment',

            'payment_method_types' => ['card'],

            'line_items' => [[

                'quantity' => 1,

                'price_data' => [

                    'currency' => $currency,

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

    public function refund(Payment $payment): void
    {
        if (! $payment->transaction_id) {
            throw new InvalidArgumentException(
                'Payment transaction ID is missing.'
            );
        }

        Stripe::setApiKey(
            config('services.stripe.secret')
        );

        Refund::create([
            'payment_intent' => $this->getPaymentIntentId(
                $payment->transaction_id
            ),
        ]);
    }

    private function getPaymentIntentId(string $sessionId): string
    {
        $session = Session::retrieve($sessionId);

        if (! $session->payment_intent) {
            throw new InvalidArgumentException(
                'Stripe payment intent was not found.'
            );
        }

        return $session->payment_intent;
    }
}
