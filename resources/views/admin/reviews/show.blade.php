@extends('admin.layouts.app')

@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('content')

<div class="review-details-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="review-details-hero">

        <div class="review-details-hero-left">

            <a
                href="{{ route('admin.reviews.index') }}"
                class="review-details-back"
                title="Back to Reviews"
            >
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>

                <span class="review-details-eyebrow">
                    CUSTOMER REVIEWS
                </span>

                <h1>
                    Review #{{ $review->id }}
                </h1>

                <p>
                    Customer feedback, rating and review information.
                </p>

            </div>

        </div>


        <div class="review-details-actions">

            @if($review->status === \App\Enums\ReviewStatus::Pending)

                <form
                    action="{{ route('admin.reviews.approve', $review) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="review-action approve">
                        <i class="bi bi-check-circle"></i>
                        Approve Review
                    </button>

                </form>

                <form
                    action="{{ route('admin.reviews.reject', $review) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="review-action reject">
                        <i class="bi bi-x-circle"></i>
                        Reject Review
                    </button>

                </form>

            @elseif($review->status === \App\Enums\ReviewStatus::Approved)

                <form
                    action="{{ route('admin.reviews.reject', $review) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="review-action reject-outline">
                        <i class="bi bi-x-circle"></i>
                        Reject Review
                    </button>

                </form>

            @elseif($review->status === \App\Enums\ReviewStatus::Rejected)

                <form
                    action="{{ route('admin.reviews.approve', $review) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="review-action approve-outline">
                        <i class="bi bi-check-circle"></i>
                        Approve Review
                    </button>

                </form>

            @endif

            <a
                href="{{ route('admin.reviews.index') }}"
                class="review-details-all"
            >
                <i class="bi bi-chat-square-text"></i>
                All Reviews
            </a>

        </div>

    </div>


    {{-- =====================================================
         MAIN OVERVIEW
    ====================================================== --}}

    <div class="review-details-grid">

        {{-- =================================================
             REVIEW
        ================================================== --}}

        <div class="review-main-card">

            <div class="review-card-header">

                <div class="review-card-title">

                    <div class="review-card-icon blue">
                        <i class="bi bi-chat-square-quote-fill"></i>
                    </div>

                    <div>

                        <h2>
                            Customer Review
                        </h2>

                        <span>
                            Customer rating and feedback
                        </span>

                    </div>

                </div>

                <span class="review-status {{ $review->status->value }}">
                    <i class="bi bi-circle-fill"></i>
                    {{ $review->status->label() }}
                </span>

            </div>


            <div class="review-main-body">

                {{-- Rating --}}

                <div class="review-rating-section">

                    <div>

                        <span class="review-section-label">
                            CUSTOMER RATING
                        </span>

                        <div class="review-stars">

                            @for($i = 1; $i <= 5; $i++)

                                @if($i <= $review->rating)

                                    <i class="bi bi-star-fill active"></i>

                                @else

                                    <i class="bi bi-star"></i>

                                @endif

                            @endfor

                        </div>

                    </div>

                    <div class="review-rating-number">

                        <strong>
                            {{ $review->rating }}
                        </strong>

                        <span>
                            / 5
                        </span>

                    </div>

                </div>


                {{-- Comment --}}

                <div class="review-comment-section">

                    <span class="review-section-label">
                        CUSTOMER COMMENT
                    </span>

                    <div class="review-comment">

                        <i class="bi bi-quote"></i>

                        <p>
                            {{ $review->comment ?: 'No comment provided for this review.' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             CUSTOMER
        ================================================== --}}

        <div class="review-customer-card">

            <div class="review-card-header">

                <div class="review-card-title">

                    <div class="review-card-icon purple">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div>

                        <h2>
                            Customer
                        </h2>

                        <span>
                            Reviewer information
                        </span>

                    </div>

                </div>

            </div>


            <div class="review-customer-body">

                <div class="review-avatar">

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

        </div>

    </div>


    {{-- =====================================================
         METRICS
    ====================================================== --}}

    <div class="review-metrics">

        {{-- Rating --}}

        <div class="review-metric-card rating">

            <div class="review-metric-icon yellow">
                <i class="bi bi-star-fill"></i>
            </div>

            <div>

                <span>
                    Rating
                </span>

                <strong>
                    {{ $review->rating }} / 5
                </strong>

            </div>

        </div>


        {{-- Status --}}

        <div class="review-metric-card status">

            <div class="review-metric-icon blue">
                <i class="bi bi-activity"></i>
            </div>

            <div>

                <span>
                    Status
                </span>

                <strong>
                    {{ $review->status->label() }}
                </strong>

            </div>

        </div>


        {{-- Product --}}

        <div class="review-metric-card product">

            <div class="review-metric-icon purple">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span>
                    Product
                </span>

                <strong>
                    {{ $review->product->name }}
                </strong>

            </div>

        </div>


        {{-- Date --}}

        <div class="review-metric-card date">

            <div class="review-metric-icon green">
                <i class="bi bi-calendar3"></i>
            </div>

            <div>

                <span>
                    Submitted
                </span>

                <strong>
                    {{ $review->created_at->format('d M Y') }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUCT
    ====================================================== --}}

    <div class="review-product-card">

        <div class="review-card-header">

            <div class="review-card-title">

                <div class="review-card-icon green">
                    <i class="bi bi-box-seam-fill"></i>
                </div>

                <div>

                    <h2>
                        Reviewed Product
                    </h2>

                    <span>
                        Product associated with this review
                    </span>

                </div>

            </div>

        </div>


        <div class="review-product-body">

            <div class="review-product-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <div class="review-product-info">

                <span>
                    PRODUCT
                </span>

                <h3>
                    {{ $review->product->name }}
                </h3>

                @if($review->product->sku)

                    <div class="review-product-sku">

                        <i class="bi bi-upc-scan"></i>

                        SKU:
                        {{ $review->product->sku }}

                    </div>

                @endif

            </div>

            <a
                href="{{ route('admin.products.show', $review->product) }}"
                class="review-product-view"
            >
                <i class="bi bi-arrow-up-right"></i>
                View Product
            </a>

        </div>

    </div>


    {{-- =====================================================
         REVIEW STATUS
    ====================================================== --}}

    <div class="review-status-card">

        <div class="review-card-header">

            <div class="review-card-title">

                <div class="review-card-icon blue">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div>

                    <h2>
                        Review Status
                    </h2>

                    <span>
                        Moderation and approval information
                    </span>

                </div>

            </div>

        </div>


        <div class="review-status-body">

            <div class="review-status-main">

                <span class="review-section-label">
                    CURRENT STATUS
                </span>

                <span class="review-status {{ $review->status->value }}">
                    <i class="bi bi-circle-fill"></i>
                    {{ $review->status->label() }}
                </span>

            </div>


            @if($review->approvedBy)

                <div class="review-status-info">

                    <span>
                        <i class="bi bi-person-check"></i>
                        Approved By
                    </span>

                    <strong>
                        {{ $review->approvedBy->name }}
                    </strong>

                </div>

            @endif


            @if($review->approved_at)

                <div class="review-status-info">

                    <span>
                        <i class="bi bi-clock"></i>
                        Approved At
                    </span>

                    <strong>
                        {{ $review->approved_at->format('d M Y, h:i A') }}
                    </strong>

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
         TIMELINE
    ====================================================== --}}

    <div class="review-timeline-card">

        <div class="review-card-header">

            <div class="review-card-title">

                <div class="review-card-icon green">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>

                    <h2>
                        Review Timeline
                    </h2>

                    <span>
                        Review creation and moderation activity
                    </span>

                </div>

            </div>

        </div>


        <div class="review-timeline">

            {{-- Created --}}

            <div class="review-timeline-item">

                <div class="review-timeline-icon blue">
                    <i class="bi bi-plus-lg"></i>
                </div>

                <div>

                    <span>
                        Review Submitted
                    </span>

                    <strong>
                        {{ $review->created_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $review->created_at->format('h:i A') }}
                    </small>

                </div>

            </div>


            @if($review->approved_at)

                <div class="review-timeline-line"></div>

                <div class="review-timeline-item">

                    <div class="review-timeline-icon green">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>

                        <span>
                            Review Approved
                        </span>

                        <strong>
                            {{ $review->approved_at->format('d M Y') }}
                        </strong>

                        <small>
                            {{ $review->approved_at->format('h:i A') }}
                        </small>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection