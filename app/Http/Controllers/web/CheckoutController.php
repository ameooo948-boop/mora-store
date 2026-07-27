<?php

namespace App\Http\Controllers\Web;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CheckoutRequest;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\CouponService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
        private readonly OrderService $orderService,
        private readonly CartService $cartService,
        private readonly CouponService $couponService,
        private readonly PaymentService $paymentService,
    ) {}

    public function index(Request $request)
    {
        return view(
            'web.checkout.index',
            $this->checkoutService
                ->getCheckoutData($request->user())
        );
    }
    public function store(
        CheckoutRequest $request,
    ) {
        try {

            $order = $this->orderService->placeOrder(
                $request->user(),
                $request->integer('address_id'),
                PaymentMethod::from(
                    $request->string('payment_method')->value()
                ),
                session('coupon.code'),
            );

            session()->forget('coupon');

            $order->load('payment');

            $redirectUrl = $this->paymentService->processPayment(
                $order->payment
            );

            return redirect()->to($redirectUrl);
        } catch (\Throwable $exception) {

            report($exception);

            if (isset($order)) {

                return redirect()
                    ->route('orders.show', $order)
                    ->with(
                        'error',
                        'Unable to initialize payment.'
                    );
            }

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to place your order.'
                );
        }
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => ['required', 'string'],
        ]);

        $cart = $this->cartService->getCart(
            $request->user()->id
        );

        $totals = $this->cartService->calculateTotals($cart);

        $coupon = $this->couponService->applyCoupon(
            $request->coupon_code,
            $totals['subtotal']
        );

        session([
            'coupon' => [
                'id' => $coupon['coupon']->id,
                'code' => $coupon['coupon']->code,
            ],
        ]);

        return back()->with(
            'coupon_success',
            'Coupon applied successfully.'
        );
    }

    public function removeCoupon()
    {
        session()->forget('coupon');

        return back()->with(
            'success',
            'Coupon removed successfully.'
        );
    }
}
