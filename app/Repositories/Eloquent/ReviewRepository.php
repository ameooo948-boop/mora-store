<?php

namespace App\Repositories\Eloquent;

use App\Enums\ReviewStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(
        Review $review,
        array $data,
    ): bool {

        return $review->update($data);
    }

    public function delete(
        Review $review,
    ): bool {

        return $review->delete();
    }

    public function find(
        int $id,
    ): ?Review {

        return Review::with([
            'product',
            'user',
            'approvedBy',
        ])->find($id);
    }

    public function findByUser(
        Product $product,
        User $user,
    ): ?Review {

        return Review::where(
            'product_id',
            $product->id
        )
            ->where(
                'user_id',
                $user->id
            )
            ->first();
    }

    public function paginateAdmin(
        int $perPage = 10,
        ?string $search = null,
        ?ReviewStatus $status = null,
    ): LengthAwarePaginator {

        return Review::query()

            ->with([
                'product',
                'user',
                'approvedBy',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('product', function ($product) use ($search) {

                        $product->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })

                        ->orWhereHas('user', function ($user) use ($search) {

                            $user->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })

            ->when($status, function ($query) use ($status) {

                $query->where(
                    'status',
                    $status
                );
            })

            ->latest()

            ->paginate($perPage)

            ->withQueryString();
    }

    public function approvedByProduct(
        Product $product,
    ) {
        return Review::query()

            ->with('user')

            ->where(
                'product_id',
                $product->id
            )

            ->where(
                'status',
                ReviewStatus::Approved
            )

            ->latest()

            ->paginate(10);
    }

    public function averageRating(
        Product $product,
    ): float {

        return (float) Review::query()

            ->where(
                'product_id',
                $product->id
            )

            ->where(
                'status',
                ReviewStatus::Approved
            )

            ->avg('rating');
    }

    public function reviewsCount(
        Product $product,
    ): int {

        return Review::query()

            ->where(
                'product_id',
                $product->id
            )

            ->where(
                'status',
                ReviewStatus::Approved
            )

            ->count();
    }

    public function approvedCount(): int
    {
        return Review::where(
            'status',
            ReviewStatus::Approved
        )->count();
    }

    public function pendingCount(): int
    {
        return Review::where(
            'status',
            ReviewStatus::Pending
        )->count();
    }

    public function rejectedCount(): int
    {
        return Review::where(
            'status',
            ReviewStatus::Rejected
        )->count();
    }
}
