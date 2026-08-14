@extends('web.layouts.app')

@section('title', 'My Wishlist')

@section('content')

<div class="wishlist-page">

    <div class="container">

        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <div class="wishlist-header">

            <div>

                <span class="wishlist-eyebrow">
                    <i class="bi bi-heart-fill"></i>
                    YOUR COLLECTION
                </span>

                <h1>
                    My Wishlist
                </h1>

                <p>
                    Save your favorite products and come back to them whenever you want.
                </p>

            </div>


            @if($wishlists->count())

            <div class="wishlist-count">

                <strong>
                    {{ $wishlists->total() }}
                </strong>

                <span>
                    {{ Str::plural('item', $wishlists->total()) }}
                </span>

            </div>

            @endif

        </div>


        {{-- =====================================================
            PRODUCTS
        ====================================================== --}}

        @if($wishlists->count())

        <div class="wishlist-grid">

            @foreach($wishlists as $wishlist)

            @php
            $product = $wishlist->product;
            $image = $product->images->first();
            @endphp

            <article class="wishlist-card">

                {{-- Product Image --}}

                <div class="wishlist-card-media">

                    {{-- Discount --}}

                    @if($product->has_discount)

                    <span class="wishlist-discount">
                        -{{ $product->discount_percentage }}%
                    </span>

                    @endif


                    {{-- Remove --}}

                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-remove-form">
                        @csrf

                        <button type="submit" class="wishlist-remove-btn" title="Remove from wishlist" aria-label="Remove {{ $product->name }} from wishlist">
                            <i class="bi bi-heart-fill"></i>
                        </button>

                    </form>


                    {{-- Image --}}

                    <a href="{{ route('products.show', $product) }}" class="wishlist-image-link">

                        @if($image)

                        <img src="{{ $image->image_url }}" class="wishlist-product-image" alt="{{ $product->name }}" loading="lazy">

                        @else

                        <div class="wishlist-image-placeholder">

                            <i class="bi bi-image"></i>

                        </div>

                        @endif

                    </a>

                </div>


                {{-- Product Information --}}

                <div class="wishlist-card-body">

                    {{-- Category --}}

                    <span class="wishlist-category">
                        {{ $product->category->name }}
                    </span>


                    {{-- Name --}}

                    <h2 class="wishlist-product-name">

                        <a href="{{ route('products.show', $product) }}">
                            {{ $product->name }}
                        </a>

                    </h2>


                    {{-- Price --}}

                    <div class="wishlist-price">

                        @if($product->has_discount)

                        <span class="wishlist-old-price">
                            {{ number_format($product->price, 2) }}
                            {{ setting('currency') }}
                        </span>

                        <strong class="wishlist-current-price discount">
                            {{ number_format($product->final_price, 2) }}
                            <small>{{ setting('currency') }}</small>
                        </strong>

                        @else

                        <strong class="wishlist-current-price">
                            {{ $product->formatted_price ?? number_format($product->price, 2) }}
                            <small>
                                {{ setting('currency') }}
                            </small>
                        </strong>

                        @endif

                    </div>


                    {{-- Stock --}}

                    <div class="wishlist-stock">

                        @if($product->quantity == 0)

                        <span class="wishlist-stock-status out">
                            <span></span>
                            Out of Stock
                        </span>

                        @elseif($product->quantity <= 5) <span class="wishlist-stock-status low">
                            <span></span>
                            Only {{ $product->quantity }} left
                            </span>

                            @else

                            <span class="wishlist-stock-status available">
                                <span></span>
                                In Stock
                            </span>

                            @endif

                    </div>


                    {{-- Actions --}}

                    <div class="wishlist-actions">

                        <a href="{{ route('products.show', $product) }}" class="wishlist-view-btn">
                            <i class="bi bi-eye"></i>
                            View Product
                        </a>


                        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-action-remove">
                            @csrf

                            <button type="submit" title="Remove from wishlist">
                                <i class="bi bi-trash3"></i>
                            </button>

                        </form>

                    </div>

                </div>

            </article>

            @endforeach

        </div>


        {{-- =====================================================
                PAGINATION
            ====================================================== --}}

        @if($wishlists->hasPages())

        <div class="wishlist-pagination">

            {{ $wishlists->links() }}

        </div>

        @endif


        @else

        {{-- =====================================================
                EMPTY WISHLIST
            ====================================================== --}}

        <div class="wishlist-empty">

            <div class="wishlist-empty-icon">

                <i class="bi bi-heart"></i>

                <span class="empty-spark spark-one">✦</span>
                <span class="empty-spark spark-two">✦</span>
                <span class="empty-spark spark-three">•</span>

            </div>


            <span class="wishlist-eyebrow">
                NOTHING SAVED YET
            </span>

            <h2>
                Your wishlist is waiting
            </h2>

            <p>
                You haven't saved any products yet.
                Explore our collection and save the things you love.
            </p>


            <a href="{{ route('products.index') }}" class="wishlist-shop-btn">
                <i class="bi bi-bag"></i>
                Explore Products
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

        @endif

    </div>

</div>

@endsection
