<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function success(
        Payment $payment,
    ) {
        return redirect()
            ->route(
                'orders.show',
                $payment->order
            )
            ->with(
                'success',
                'Your payment has been received successfully.'
            );
    }

    public function cancel(
        Payment $payment,
    ) {
        if ($payment->status->isPending()) {

            $this->paymentService
                ->markAsFailed(
                    $payment
                );
        }

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
