<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected PaymentService $paymentService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Payment::class);

        return view('admin.payments.index', [
            'payments' => $this->paymentService->paginate(
                search: $request->string('search')->toString(),
            ),
        ]);
    }
 
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        $payment->load([
            'order',
            'order.user',
        ]);

        return view(
            'admin.payments.show',
            compact('payment')
        );
    }
}
