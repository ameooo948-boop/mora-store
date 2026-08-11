<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_pending_payment_can_be_marked_as_paid(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = $user->orders()->create([
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

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
            'amount' => 100,
            'payment_method' => PaymentMethod::CashOnDelivery,
            'status' => PaymentStatus::Pending,
        ]);

        $updatedPayment = app(PaymentService::class)
            ->markAsPaid($payment);

        $this->assertSame(
            PaymentStatus::Paid,
            $updatedPayment->status
        );

        $this->assertNotNull(
            $updatedPayment->paid_at
        );

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatus::Paid->value,
        ]);
    }

    public function test_pending_payment_can_be_marked_as_failed(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = $user->orders()->create([
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

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
            'amount' => 100,
            'payment_method' => PaymentMethod::CashOnDelivery,
            'status' => PaymentStatus::Pending,
        ]);

        app(PaymentService::class)->markAsFailed($payment);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatus::Failed->value,
        ]);
    }

    public function test_paid_payment_can_be_refunded(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = $user->orders()->create([
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

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
            'amount' => 100,
            'payment_method' => PaymentMethod::CashOnDelivery,
            'status' => PaymentStatus::Paid,
            'paid_at' => now(),
        ]);

        app(PaymentService::class)->refund($payment);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatus::Refunded->value,
        ]);
    }
}
