<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    public function success(
        Payment $payment,
    ) {
        $this->authorize('view', $payment);

        return redirect()
            ->route(
                'orders.show',
                $payment->order
            )
            ->with(
                'success',
                'Payment was submitted. We are confirming it now.'
            );
    }

    public function cancel(
        Payment $payment,
    ) {
        $this->authorize('view', $payment);

        $this->orderService->cancelUnpaidOrder($payment->order);

        return redirect()
            ->route(
                'orders.show',
                $payment->order
            )
            ->with(
                'error',
                'Payment was cancelled.'
            );
    }
}
