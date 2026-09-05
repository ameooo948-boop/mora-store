<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\OrderService;

class PaymentController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    /**
     * Stripe sends the browser here after a cancelled Checkout session.
     * The signed URL is the authorization mechanism because Stripe cannot
     * send the user's Sanctum token/session.
     */
    public function cancel(Payment $payment)
    {
        $this->orderService->cancelUnpaidOrder($payment->order);

        $frontendUrl = rtrim((string) config('app.frontend_url'), '/');

        return redirect("{$frontendUrl}/orders/{$payment->order_id}?status=cancelled&payment_id={$payment->id}");
    }
}
