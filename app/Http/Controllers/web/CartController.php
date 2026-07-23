<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCartRequest;
use App\Http\Requests\Web\UpdateCartRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart(
            $request->user()->id
        );

        $totals = $this->cartService->calculateTotals($cart);

        return view('web.carts.index', compact(
            'cart',
            'totals'
        ));
    }

    public function store(StoreCartRequest $request, Product $product)
    {
        try {

            $this->cartService->add(
                $request->user()->id,
                $product,
                $request->validated('quantity')
            );

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart.',
                    'cartCount' => $this->cartService->count(
                        $request->user()->id
                    ),
                ]);
            }

            return back()->with(
                'success',
                'Product added to cart.'
            );
        } catch (\Throwable $e) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->withErrors([
                'cart' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateCartRequest $request, Product $product)
    {
        $this->cartService->updateQuantity(
            $request->user()->id,
            $product,
            $request->validated('quantity')
        );

        return back()->with(
            'success',
            'Cart updated successfully.'
        );
    }

    public function destroy(Request $request, Product $product)
    {
        $this->cartService->remove(
            $request->user()->id,
            $product
        );

        return back()->with(
            'success',
            'Product removed from cart.'
        );
    }

    public function clear(Request $request)
    {
        $this->cartService->clear(
            $request->user()->id
        );

        return back()->with(
            'success',
            'Cart cleared successfully.'
        );
    }
}
