<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly CartItemRepositoryInterface $cartItemRepository,
    ) {}

    public function add(int $userId, Product $product, int $quantity = 1): Cart
    {
        return DB::transaction(function () use ($userId, $product, $quantity) {

            $cart = $this->cartRepository->getOrCreate($userId);

            $cartItem = $this->cartItemRepository->find($cart, $product);

            $newQuantity = ($cartItem?->quantity ?? 0) + $quantity;

            if (! $product->status) {
                throw new \Exception('This product is unavailable.');
            }

            if ($quantity > $product->quantity) {
                throw new \Exception('Not enough stock available.');
            }

            if ($newQuantity > $product->quantity) {
                throw new \Exception('Not enough stock available.');
            }

            if ($cartItem) {

                $this->cartItemRepository->update($cartItem, [
                    'quantity' => $cartItem->quantity + $quantity,
                ]);
            } else {

                $this->cartItemRepository->create([
                    'cart_id'    => $cart->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $product->sale_price ?: $product->price,
                ]);
            }

            return $cart->fresh();
        });
    }

    public function getCart(int $userId): ?Cart
    {
        return $this->cartRepository->getOrCreate($userId)
            ->load([
                'items.product',
                'items.product.images',
            ]);
    }

    public function clear(int $userId): bool
    {
        return DB::transaction(function () use ($userId) {

            $cart = $this->cartRepository->getOrCreate($userId);

            return $this->cartItemRepository->clear($cart);
        });
    }

    public function remove(int $userId, Product $product): bool
    {
        return DB::transaction(function () use ($userId, $product) {

            $cart = $this->cartRepository->getOrCreate($userId);

            $item = $this->cartItemRepository->find($cart, $product);

            if (! $item) {
                return false;
            }

            return $this->cartItemRepository->delete($item);
        });
    }

    public function updateQuantity(
        int $userId,
        Product $product,
        int $quantity
    ): bool {

        return DB::transaction(function () use ($userId, $product, $quantity) {

            $cart = $this->cartRepository->getOrCreate($userId);

            $item = $this->cartItemRepository->find($cart, $product);

            if ($quantity > $product->quantity) {
                throw new \Exception('Not enough stock available.');
            }

            if (! $item) {
                return false;
            }

            return $this->cartItemRepository->update($item, [
                'quantity' => $quantity,
            ]);
        });
    }

    public function calculateTotals(Cart $cart): array
    {
        $subtotal = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return [
            'subtotal' => $subtotal,
            'shipping' => 0,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }
}
