<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCartRequest;
use App\Http\Requests\Web\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Services\CartService;
use DomainException;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request->user()->id);

        $totals = $this->cartService->calculateTotals($cart);

        return response()->json([
            'cart' => new CartResource($cart),
            'totals' => $totals,
        ]);
    }

    public function store(StoreCartRequest $request, Product $product)
    {
        try {
            $this->cartService->add(
                $request->user()->id,
                $product,
                $request->validated('quantity')
            );

            return response()->json([
                'message' => 'Product added to cart.',
                'cart_count' => $this->cartService->count($request->user()->id),
            ]);
        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to update cart.',
            ], 500);
        }
    }

    public function update(UpdateCartRequest $request, Product $product)
    {
        try {
            $this->cartService->updateQuantity(
                $request->user()->id,
                $product,
                $request->validated('quantity')
            );

            $cart = $this->cartService->getCart($request->user()->id);

            $item = $cart->items->firstWhere('product_id', $product->id);

            $totals = $this->cartService->calculateTotals($cart);

            return response()->json([
                'message' => 'Cart updated successfully.',
                'item_total' => number_format($item->product->final_price * $item->quantity, 2),
                'currency' => setting('currency'),
                'summary' => [
                    'items' => $cart->items->count(),
                    'quantity' => $cart->items->sum('quantity'),
                    'subtotal' => number_format($totals['subtotal'], 2),
                    'total' => number_format($totals['total'], 2),
                ],
                'cart_count' => $this->cartService->count($request->user()->id),
            ]);
        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Unable to update cart.',
            ], 500);
        }
    }

    public function destroy(Request $request, Product $product)
    {
        $this->cartService->remove($request->user()->id, $product);

        $cart = $this->cartService->getCart($request->user()->id);

        $totals = $this->cartService->calculateTotals($cart);

        return response()->json([
            'message' => 'Product removed from cart.',
            'summary' => [
                'items' => $cart->items->count(),
                'quantity' => $cart->items->sum('quantity'),
                'subtotal' => number_format($totals['subtotal'], 2),
                'total' => number_format($totals['total'], 2),
            ],
            'cart_count' => $this->cartService->count($request->user()->id),
        ]);
    }

    public function clear(Request $request)
    {
        $this->cartService->clear($request->user()->id);

        return response()->json([
            'message' => 'Cart cleared successfully.',
            'cart_count' => 0,
        ]);
    }
}
