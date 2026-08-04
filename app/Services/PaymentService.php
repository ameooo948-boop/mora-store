<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentGatewayInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Services\NotificationService;
use App\Services\Payments\CashOnDeliveryGateway;
use App\Services\Payments\PaypalGateway;
use App\Services\Payments\StripeGateway;

class PaymentService
{
    public function __construct(
        private readonly PaymentRepositoryInterface $paymentRepository,
        private readonly NotificationService $notificationService,
    ) {}

    public function createPayment(
        Order $order,
        PaymentMethod $method,
    ): Payment {
        $payment = $this->paymentRepository->create([

            'order_id' => $order->id,

            'amount' => $order->total,

            'payment_method' => $method,

            'status' => PaymentStatus::Pending,

        ]);

        $this->notificationService->newPayment($payment);

        return $payment;
    }

    public function markAsPaid(
        Payment $payment,
    ): Payment {

        if ($payment->status->isPaid()) {
            return $payment;
        }

        return $this->paymentRepository->update(
            $payment,
            [
                'status' => PaymentStatus::Paid,
                'paid_at' => now(),
            ]
        );
    }

    public function markAsFailed(Payment $payment): void
    {
        $this->paymentRepository->update($payment, [

            'status' => PaymentStatus::Failed,

        ]);
    }

    public function refund(Payment $payment): void
    {
        $this->paymentRepository->update($payment, [

            'status' => PaymentStatus::Refunded,

        ]);
    }

    public function getOrderPayment(Order $order): ?Payment
    {
        return $this->paymentRepository->findByOrder($order);
    }

    public function availableMethods(): array
    {
        return [

            PaymentMethod::CashOnDelivery,

            PaymentMethod::Stripe,

            PaymentMethod::Paypal,

        ];
    }

    public function gateway(
        PaymentMethod $method,
    ): PaymentGatewayInterface {

        return match ($method) {

            PaymentMethod::CashOnDelivery
            => app(CashOnDeliveryGateway::class),

            PaymentMethod::Stripe
            => app(StripeGateway::class),

            PaymentMethod::Paypal
            => app(PaypalGateway::class),
        };
    }

    public function processPayment(
        Payment $payment
    ): mixed {
        return $this->gateway(
            $payment->payment_method
        )->pay(
            $payment->order,
            $payment
        );
    }

    public function findByTransactionId(
        string $transactionId,
    ): ?Payment {

        return $this->paymentRepository
            ->findByTransactionId(
                $transactionId
            );
    }

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
    ) {
        return $this->paymentRepository
            ->paginate(
                $perPage,
                $search
            );
    }
}
