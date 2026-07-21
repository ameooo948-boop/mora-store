<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\AddressService;
use App\Services\OrderService;
use App\Http\Requests\Web\CheckoutRequest;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
        private readonly AddressService $addressService,
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart(
            $request->user()->id
        );

        if ($cart->items->isEmpty()) {
            return redirect()
                ->route('carts.index')
                ->with('error', 'Your cart is empty.');
        }

        $totals = $this->cartService->calculateTotals($cart);
        $addresses = $this->addressService->all(
            $request->user()
        );

        return view('web.checkout.index', compact(
            'cart',
            'totals',
            'addresses'
        ));
    }

    public function store(CheckoutRequest $request)
    {
        $order = $this->orderService->placeOrder(
            $request->user(),
            $request->integer('address_id')
        );

        return redirect()
            ->route('orders.show', $order)
            ->with(
                'success',
                'Order placed successfully.'
            );
    }
}
