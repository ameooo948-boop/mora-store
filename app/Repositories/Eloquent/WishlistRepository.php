<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WishlistRepository implements WishlistRepositoryInterface
{
    public function paginate(User $user, int $perPage = 12): LengthAwarePaginator
    {
        return $user->wishlists()
            ->whereHas('product')
            ->with([
                'product.images',
                'product.category',
            ])
            ->latest()
            ->paginate($perPage);
    }

    public function find(User $user, Product $product): ?Wishlist
    {
        return $user->wishlists()
            ->where('product_id', $product->id)
            ->first();
    }

    public function create(User $user, Product $product): Wishlist
    {
        return Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function delete(Wishlist $wishlist): bool
    {
        return $wishlist->delete();
    }

    public function exists(User $user, Product $product): bool
    {
        return $user->wishlists()
            ->where('product_id', $product->id)
            ->exists();
    }
}
