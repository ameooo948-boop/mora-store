<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $service,
    ) {}

    public function index(
        Request $request,
    ) {

        return view(
            'admin.reviews.index',
            [

                'reviews' => $this->service->paginateAdmin(

                    search: $request->search,

                    status: $request->filled('status')
                        ? ReviewStatus::tryFrom($request->status)
                        : null,

                ),

                'statistics' => $this->service->statistics(),

                'statuses' => ReviewStatus::cases(),

            ]
        );
    }
    public function show(
        Review $review,
    ) {

        return view(
            'admin.reviews.show',
            compact('review')
        );
    }

    public function approve(
        Review $review,
    ) {

        $this->service->approve(
            $review
        );

        return back()->with(
            'success',
            'Review approved successfully.'
        );
    }

    public function reject(
        Review $review,
    ) {

        $this->service->reject(
            $review
        );

        return back()->with(
            'success',
            'Review rejected successfully.'
        );
    }
}
