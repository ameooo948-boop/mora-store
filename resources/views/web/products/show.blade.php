@extends('web.layouts.app')

@section('title', $product->name)

@section('content')

@php
$inWishlist = auth()->check()
? auth()->user()
->wishlists()
->where('product_id', $product->id)
->exists()
: false;

$mainImage = $product->images->first();
@endphp


<div class="product-page">

    {{-- =====================================================
        PRODUCT HERO
    ====================================================== --}}

    <div class="container">

        <div class="product-hero">

            {{-- ================= IMAGE GALLERY ================= --}}

            <div class="product-gallery">

                <div class="product-main-image-wrapper">

                    {{-- Discount --}}
                    @if($product->has_discount)
                    <span class="product-detail-discount">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @endif

                    {{-- Wishlist --}}
                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="product-detail-wishlist wishlist-form">
                        @csrf

                        <button type="submit" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}" aria-label="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                            <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                    </form>


                    @if($mainImage)

                    <img id="mainImage" src="{{ $mainImage->image_url }}" class="product-main-image" alt="{{ $product->name }}">

                    @else

                    <div class="product-main-placeholder">
                        <i class="bi bi-image"></i>
                        <span>No image available</span>
                    </div>

                    @endif

                </div>


                {{-- Thumbnails --}}

                @if($product->images->count() > 1)

                <div class="product-thumbnails">

                    @foreach($product->images as $index => $image)

                    <button type="button" class="product-thumbnail {{ $index === 0 ? 'active' : '' }}" data-image="{{ $image->image_url }}" aria-label="View product image {{ $index + 1 }}">
                        <img src="{{ $image->image_url }}" alt="{{ $product->name }} image {{ $index + 1 }}" loading="lazy">
                    </button>

                    @endforeach

                </div>

                @endif

            </div>


            {{-- ================= PRODUCT INFORMATION ================= --}}

            <div class="product-information">

                {{-- Category --}}

                <a href="#" class="product-detail-category">
                    <i class="bi bi-grid"></i>
                    {{ $product->category->name }}
                </a>


                {{-- Product Title --}}

                <h1 class="product-detail-title">
                    {{ $product->name }}
                </h1>


                {{-- Rating --}}

                <div class="product-rating">

                    <div class="rating-stars">

                        @for($i = 1; $i <= 5; $i++) <i class="bi
                                {{ $i <= round($averageRating)
                                    ? 'bi-star-fill'
                                    : 'bi-star'
                                }}">
                            </i>

                            @endfor

                    </div>

                    <strong>
                        {{ number_format($averageRating, 1) }}
                    </strong>

                    <span>
                        {{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }}
                    </span>

                </div>


                {{-- Product Meta --}}

                <div class="product-meta">

                    <div class="product-meta-item">

                        <span>Brand</span>

                        <strong>
                            {{ $product->brand->name }}
                        </strong>

                    </div>

                    <div class="product-meta-divider"></div>

                    <div class="product-meta-item">

                        <span>SKU</span>

                        <strong>
                            {{ $product->sku }}
                        </strong>

                    </div>

                </div>


                {{-- Price --}}

                <div class="product-detail-price">

                    @if($product->has_discount)

                    <div class="price-old">
                        {{ number_format($product->price, 2) }}
                        <span>{{ setting('currency') }}</span>
                    </div>

                    <div class="price-current discount">
                        {{ number_format($product->final_price, 2) }}
                        <span>{{ setting('currency') }}</span>
                    </div>

                    <span class="save-badge">
                        Save {{ $product->discount_percentage }}%
                    </span>

                    @else

                    <div class="price-current">
                        {{ number_format($product->price, 2) }}
                        <span>{{ setting('currency') }}</span>
                    </div>

                    @endif

                </div>


                {{-- Stock --}}

                <div class="product-detail-stock">

                    @if($product->quantity == 0)

                    <span class="detail-stock out">
                        <span></span>
                        Out of Stock
                    </span>

                    @elseif($product->quantity <= 5) <span class="detail-stock low">
                        <span></span>
                        Only {{ $product->quantity }} left in stock
                        </span>

                        @else

                        <span class="detail-stock available">
                            <span></span>
                            In Stock
                        </span>

                        @endif

                </div>


                {{-- Short Description --}}

                <div class="product-short-description">

                    <p>
                        {{ $product->description }}
                    </p>

                </div>


                {{-- Purchase Area --}}

                <div class="purchase-box">

                    <form id="addToCartForm" action="{{ route('cart.store', $product) }}" method="POST">

                        @csrf

                        <div class="purchase-row">

                            {{-- Quantity --}}

                            <div class="quantity-control">

                                <button type="button" id="decreaseQuantity" aria-label="Decrease quantity">
                                    <i class="bi bi-dash"></i>
                                </button>

                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantity }}" readonly aria-label="Quantity">

                                <button type="button" id="increaseQuantity" aria-label="Increase quantity">
                                    <i class="bi bi-plus"></i>
                                </button>

                            </div>


                            {{-- Add To Cart --}}

                            <button type="submit" id="addToCartButton" class="add-product-button" {{ $product->quantity == 0 ? 'disabled' : '' }}>

                                <i class="bi bi-cart-plus"></i>

                                <span>
                                    {{ $product->quantity == 0
                                        ? 'Out of Stock'
                                        : 'Add to Cart'
                                    }}
                                </span>

                                @if($product->quantity > 0)
                                <i class="bi bi-arrow-right button-arrow"></i>
                                @endif

                            </button>

                        </div>

                    </form>

                </div>


                {{-- Trust Features --}}

                <div class="product-trust">

                    <div class="trust-item">

                        <div class="trust-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>
                            <strong>Secure Shopping</strong>
                            <span>Your information is protected</span>
                        </div>

                    </div>


                    <div class="trust-item">

                        <div class="trust-icon">
                            <i class="bi bi-truck"></i>
                        </div>

                        <div>
                            <strong>Fast Delivery</strong>
                            <span>Quick & reliable shipping</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            DESCRIPTION
        ====================================================== --}}

        <section class="product-section">

            <div class="section-heading">

                <span class="section-eyebrow">
                    PRODUCT DETAILS
                </span>

                <h2>
                    About this product
                </h2>

            </div>

            <div class="description-card">

                <div class="description-icon">
                    <i class="bi bi-file-text"></i>
                </div>

                <div class="description-content">
                    {!! nl2br(e($product->description)) !!}
                </div>

            </div>

        </section>


        {{-- =====================================================
            REVIEWS
        ====================================================== --}}

        <section class="product-section">

            <div class="section-heading reviews-heading">

                <div>

                    <span class="section-eyebrow">
                        CUSTOMER FEEDBACK
                    </span>

                    <h2>
                        Customer Reviews
                    </h2>

                </div>

                <div class="review-summary">

                    <strong>
                        {{ number_format($averageRating, 1) }}
                    </strong>

                    <div>

                        <div class="rating-stars">

                            @for($i = 1; $i <= 5; $i++) <i class="bi
                                    {{ $i <= round($averageRating)
                                        ? 'bi-star-fill'
                                        : 'bi-star'
                                    }}">
                                </i>

                                @endfor

                        </div>

                        <span>
                            Based on {{ $reviewsCount }} reviews
                        </span>

                    </div>

                </div>

            </div>


            <div class="reviews-list">

                @forelse($reviews as $review)

                <article class="review-card">

                    <div class="review-avatar">

                        <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" loading="lazy">

                    </div>


                    <div class="review-content">

                        <div class="review-header">

                            <div>

                                <h3>
                                    {{ $review->user->name }}
                                </h3>

                                <span>
                                    {{ $review->created_at->diffForHumans() }}
                                </span>

                            </div>


                            <div class="review-stars">

                                @for($i = 1; $i <= 5; $i++) <i class="bi
                                            {{ $i <= $review->rating
                                                ? 'bi-star-fill'
                                                : 'bi-star'
                                            }}">
                                    </i>

                                    @endfor

                            </div>

                        </div>


                        <p>
                            {{ $review->comment }}
                        </p>

                    </div>

                </article>

                @empty

                <div class="empty-reviews">

                    <div>
                        <i class="bi bi-chat-square-heart"></i>
                    </div>

                    <h3>
                        No reviews yet
                    </h3>

                    <p>
                        Be the first customer to share your experience.
                    </p>

                </div>

                @endforelse

            </div>


            <div class="reviews-pagination">

                {{ $reviews->links() }}

            </div>

        </section>


        {{-- =====================================================
            WRITE REVIEW
        ====================================================== --}}

        @auth

        @if($canReview || $userReview)

        <section class="review-form-section">

            <div class="section-heading">

                <span class="section-eyebrow">
                    YOUR EXPERIENCE
                </span>

                <h2>
                    {{ $userReview ? 'Update Your Review' : 'Share Your Experience' }}
                </h2>

            </div>


            <div class="review-form-card">

                <form action="{{ $userReview
                                ? route('reviews.update', $userReview)
                                : route('reviews.store', $product) }}" method="POST">

                    @csrf

                    @if($userReview)
                    @method('PUT')
                    @endif


                    <div class="review-form-grid">

                        <div class="review-field">

                            <label for="rating">
                                Rating
                            </label>

                            <select name="rating" id="rating" class="@error('rating') is-invalid @enderror">

                                @for($i = 5; $i >= 1; $i--)

                                <option value="{{ $i }}" @selected(old('rating', $userReview?->rating) == $i)
                                    >
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>

                                @endfor

                            </select>

                            @error('rating')
                            <small class="form-error">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>


                        <div class="review-field review-comment-field">

                            <label for="comment">
                                Your Review
                            </label>

                            <textarea name="comment" id="comment" rows="5" placeholder="Tell other customers about your experience..." class="@error('comment') is-invalid @enderror">{{ old('comment', $userReview?->comment) }}</textarea>

                            @error('comment')
                            <small class="form-error">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>

                    </div>


                    <button type="submit" class="submit-review-button">
                        <i class="bi bi-send"></i>

                        {{ $userReview
                                    ? 'Update Review'
                                    : 'Submit Review'
                                }}
                    </button>

                </form>

            </div>

        </section>

        @else

        <div class="review-login-notice">

            <i class="bi bi-info-circle"></i>

            <span>
                You can review this product only after purchasing and receiving it.
            </span>

        </div>

        @endif

        @endauth


        {{-- =====================================================
            RELATED PRODUCTS
        ====================================================== --}}

        @if($relatedProducts->isNotEmpty())

        <section class="product-section related-section">

            <div class="section-heading">

                <span class="section-eyebrow">
                    YOU MAY ALSO LIKE
                </span>

                <h2>
                    Related Products
                </h2>

            </div>


            <div class="row g-4">

                @foreach($relatedProducts as $relatedProduct)

                <div class="col-6 col-md-4 col-lg-3">

                    @include(
                    'web.partials.product-card',
                    ['product' => $relatedProduct]
                    )

                </div>

                @endforeach

            </div>

        </section>

        @endif

    </div>

</div>

@endsection
