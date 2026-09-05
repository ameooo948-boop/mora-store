<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Events\PaymentCreated;
use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Services\Payments\CashOnDeliveryGateway;
use App\Services\Payments\PaypalGateway;
use App\Services\Payments\StripeGateway;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PaymentService
{
    public function __construct(
        private readonly PaymentRepositoryInterface $paymentRepository,
    ) {}

    public function createPayment(Order $order, PaymentMethod $method): Payment
    {
        if ($this->getOrderPayment($order)) {
            throw new InvalidArgumentException('A payment already exists for this order.');
        }

        $payment = $this->paymentRepository->create([
            'order_id' => $order->id,
            'amount' => round((float) $order->total, 2),
            'payment_method' => $method,
            'status' => PaymentStatus::Pending,
        ]);

        PaymentCreated::dispatch($payment);

        return $payment;
    }

    public function markAsPaid(Payment $payment): Payment
    {
        if ($payment->status->isPaid()) {
            return $payment->fresh();
        }

        if ($payment->status->isRefunded()) {
            throw new InvalidArgumentException('A refunded payment cannot be marked as paid.');
        }

        return DB::transaction(function () use ($payment) {
            $locked = Payment::query()->lockForUpdate()->findOrFail($payment->id);

            if ($locked->status->isPaid()) {
                return $locked->fresh();
            }

            $updated = $this->paymentRepository->update($locked, [
                'status' => PaymentStatus::Paid,
                'paid_at' => $locked->paid_at ?? now(),
            ]);

            return $updated->fresh();
        });
    }

    public function markAsFailed(Payment $payment): Payment
    {
        if ($payment->status->isPaid() || $payment->status->isRefunded()) {
            return $payment->fresh();
        }

        return $this->paymentRepository->update($payment, [
            'status' => PaymentStatus::Failed,
        ]);
    }

    public function getOrderPayment(Order $order): ?Payment
    {
        return $this->paymentRepository->findByOrder($order);
    }

    public function availableMethods(): array
    {
        // PayPal is intentionally omitted until the gateway is implemented.
        return [
            PaymentMethod::CashOnDelivery,
            PaymentMethod::Stripe,
        ];
    }

    public function gateway(PaymentMethod $method): PaymentGatewayInterface
    {
        return match ($method) {
            PaymentMethod::CashOnDelivery => app(CashOnDeliveryGateway::class),
            PaymentMethod::Stripe => app(StripeGateway::class),
            PaymentMethod::Paypal => app(PaypalGateway::class),
        };
    }

    public function processPayment(Payment $payment, string $channel = 'web'): mixed
    {
        return $this->gateway($payment->payment_method)->pay(
            $payment->order,
            $payment,
            ['channel' => $channel],
        );
    }

    public function findByTransactionId(string $transactionId): ?Payment
    {
        return $this->paymentRepository->findByTransactionId($transactionId);
    }

    public function paginate(int $perPage = 10, ?string $search = null)
    {
        return $this->paymentRepository->paginate($perPage, $search);
    }

    public function refund(Payment $payment): void
    {
        if ($payment->status->isRefunded()) {
            return;
        }

        if ($payment->status !== PaymentStatus::Paid) {
            throw new InvalidArgumentException('Only paid payments can be refunded.');
        }

        if ($payment->payment_method === PaymentMethod::Stripe) {
            app(StripeGateway::class)->refund($payment);
        }

        $this->paymentRepository->update($payment, [
            'status' => PaymentStatus::Refunded,
        ]);
    }
}
