<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function success(Payment $payment)
    {
        $this->authorize('view', $payment);

        return redirect(config('app.frontend_url')."/orders/{$payment->order_id}?status=success");
    }

    public function cancel(Payment $payment)
    {
        $this->authorize('view', $payment);

        if ($payment->status->isPending()) {
            $this->paymentService->markAsFailed($payment);
        }

        return redirect(config('app.frontend_url')."/orders/{$payment->order_id}?status=cancelled");
    }
}
