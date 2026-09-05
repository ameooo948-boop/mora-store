<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripeWebhookTest extends TestCase
{
    use RefreshDatabase;

    private string $webhookSecret = 'whsec_test_secret';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.stripe.webhook_secret' => $this->webhookSecret,
        ]);
    }

    public function test_checkout_session_completed_marks_payment_as_paid(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-STRIPE-TEST',
            'subtotal' => 200,
            'shipping' => 0,
            'discount' => 0,
            'total' => 200,
            'status' => OrderStatus::Pending,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => 'cs_test_webhook_123',
            'amount' => 200,
            'payment_method' => PaymentMethod::Stripe,
            'status' => PaymentStatus::Pending,
            'paid_at' => null,
        ]);

        $payload = json_encode([
            'id' => 'evt_test_checkout_completed',
            'object' => 'event',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => $payment->transaction_id,
                    'object' => 'checkout.session',
                    'payment_status' => 'paid',
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $timestamp = time();

        $signature = 't='.$timestamp.',v1='.hash_hmac(
            'sha256',
            $timestamp.'.'.$payload,
            $this->webhookSecret,
        );

        $response = $this->call(
            'POST',
            '/stripe/webhook',
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_STRIPE_SIGNATURE' => $signature,
            ],
            $payload,
        );

        $response->assertOk();

        $payment->refresh();

        $this->assertSame(
            PaymentStatus::Paid,
            $payment->status
        );

        $this->assertNotNull(
            $payment->paid_at
        );

        $order->refresh();

        $this->assertSame(
            OrderStatus::Processing,
            $order->status
        );
    }

    public function test_invalid_stripe_webhook_signature_is_rejected(): void
    {
        $payload = json_encode([
            'id' => 'evt_invalid_signature',
            'object' => 'event',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_invalid',
                    'object' => 'checkout.session',
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $response = $this->call(
            'POST',
            '/stripe/webhook',
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_STRIPE_SIGNATURE' => 'invalid-signature',
            ],
            $payload,
        );

        $response
            ->assertStatus(400)
            ->assertSee('Invalid signature.');
    }

    public function test_checkout_session_completed_returns_404_when_payment_does_not_exist(): void
    {
        $payload = json_encode([
            'id' => 'evt_payment_not_found',
            'object' => 'event',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_payment_not_found',
                    'object' => 'checkout.session',
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $timestamp = time();

        $signature = 't='.$timestamp.',v1='.hash_hmac(
            'sha256',
            $timestamp.'.'.$payload,
            $this->webhookSecret,
        );
        $response = $this->call(
            'POST',
            '/stripe/webhook',
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_STRIPE_SIGNATURE' => $signature,
            ],
            $payload,
        );

        $response
            ->assertStatus(404)
            ->assertSee('Payment not found.');
    }
}
