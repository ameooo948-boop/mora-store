<?php

namespace App\Http\Controllers\Web;

use App\DTOs\Review\CreateReviewData;
use App\DTOs\Review\UpdateReviewData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreReviewRequest;
use App\Http\Requests\Web\UpdateReviewRequest;
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

        $this->service->create(
            $product,
            $request->user(),
            new CreateReviewData(
                rating: $request->integer('rating'),
                comment: $request->string('comment')->value(),
            ),
        );

        return back()->with(
            'success',
            'Review submitted successfully.'
        );
    }

    public function update(
        UpdateReviewRequest $request,
        Review $review,
    ) {

        $this->authorize(
            'update',
            $review
        );

        $this->service->update(
            $review,
            new UpdateReviewData(
                rating: $request->integer('rating'),
                comment: $request->string('comment')->value(),
            ),
        );

        return back()->with(
            'success',
            'Review updated successfully.'
        );
    }

    public function destroy(
        Review $review,
    ) {

        $this->authorize(
            'delete',
            $review
        );

        $this->service->delete(
            $review
        );

        return back()->with(
            'success',
            'Review deleted successfully.'
        );
    }
}
