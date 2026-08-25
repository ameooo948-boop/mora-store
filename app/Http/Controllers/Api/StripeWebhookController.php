<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret'),
            );
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe Webhook Signature Failed', [
                'message' => $e->getMessage(),
            ]);

            return response('Invalid signature.', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $payment = $this->paymentService->findByTransactionId($session->id);

            if (! $payment) {
                return response('Payment not found.', 404);
            }

            $this->paymentService->markAsPaid($payment);
        }

        return response('Webhook received.', 200);
    }
}
