<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WishlistRepositoryInterface
{
    public function paginate(User $user, int $perPage = 12): LengthAwarePaginator;

    public function find(User $user, Product $product): ?Wishlist;

    public function create(User $user, Product $product): Wishlist;

    public function delete(Wishlist $wishlist): bool;

    public function exists(User $user, Product $product): bool;
}
