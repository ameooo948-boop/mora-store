<?php

namespace App\Repositories\Contracts;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface CartItemRepositoryInterface
{
    public function find(Cart $cart, Product $product): ?CartItem;

    public function create(array $data): CartItem;

    public function update(CartItem $cartItem, array $data): bool;

    public function delete(CartItem $cartItem): bool;

    public function clear(Cart $cart): bool;

    public function getItems(Cart $cart): Collection;

    public function findByUserForUpdate(int $userId): ?Cart;
}
