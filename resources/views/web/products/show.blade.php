@extends('web.layouts.app')

@section('title', $product->name)

@section('content')

@php

$inWishlist = auth()->check()
? auth()->user()->wishlists()->where('product_id', $product->id)->exists()
: false;

@endphp

<div class="container py-5">

    <div class="row g-5">

        {{-- Images --}}
        <div class="col-lg-6">

            @php
            $mainImage = $product->images->first();
            @endphp

            @if($mainImage)

            <img id="mainImage" src="{{ $mainImage->image_url }}" class="img-fluid rounded shadow-sm w-100 border" alt="{{ $product->name }}" style="height:550px;object-fit:cover;">

            @if($product->images->count() > 1)

            <div class="row mt-3">

                @foreach($product->images as $image)

                <div class="col-3 mb-3">

                    <img src="{{ $image->image_url }}" class="img-fluid rounded border thumbnail-image" data-image="{{ $image->image_url }}" style="height:90px;object-fit:cover;cursor:pointer;">

                </div>

                @endforeach

            </div>

            @endif

            @else

            <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height:550px;">

                <i class="bi bi-image fs-1"></i>

            </div>

            @endif

        </div>

        {{-- Product Info --}}
        <div class="col-lg-6">

            <div class="d-flex align-items-center gap-2 mb-3">

                <div>

                    @for($i = 1; $i <= 5; $i++) @if($i <=round($averageRating)) <i class="bi bi-star-fill text-warning"></i>

                        @else

                        <i class="bi bi-star text-secondary"></i>

                        @endif

                        @endfor

                </div>

                <span>

                    {{ number_format($averageRating,1) }}

                </span>

                <small class="text-muted">

                    ({{ $reviewsCount }} Reviews)

                </small>

            </div>

            <span class="badge bg-primary mb-3">

                {{ $product->category->name }}

            </span>

            <h1 class="fw-bold">

                {{ $product->name }}

            </h1>

            <div class="text-muted mb-3">

                Brand :

                <strong>

                    {{ $product->brand->name }}

                </strong>

            </div>

            <div class="text-muted mb-3">

                SKU :

                {{ $product->sku }}

            </div>

            <div class="mb-4">

                @if($product->quantity == 0)

                <span class="badge bg-danger">

                    Out Of Stock

                </span>

                @elseif($product->quantity <= 5) <span class="badge bg-warning text-dark">

                    Only {{ $product->quantity }} Left

                    </span>

                    @else

                    <span class="badge bg-success">

                        In Stock ({{ $product->quantity }})

                    </span>

                    @endif

            </div>

            @if($product->has_discount)

            <div class="mb-2">

                <span class="badge bg-danger">

                    -{{ $product->discount_percentage }}%

                </span>

            </div>

            <div class="mb-2">

                <span class="fs-5 text-muted text-decoration-line-through">

                    {{ number_format($product->price, 2) }}

                    {{ setting('currency') }}

                </span>

            </div>

            <h2 class="text-danger fw-bold mb-4">

                {{ number_format($product->final_price, 2) }}

                {{ setting('currency') }}

            </h2>

            @else

            <h2 class="text-success fw-bold mb-4">

                {{ number_format($product->price, 2) }}

                {{ setting('currency') }}

            </h2>

            @endif

            <hr>

            <p class="text-muted">

                {{ $product->description }}

            </p>

            <hr>

            <form id="addToCartForm" action="{{ route('cart.store', $product) }}" method="POST">

                @csrf

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Quantity
                    </label>

                    <div class="d-flex align-items-center gap-2">

                        <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">

                            -

                        </button>

                        <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->quantity }}" style="width:90px;" readonly>

                        <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">

                            +

                        </button>

                    </div>

                </div>

                <button id="addToCartButton" class="btn btn-primary" {{ $product->quantity == 0 ? 'disabled' : '' }}>

                    <i class="bi bi-cart-plus me-2"></i>

                    {{ $product->quantity == 0 ? 'Out Of Stock' : 'Add To Cart' }}

                </button>

            </form>

            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-form">
                @csrf

                <button type="submit" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">

                    <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>

                </button>
            </form>


        </div>


    </div>

    {{-- Description --}}
    <div class="mt-5">

        <div class="card shadow-sm">

            <div class="card-header">

                <h4 class="mb-0">

                    Description

                </h4>

            </div>

            <div class="card-body">

                {!! nl2br(e($product->description)) !!}

            </div>

        </div>

    </div>


    <div class="mt-5">

        <h4 class="mb-4">

            Customer Reviews

        </h4>

        @forelse($reviews as $review)

        <div class="card shadow-sm border-0 mb-3">

            <div class="card-body">

                <div class="d-flex align-items-center justify-content-between">

                    <div class="d-flex align-items-center">

                        <img src="{{ $review->user->avatar_url }}" class="rounded-circle me-3" width="45" height="45" style="object-fit: cover;" alt="{{ $review->user->name }}">

                        <div>

                            <h6 class="mb-0 fw-semibold">
                                {{ $review->user->name }}
                            </h6>

                            <small class="text-muted">
                                {{ $review->created_at->diffForHumans() }}
                            </small>

                        </div>

                    </div>

                    <div>

                        @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)

                            <i class="bi bi-star-fill text-warning"></i>

                            @else

                            <i class="bi bi-star text-secondary"></i>

                            @endif

                            @endfor

                    </div>

                </div>

                <hr class="my-3">

                <p class="mb-0 text-muted">
                    {{ $review->comment }}
                </p>

            </div>

        </div>

        @empty

        <div class="alert alert-light border">

            No reviews yet.

        </div>

        @endforelse

        {{ $reviews->links() }}

    </div>

    @auth

    @if($canReview || $userReview)
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                {{ $userReview ? 'Update Your Review' : 'Write a Review' }}

            </h5>

        </div>

        <div class="card-body">

            <form action="{{ $userReview
                        ? route('reviews.update', $userReview)
                        : route('reviews.store', $product) }}" method="POST">

                @csrf

                @if($userReview)

                @method('PUT')

                @endif

                <div class="mb-3">

                    <label class="form-label">

                        Rating

                    </label>

                    <select name="rating" class="form-select @error('rating') is-invalid @enderror">

                        @for($i = 5; $i >= 1; $i--)

                        <option value="{{ $i }}" @selected(old('rating', $userReview?->rating) == $i)
                            >

                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}

                        </option>

                        @endfor

                    </select>

                    @error('rating')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Comment

                    </label>

                    <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $userReview?->comment) }}</textarea>

                    @error('comment')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>

                <button class="btn btn-primary">

                    {{ $userReview ? 'Update Review' : 'Submit Review' }}

                </button>

            </form>

        </div>

    </div>

    @else

    <div class="alert alert-info">

        You can review this product only after purchasing and receiving it.

    </div>

    @endif

    @endauth


    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())

    <div class="mt-5">

        <h3 class="mb-4">

            Related Products

        </h3>

        <div class="row">

            @foreach($relatedProducts as $product)

            <div class="col-md-3 mb-4">

                @include('web.partials.product-card')

            </div>

            @endforeach

        </div>

    </div>

    @endif

</div>

@endsection
