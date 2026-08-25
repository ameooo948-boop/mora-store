<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $service,
    ) {}

    public function index(Request $request)
    {
        $reviews = $this->service->paginateAdmin(
            search: $request->search,
            status: $request->filled('status') ? ReviewStatus::tryFrom($request->status) : null,
        );

        return response()->json([
            'reviews' => ReviewResource::collection($reviews),
            'meta' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'total' => $reviews->total(),
            ],
            'statistics' => $this->service->statistics(),
            'statuses' => ReviewStatus::cases(),
        ]);
    }

    public function show(Review $review)
    {
        $review->load(['user', 'product']);

        return response()->json([
            'review' => new ReviewResource($review),
        ]);
    }

    public function approve(Review $review)
    {
        $this->service->approve($review);

        return response()->json([
            'message' => 'Review approved successfully.',
            'review' => new ReviewResource($review->fresh()),
        ]);
    }

    public function reject(Review $review)
    {
        $this->service->reject($review);

        return response()->json([
            'message' => 'Review rejected successfully.',
            'review' => new ReviewResource($review->fresh()),
        ]);
    }
}
