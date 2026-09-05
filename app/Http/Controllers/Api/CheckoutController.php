<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Order\PlaceOrderData;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CheckoutRequest;
use App\Http\Resources\OrderResource;
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
        return response()->json(
            $this->checkoutService->getCheckoutData($request->user())
        );
    }

    public function store(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->placeOrder(
                $request->user(),
                new PlaceOrderData(
                    addressId: $request->integer('address_id'),
                    paymentMethod: PaymentMethod::from($request->string('payment_method')->value()),
                    couponCode: $request->input('coupon'),
                ),
            );

            $order->load('payment');

            $redirectUrl = $this->paymentService->processPayment($order->payment, 'api');

            return response()->json([
                'message' => 'Order placed successfully.',
                'order' => new OrderResource($order),
                'redirect_url' => $redirectUrl,
            ], 201);
        } catch (\Throwable $exception) {
            report($exception);

            if (isset($order)) {
                try {
                    $this->orderService->cancelUnpaidOrder($order);
                    $order->refresh();
                } catch (\Throwable $cancelException) {
                    report($cancelException);
                }

                return response()->json([
                    'message' => 'Unable to initialize payment.',
                    'order' => new OrderResource($order),
                ], 422);
            }

            return response()->json([
                'message' => 'Unable to place your order.',
            ], 422);
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => ['required', 'string'],
        ]);

        $cart = $this->cartService->getCart($request->user()->id);

        $totals = $this->cartService->calculateTotals($cart);

        $coupon = $this->couponService->applyCoupon(
            $request->coupon_code,
            $totals['subtotal']
        );

        return response()->json([
            'message' => 'Coupon applied successfully.',
            'coupon' => [
                'id' => $coupon['coupon']->id,
                'code' => $coupon['coupon']->code,
                'discount' => $coupon['discount'] ?? null,
            ],
        ]);
    }

    public function removeCoupon()
    {
        return response()->json([
            'message' => 'Coupon removed successfully.',
        ]);
    }
}
