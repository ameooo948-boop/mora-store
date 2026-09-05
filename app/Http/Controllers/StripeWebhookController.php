<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly OrderService $orderService,
    ) {}

    public function __invoke(Request $request): Response
    {
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        if (! $signature || ! $secret) {
            return response('Webhook is not configured.', 500);
        }

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $signature,
                $secret,
            );
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe webhook signature verification failed.', [
                'message' => $e->getMessage(),
            ]);

            return response('Invalid signature.', 400);
        } catch (\UnexpectedValueException $e) {
            Log::warning('Stripe webhook payload was invalid.', [
                'message' => $e->getMessage(),
            ]);

            return response('Invalid payload.', 400);
        }

        try {
            $object = $event->data->object;

            switch ($event->type) {
                case 'checkout.session.completed':
                    $payment = $this->paymentService->findByTransactionId((string) $object->id);

                    if (! $payment) {
                        Log::warning('Stripe payment session was not found.', [
                            'session_id' => $object->id,
                            'event_id' => $event->id,
                        ]);

                        return response('Payment not found.', 404);
                    }

                    if (($object->payment_status ?? null) === 'paid') {
                        $this->confirmPaidPayment($payment);
                    }
                    break;

                case 'checkout.session.expired':
                    $payment = $this->paymentService->findByTransactionId((string) $object->id);

                    if ($payment) {
                        $this->orderService->cancelUnpaidOrder($payment->order);
                    }
                    break;

                case 'payment_intent.succeeded':
                    $paymentId = $object->metadata->payment_id ?? null;

                    if ($paymentId) {
                        $payment = Payment::find($paymentId);

                        if ($payment) {
                            $this->confirmPaidPayment($payment);
                        }
                    }
                    break;

                case 'payment_intent.payment_failed':
                    $paymentId = $object->metadata->payment_id ?? null;

                    if ($paymentId) {
                        $payment = Payment::find($paymentId);

                        if ($payment) {
                            $this->paymentService->markAsFailed($payment);
                        }
                    }
                    break;

                case 'payment_intent.canceled':
                    $paymentId = $object->metadata->payment_id ?? null;

                    if ($paymentId) {
                        $payment = Payment::find($paymentId);

                        if ($payment) {
                            $this->orderService->cancelUnpaidOrder($payment->order);
                        }
                    }
                    break;
            }
        } catch (\Throwable $e) {
            Log::error('Stripe webhook processing failed.', [
                'event_id' => $event->id ?? null,
                'event_type' => $event->type ?? null,
                'message' => $e->getMessage(),
            ]);

            // Return 500 so Stripe retries transient processing failures.
            return response('Webhook processing failed.', 500);
        }

        return response('Webhook received.', 200);
    }

    private function confirmPaidPayment(Payment $payment): void
    {
        $payment = $this->paymentService->markAsPaid($payment);
        $order = $payment->order()->first();

        if ($order && $order->status === OrderStatus::Pending) {
            $this->orderService->updateStatus($order, OrderStatus::Processing);
        }
    }
}
