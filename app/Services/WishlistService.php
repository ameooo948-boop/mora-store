<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WishlistService
{
    public function __construct(
        private readonly WishlistRepositoryInterface $repository
    ) {}

    public function paginate(User $user): LengthAwarePaginator
    {
        return $this->repository->paginate($user);
    }

    public function toggle(User $user, Product $product): bool
    {
        $wishlist = $this->repository->find($user, $product);

        if ($wishlist) {
            $this->repository->delete($wishlist);

            return false;
        }

        $this->repository->create($user, $product);

        return true;
    }

    public function exists(User $user, Product $product): bool
    {
        return $this->repository->exists($user, $product);
    }
}
