<?php

namespace App\Services;

use App\DTOs\Review\CreateReviewData;
use App\DTOs\Review\UpdateReviewData;
use App\Enums\ReviewStatus;
use App\Events\ReviewCreated;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Notifications\ReviewApprovedNotification;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    public function __construct(
        protected ReviewRepositoryInterface $repository,
        protected OrderRepositoryInterface $orderRepository,
        private readonly NotificationService $notificationService,
    ) {}

    public function create(
        Product $product,
        User $user,
        CreateReviewData $data,
    ): Review {

        if (
            ! $this->canReview(
                $product,
                $user
            )
        ) {

            throw new AuthorizationException(
                'You must purchase this product before reviewing it.'
            );
        }

        if (
            $this->repository->findByUser(
                $product,
                $user
            )
        ) {

            throw ValidationException::withMessages([
                'review' => 'You have already reviewed this product.',

            ]);
        }

        $review = $this->repository->create([

            'product_id' => $product->id,

            'user_id' => $user->id,

            'rating' => $data->rating,

            'comment' => $data->comment,

            'status' => ReviewStatus::Pending,

        ]);

        event(new ReviewCreated($review));

        return $review;
    }

    public function update(
        Review $review,
        UpdateReviewData $data,
    ): bool {

        return $this->repository->update(
            $review,
            [

                'rating' => $data->rating,

                'comment' => $data->comment,

                'status' => ReviewStatus::Pending,

                'approved_by' => null,

                'approved_at' => null,

            ]
        );
    }

    public function delete(
        Review $review,
    ): bool {

        return $this->repository->delete(
            $review
        );
    }

    public function find(
        int $id,
    ): ?Review {

        return $this->repository->find(
            $id
        );
    }

    public function findByUser(
        Product $product,
        User $user,
    ): ?Review {

        return $this->repository->findByUser(
            $product,
            $user
        );
    }

    public function paginateAdmin(
        ?string $search = null,
        ?ReviewStatus $status = null,
    ): LengthAwarePaginator {

        return $this->repository->paginateAdmin(

            search: $search,

            status: $status,

        );
    }

    public function approvedByProduct(
        Product $product,
    ) {

        return $this->repository->approvedByProduct(
            $product
        );
    }

    public function averageRating(
        Product $product,
    ): float {

        return $this->repository->averageRating(
            $product
        );
    }

    public function reviewsCount(
        Product $product,
    ): int {

        return $this->repository->reviewsCount(
            $product
        );
    }

    public function approve(
        Review $review,
    ): bool {

        $review->user->notify(

            new ReviewApprovedNotification(
                $review
            )

        );

        return $this->repository->update(
            $review,
            [

                'status' => ReviewStatus::Approved,

                'approved_by' => Auth::id(),

                'approved_at' => now(),

            ]
        );
    }

    public function reject(
        Review $review,
    ): bool {

        return $this->repository->update(
            $review,
            [

                'status' => ReviewStatus::Rejected,

                'approved_by' => null,

                'approved_at' => null,

            ]
        );
    }

    private function ensureCanReview(
        Product $product,
        User $user,
    ): void {

        if (
            $this->repository->findByUser(
                $product,
                $user
            )
        ) {

            throw ValidationException::withMessages([
                'review' => 'You have already reviewed this product.',

            ]);
        }

        if (
            ! $this->orderRepository->hasPurchasedProduct(
                $user,
                $product
            )
        ) {

            throw new AuthorizationException(
                'You must purchase this product before reviewing it.'
            );
        }
    }

    public function statistics(): array
    {
        return [

            'total' => $this->repository
                ->paginateAdmin()
                ->total(),

            'approved' => $this->repository
                ->approvedCount(),

            'pending' => $this->repository
                ->pendingCount(),

            'rejected' => $this->repository
                ->rejectedCount(),

        ];
    }

    public function canReview(
        Product $product,
        User $user,
    ): bool {

        return $this->orderRepository
            ->hasPurchasedProduct(
                $user,
                $product
            );
    }
}
