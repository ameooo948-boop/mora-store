<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function find(Cart $cart, Product $product): ?CartItem
    {
        return $cart->items()
            ->where('product_id', $product->id)
            ->first();
    }

    public function create(array $data): CartItem
    {
        return CartItem::create($data);
    }

    public function update(CartItem $cartItem, array $data): bool
    {
        return $cartItem->update($data);
    }

    public function delete(CartItem $cartItem): bool
    {
        return $cartItem->delete();
    }

    public function clear(Cart $cart): bool
    {
        return $cart->items()->delete();
    }

    public function getItems(Cart $cart): Collection
    {
        return $cart->items()
            ->with([
                'product',
                'product.images',
            ])
            ->get();
    }

    public function findByUserForUpdate(int $userId): ?Cart
    {
        return Cart::query()
            ->where('user_id', $userId)
            ->with([
                'items.product',
            ])
            ->lockForUpdate()
            ->first();
    }
}
