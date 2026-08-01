<?php

namespace App\Repositories\Contracts;

use App\Enums\ReviewStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewRepositoryInterface
{
    public function create(array $data): Review;

    public function update(
        Review $review,
        array $data,
    ): bool;

    public function delete(
        Review $review,
    ): bool;

    public function find(
        int $id,
    ): ?Review;

    public function findByUser(
        Product $product,
        User $user,
    ): ?Review;

    public function paginateAdmin(
        int $perPage = 10,
        ?string $search = null,
        ?ReviewStatus $status = null,
    ): LengthAwarePaginator;

    public function approvedByProduct(
        Product $product,
    );

    public function averageRating(
        Product $product,
    ): float;

    public function reviewsCount(
        Product $product,
    ): int;

    public function pendingCount(): int;

    public function approvedCount(): int;

    public function rejectedCount(): int;
}
