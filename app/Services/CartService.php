<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;
use DomainException;

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

            $available = $product->quantity - ($cartItem?->quantity ?? 0);

            if (! $product->status) {
                throw new \Exception('This product is unavailable.');
            }

            if ($quantity > $available) {

                throw new \Exception(
                    "You can only add {$available} more item(s)."
                );
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
                ]);
            }

            return $cart->fresh();
        });
    }

    public function getCart(int $userId): ?Cart
    {
        $cart = $this->cartRepository->getOrCreate($userId)
            ->load([
                'items.product',
                'items.product.images',
            ]);

        return $cart;
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

                throw new \Exception(
                    "Only {$product->quantity} item(s) available."
                );
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
            return $item->product->final_price * $item->quantity;
        });

        return [
            'subtotal' => $subtotal,
            'shipping' => 0,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }

    public function count(int $userId): int
    {
        return $this->cartRepository
            ->getOrCreate($userId)
            ->items()
            ->sum('quantity');
    }

    public function getCartForUpdate(int $userId): Cart
    {
        $cart = $this->cartItemRepository
            ->findByUserForUpdate($userId);

        if (! $cart) {
            throw new DomainException('Cart not found.');
        }

        return $cart->load([
            'items.product',
            'items.product.images',
        ]);
    }
}
