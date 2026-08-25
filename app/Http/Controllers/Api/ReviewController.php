<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Review\CreateReviewData;
use App\DTOs\Review\UpdateReviewData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreReviewRequest;
use App\Http\Requests\Web\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected ReviewService $service,
    ) {}

    public function store(
        StoreReviewRequest $request,
        Product $product,
    ) {
        $review = $this->service->create(
            $product,
            $request->user(),
            new CreateReviewData(
                rating: $request->integer('rating'),
                comment: $request->string('comment')->value(),
            ),
        );

        return response()->json([
            'message' => 'Review submitted successfully.',
            'review' => new ReviewResource($review),
        ], 201);
    }

    public function update(
        UpdateReviewRequest $request,
        Review $review,
    ) {
        $this->authorize('update', $review);

        $review = $this->service->update(
            $review,
            new UpdateReviewData(
                rating: $request->integer('rating'),
                comment: $request->string('comment')->value(),
            ),
        );

        return response()->json([
            'message' => 'Review updated successfully.',
            'review' => new ReviewResource($review),
        ]);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $this->service->delete($review);

        return response()->json([
            'message' => 'Review deleted successfully.',
        ]);
    }
}
