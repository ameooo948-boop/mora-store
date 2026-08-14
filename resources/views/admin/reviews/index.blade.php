@extends('admin.layouts.app')

@section('title', 'Reviews')
@section('page-title', 'Reviews')

@section('content')

<div class="reviews-page">

    {{-- Header --}}
    <div class="reviews-hero">

        <div class="reviews-hero-content">

            <div class="reviews-hero-icon">
                <i class="bi bi-chat-square-heart-fill"></i>
            </div>

            <div>
                <span class="reviews-eyebrow">
                    CUSTOMER MANAGEMENT
                </span>

                <h1>
                    Reviews
                </h1>

                <p>
                    Manage customer feedback, ratings and review moderation.
                </p>
            </div>

        </div>

    </div>


    {{-- Statistics --}}
    <div class="reviews-statistics">

        <div class="reviews-stat-card">

            <div class="reviews-stat-icon blue">
                <i class="bi bi-chat-square-text-fill"></i>
            </div>

            <div>
                <span>Total Reviews</span>
                <strong>{{ $statistics['total'] }}</strong>
            </div>

        </div>


        <div class="reviews-stat-card">

            <div class="reviews-stat-icon yellow">
                <i class="bi bi-hourglass-split"></i>
            </div>

            <div>
                <span>Pending</span>
                <strong>{{ $statistics['pending'] }}</strong>
            </div>

        </div>


        <div class="reviews-stat-card">

            <div class="reviews-stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div>
                <span>Approved</span>
                <strong>{{ $statistics['approved'] }}</strong>
            </div>

        </div>


        <div class="reviews-stat-card">

            <div class="reviews-stat-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div>
                <span>Rejected</span>
                <strong>{{ $statistics['rejected'] }}</strong>
            </div>

        </div>

    </div>


    {{-- Filters --}}
    <div class="reviews-filter-card">

        <div class="reviews-filter-header">

            <div class="reviews-filter-title">

                <div class="reviews-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <h3>Review Filters</h3>
                    <span>Search and filter customer reviews</span>
                </div>

            </div>

        </div>


        <form method="GET">

            <div class="reviews-filter-body">

                <div class="reviews-search">

                    <label>Search</label>

                    <div class="reviews-input-wrapper">

                        <i class="bi bi-search"></i>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer or product...">

                    </div>

                </div>


                <div class="reviews-status-filter">

                    <label>Status</label>

                    <select name="status" class="reviews-select">

                        <option value="">
                            All Statuses
                        </option>

                        @foreach($statuses as $status)

                        <option value="{{ $status->value }}" @selected(request('status')==$status->value)
                            >
                            {{ $status->label() }}
                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="reviews-filter-button">

                    <button type="submit">
                        <i class="bi bi-search"></i>
                        Search Reviews
                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- Reviews Table --}}
    <div class="reviews-table-card">

        <div class="reviews-table-header">

            <div>

                <span class="reviews-table-eyebrow">
                    REVIEW MANAGEMENT
                </span>

                <h2>
                    Customer Reviews
                </h2>

            </div>

            <div class="reviews-count">
                <i class="bi bi-chat-left-text"></i>
                {{ $reviews->total() }} Reviews
            </div>

        </div>


        <div class="table-responsive">

            <table class="reviews-table">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($reviews as $review)

                    <tr>

                        {{-- ID --}}
                        <td>

                            <span class="review-id">
                                #{{ $review->id }}
                            </span>

                        </td>


                        {{-- Customer --}}
                        <td>

                            <div class="review-customer">

                                <div class="review-customer-avatar">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>

                                <div class="review-customer-info">

                                    <strong>
                                        {{ $review->user->name }}
                                    </strong>

                                    <span>
                                        {{ $review->user->email }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- Product --}}
                        <td>

                            <div class="review-product">

                                <div class="review-product-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <span>
                                    {{ $review->product->name }}
                                </span>

                            </div>

                        </td>


                        {{-- Rating --}}
                        <td>

                            <div class="review-rating">

                                <div class="review-stars">

                                    @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)

                                        <i class="bi bi-star-fill"></i>

                                        @else

                                        <i class="bi bi-star"></i>

                                        @endif

                                        @endfor

                                </div>

                                <span>
                                    {{ $review->rating }}/5
                                </span>

                            </div>

                        </td>


                        {{-- Status --}}
                        <td>

                            <span class="review-status {{ $review->status->value }}">

                                <i class="bi bi-circle-fill"></i>

                                {{ $review->status->label() }}

                            </span>

                        </td>


                        {{-- Date --}}
                        <td>

                            <div class="review-date">

                                <strong>
                                    {{ $review->created_at->format('M d, Y') }}
                                </strong>

                                <span>
                                    {{ $review->created_at->format('h:i A') }}
                                </span>

                            </div>

                        </td>


                        {{-- Actions --}}
                        <td>

                            <div class="review-actions">

                                {{-- View --}}
                                <a href="{{ route('admin.reviews.show', $review) }}" class="review-action-btn view" title="View Review">
                                    <i class="bi bi-eye-fill"></i>
                                </a>


                                @if($review->status === \App\Enums\ReviewStatus::Pending)

                                {{-- Approve --}}
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="review-action-btn approve" title="Approve Review">
                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                </form>


                                {{-- Reject --}}
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="review-action-btn reject" title="Reject Review">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </form>

                                @elseif($review->status === \App\Enums\ReviewStatus::Approved)

                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="review-action-btn reject" title="Reject Review">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                </form>

                                @elseif($review->status === \App\Enums\ReviewStatus::Rejected)

                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="review-action-btn approve" title="Approve Review">
                                        <i class="bi bi-check-lg"></i>
                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td colspan="7">

                            <div class="reviews-empty">

                                <div class="reviews-empty-icon">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>

                                <h3>
                                    No Reviews Found
                                </h3>

                                <p>
                                    There are no reviews matching your search.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($reviews->hasPages())

        <div class="reviews-pagination">
            {{ $reviews->links() }}
        </div>

        @endif

    </div>

</div>

@endsection
