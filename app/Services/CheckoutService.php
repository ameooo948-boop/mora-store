<?php

namespace App\Services;

use App\Models\User;

class CheckoutService
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly CouponService $couponService,
        private readonly AddressService $addressService,
        private readonly PaymentService $paymentService,
    ) {}

    public function getCheckoutData(User $user): array
    {
        $cart = $this->cartService->getCart($user->id);

        $totals = $this->cartService->calculateTotals($cart);

        $coupon = null;

        if (session()->has('coupon')) {

            try {

                $coupon = $this->couponService->applyCoupon(
                    session('coupon.code'),
                    $totals['subtotal']
                );

                $totals['discount'] = $coupon['discount'];

                $totals['total'] =
                    $totals['subtotal']
                    - $coupon['discount']
                    + $totals['shipping'];
            } catch (\Throwable) {

                session()->forget('coupon');
            }
        }

        return [

            'cart' => $cart,

            'totals' => $totals,

            'coupon' => $coupon,

            'addresses' => $this->addressService
                ->getUserAddresses($user),

            'paymentMethods' => $this->paymentService
                ->availableMethods(),

        ];
    }
}
