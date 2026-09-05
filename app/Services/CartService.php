<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use DomainException;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly CartItemRepositoryInterface $cartItemRepository,
    ) {}

    public function add(int $userId, Product $product, int $quantity = 1): Cart
    {
        if ($quantity < 1) {
            throw new DomainException('Quantity must be at least 1.');
        }

        return DB::transaction(function () use ($userId, $product, $quantity) {
            $cart = $this->cartRepository->getOrCreate($userId);
            $cartItem = $this->cartItemRepository->find($cart, $product);

            if (! $product->status) {
                throw new DomainException('This product is unavailable.');
            }

            $available = max(0, $product->quantity - ($cartItem?->quantity ?? 0));

            if ($quantity > $available) {
                throw new DomainException("You can only add {$available} more item(s).");
            }

            if ($cartItem) {
                $this->cartItemRepository->update($cartItem, [
                    'quantity' => $cartItem->quantity + $quantity,
                ]);
            } else {
                $this->cartItemRepository->create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }

            return $cart->fresh();
        });
    }

    public function getCart(int $userId): Cart
    {
        return $this->cartRepository->getOrCreate($userId)
            ->load([
                'items.product.category',
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

    public function updateQuantity(int $userId, Product $product, int $quantity): bool
    {
        if ($quantity < 1) {
            throw new DomainException('Quantity must be at least 1.');
        }

        return DB::transaction(function () use ($userId, $product, $quantity) {
            $cart = $this->cartRepository->getOrCreate($userId);
            $item = $this->cartItemRepository->find($cart, $product);

            if (! $item) {
                return false;
            }

            if (! $product->status) {
                throw new DomainException('This product is unavailable.');
            }

            if ($quantity > $product->quantity) {
                throw new DomainException("Only {$product->quantity} item(s) available.");
            }

            return $this->cartItemRepository->update($item, [
                'quantity' => $quantity,
            ]);
        });
    }

    /**
     * Calculate checkout totals from server-side settings.
     * The returned values are always rounded to two decimal places.
     */
    public function calculateTotals(Cart $cart, float $discount = 0): array
    {
        $subtotal = round((float) $cart->items->sum(
            fn ($item) => (float) $item->product->final_price * (int) $item->quantity
        ), 2);

        $discount = round(min(max(0, $discount), $subtotal), 2);
        $shipping = $cart->items->isEmpty()
            ? 0.0
            : round((float) setting('shipping_cost', 0), 2);

        $taxPercentage = min(
            max(0, (float) setting('tax_percentage', 0)),
            100
        );

        $taxableSubtotal = round(max(0, $subtotal - $discount), 2);
        $tax = round($taxableSubtotal * ($taxPercentage / 100), 2);
        $total = round($taxableSubtotal + $shipping + $tax, 2);

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'tax' => $tax,
            'tax_percentage' => $taxPercentage,
            'total' => $total,
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
        $cart = $this->cartItemRepository->findByUserForUpdate($userId);

        if (! $cart) {
            throw new DomainException('Cart not found.');
        }

        $cart->load([
            'items' => fn ($query) => $query->orderBy('product_id'),
            'items.product.category',
            'items.product.images',
        ]);

        return $cart;
    }
}
