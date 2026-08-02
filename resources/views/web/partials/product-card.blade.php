@php
$inWishlist = auth()->check()
? auth()->user()->wishlists()->where('product_id', $product->id)->exists()
: false;
@endphp

<div class="card product-card h-100 border-0 shadow-sm">

    <div class="position-relative overflow-hidden">

        {{-- Wishlist --}}
        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="position-absolute top-0 end-0 m-3 wishlist-form" style="z-index: 10;">
            @csrf

            <button type="submit" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">

                <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>

            </button>
        </form>

        {{-- Discount Badge --}}
        @if($product->has_discount)
        <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2">
            -{{ $product->discount_percentage }}%
        </span>
        @endif

        <a href="{{ route('products.show', $product) }}">

            @if($product->images->isNotEmpty())

            <img src="{{ $product->images->first()->image_url }}" class="card-img-top product-image" alt="{{ $product->name }}">

            @else

            <div class="bg-light d-flex justify-content-center align-items-center product-image">
                <i class="bi bi-image fs-1 text-secondary"></i>
            </div>

            @endif

        </a>

    </div>

    <div class="card-body d-flex flex-column">

        <small class="text-muted mb-1">
            {{ $product->category->name }}
        </small>

        <h5 class="card-title fw-semibold mb-2">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark stretched-link">

                {{ $product->name }}

            </a>
        </h5>

        @if($product->has_discount)

        <div class="mb-2">

            <span class="text-muted text-decoration-line-through small">
                {{ number_format($product->price,2) }} {{ setting('currency') }}
            </span>

            <h5 class="fw-bold text-danger mt-1 mb-0">
                {{ number_format($product->final_price,2) }} {{ setting('currency') }}
            </h5>

        </div>

        @else

        <h5 class="fw-bold mb-2">
            {{ number_format($product->price,2) }} {{ setting('currency') }}
        </h5>

        @endif

        @if($product->quantity == 0)

        <small class="text-danger fw-semibold mb-3">
            <i class="bi bi-x-circle"></i>
            Out of Stock
        </small>

        @elseif($product->quantity <= 5) <small class="text-warning fw-semibold mb-3">
            <i class="bi bi-exclamation-circle"></i>
            Only {{ $product->quantity }} left
            </small>

            @else

            <small class="text-success fw-semibold mb-3">
                <i class="bi bi-check-circle"></i>
                In Stock
            </small>

            @endif

            <div class="mt-auto">

                <form id="addToCartForm" action="{{ route('cart.store', $product) }}" method="POST">

                    @csrf

                    <input type="hidden" name="quantity" value="1">

                    <button class="btn btn-primary w-100" {{ $product->quantity == 0 ? 'disabled' : '' }}>

                        <i class="bi bi-cart-plus me-2"></i>
                        Add To Cart

                    </button>

                </form>

            </div>

    </div>

</div>
