@extends('admin.layouts.app')

@section('title', 'Review Details')

@section('page-title', 'Review Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Review #{{ $review->id }}

            </h3>

            <small class="text-muted">

                {{ $review->created_at->format('M d, Y h:i A') }}

            </small>

        </div>

        <span class="badge bg-{{ $review->status->badge() }} fs-6">

            {{ $review->status->label() }}

        </span>

    </div>

    <div class="row">

        <div class="col-lg-8">

            {{-- Review --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Review

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)

                            <i class="bi bi-star-fill fs-5 text-warning"></i>

                            @else

                            <i class="bi bi-star fs-5 text-secondary"></i>

                            @endif

                            @endfor

                    </div>

                    <p class="mb-0">

                        {{ $review->comment }}

                    </p>

                </div>

            </div>

            {{-- Product --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Product

                </div>

                <div class="card-body">

                    <h5>

                        {{ $review->product->name }}

                    </h5>

                    @if(!empty($review->product->sku))

                    <small class="text-muted">

                        SKU:
                        {{ $review->product->sku }}

                    </small>

                    @endif

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            {{-- Customer --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Customer

                </div>

                <div class="card-body">

                    <strong>

                        {{ $review->user->name }}

                    </strong>

                    <br>

                    {{ $review->user->email }}

                </div>

            </div>

            {{-- Status --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Review Status

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <span class="badge bg-{{ $review->status->badge() }} fs-6">

                            {{ $review->status->label() }}

                        </span>

                    </div>

                    @if($review->approvedBy)

                    <div class="mb-2">

                        <strong>

                            Approved By

                        </strong>

                        <br>

                        {{ $review->approvedBy->name }}

                    </div>

                    @endif

                    @if($review->approved_at)

                    <div>

                        <strong>

                            Approved At

                        </strong>

                        <br>

                        {{ $review->approved_at->format('M d, Y h:i A') }}

                    </div>

                    @endif

                </div>

            </div>

            {{-- Actions --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Actions

                </div>

                <div class="card-body">

                    @if($review->status === \App\Enums\ReviewStatus::Pending)

                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="mb-3">

                        @csrf
                        @method('PATCH')

                        <button class="btn btn-success w-100">

                            <i class="bi bi-check-circle me-2"></i>

                            Approve Review

                        </button>

                    </form>

                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">

                        @csrf
                        @method('PATCH')

                        <button class="btn btn-danger w-100">

                            <i class="bi bi-x-circle me-2"></i>

                            Reject Review

                        </button>

                    </form>

                    @elseif($review->status === \App\Enums\ReviewStatus::Approved)

                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">

                        @csrf
                        @method('PATCH')

                        <button class="btn btn-outline-danger w-100">

                            Reject Review

                        </button>

                    </form>

                    @elseif($review->status === \App\Enums\ReviewStatus::Rejected)

                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">

                        @csrf
                        @method('PATCH')

                        <button class="btn btn-outline-success w-100">

                            Approve Review

                        </button>

                    </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
