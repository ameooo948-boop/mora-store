<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CheckoutRequest;
use App\Services\CheckoutService;
use App\Services\CouponService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Services\CartService;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
        private readonly OrderService $orderService,
        private readonly CartService $cartService,
        private readonly CouponService $couponService,
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
        CheckoutRequest $request
    ) {

        $order = $this->orderService->placeOrder(

            $request->user(),

            $request->integer('address_id'),

            session('coupon.code')

        );

        session()->forget('coupon');

        return redirect()

            ->route('orders.show', $order)

            ->with(
                'success',
                'Order placed successfully.'
            );
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
