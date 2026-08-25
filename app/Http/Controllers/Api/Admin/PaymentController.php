<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Payment::class);

        $payments = $this->paymentService->paginate(
            search: $request->string('search')->toString(),
        );

        return response()->json([
            'payments' => PaymentResource::collection($payments),
            'meta' => [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'total' => $payments->total(),
            ],
        ]);
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        $payment->load(['order', 'order.user']);

        return response()->json([
            'payment' => new PaymentResource($payment),
        ]);
    }
}
