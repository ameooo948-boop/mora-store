<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;
use InvalidArgumentException;
use Stripe\Checkout\Session;
use Stripe\Refund;
use Illuminate\Support\Facades\URL;
use Stripe\Stripe;

class StripeGateway implements PaymentGatewayInterface
{
    public function pay(Order $order, Payment $payment, array $context = []): mixed
    {
        $secret = config('services.stripe.secret');

        if (! $secret) {
            throw new InvalidArgumentException('Stripe is not configured.');
        }

        Stripe::setApiKey($secret);

        $currency = strtolower((string) setting('currency', 'EGP'));
        $allowedCurrencies = ['egp', 'usd', 'sar'];

        if (! in_array($currency, $allowedCurrencies, true)) {
            throw new InvalidArgumentException("Unsupported payment currency: {$currency}");
        }

        $channel = $context['channel'] ?? 'web';

        if ($channel === 'api') {
            $frontendUrl = rtrim((string) config('app.frontend_url'), '/');

            if ($frontendUrl === '') {
                throw new InvalidArgumentException('FRONTEND_URL is not configured.');
            }

            $successUrl = "{$frontendUrl}/orders/{$order->id}?status=success&payment_id={$payment->id}";
            $cancelUrl = URL::temporarySignedRoute(
                'api.payments.cancel',
                now()->addHours(2),
                ['payment' => $payment->id],
            );
        } else {
            $successUrl = route('payments.success', ['payment' => $payment->id]);
            $cancelUrl = route('payments.cancel', ['payment' => $payment->id]);
        }

        $session = Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => (int) round((float) $payment->amount * 100),
                    'product_data' => [
                        'name' => "Order #{$order->order_number}",
                    ],
                ],
            ]],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'expires_at' => now()->addMinutes((int) config('app.stripe_checkout_timeout_minutes', 30))->timestamp,
            'client_reference_id' => (string) $payment->id,
            'payment_intent_data' => [
                'metadata' => [
                    'payment_id' => (string) $payment->id,
                    'order_id' => (string) $order->id,
                ],
            ],
            'metadata' => [
                'payment_id' => (string) $payment->id,
                'order_id' => (string) $order->id,
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
            throw new InvalidArgumentException('Payment transaction ID is missing.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        Refund::create([
            'payment_intent' => $this->getPaymentIntentId($payment->transaction_id),
        ]);
    }

    private function getPaymentIntentId(string $sessionId): string
    {
        $session = Session::retrieve($sessionId);

        if (! $session->payment_intent) {
            throw new InvalidArgumentException('Stripe payment intent was not found.');
        }

        return $session->payment_intent;
    }
}
