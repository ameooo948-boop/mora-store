@php
$inWishlist = auth()->check()
? auth()->user()->wishlists()
->where('product_id', $product->id)
->exists()
: false;
@endphp

<div class="product-card h-100">

    {{-- Product Image --}}
    <div class="product-card-media">

        {{-- Wishlist --}}
        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-form">
            @csrf

            <button type="submit" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}" aria-label="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>
            </button>
        </form>

        {{-- Discount --}}
        @if($product->has_discount)
        <span class="product-discount">
            -{{ $product->discount_percentage }}%
        </span>
        @endif

        <a href="{{ route('products.show', $product) }}" class="product-image-link">
            @if($product->images->isNotEmpty())

            <img src="{{ $product->images->first()->image_url }}" class="product-image" alt="{{ $product->name }}" loading="lazy">

            @else

            <div class="product-image-placeholder">
                <i class="bi bi-image"></i>
            </div>

            @endif
        </a>

    </div>


    {{-- Product Content --}}
    <div class="product-card-body">

        {{-- Category --}}
        <div class="product-category">
            {{ $product->category->name }}
        </div>


        {{-- Product Name --}}
        <h3 class="product-title">
            <a href="{{ route('products.show', $product) }}">
                {{ $product->name }}
            </a>
        </h3>


        {{-- Price --}}
        <div class="product-price">

            @if($product->has_discount)

            <span class="product-old-price">
                {{ number_format($product->price, 2) }}
                {{ setting('currency') }}
            </span>

            <div class="product-current-price discount">
                {{ number_format($product->final_price, 2) }}
                <span>{{ setting('currency') }}</span>
            </div>

            @else

            <div class="product-current-price">
                {{ number_format($product->price, 2) }}
                <span>{{ setting('currency') }}</span>
            </div>

            @endif

        </div>


        {{-- Stock Status --}}
        <div class="product-stock">

            @if($product->quantity == 0)

            <span class="stock-badge out">
                <span class="stock-dot"></span>
                Out of Stock
            </span>

            @elseif($product->quantity <= 5) <span class="stock-badge low">
                <span class="stock-dot"></span>
                Only {{ $product->quantity }} left
                </span>

                @else

                <span class="stock-badge available">
                    <span class="stock-dot"></span>
                    In Stock
                </span>

                @endif

        </div>


        {{-- Add To Cart --}}
        <div class="product-card-footer">

            <form action="{{ route('cart.store', $product) }}" method="POST" class="add-to-cart-form">
                @csrf

                <input type="hidden" name="quantity" value="1">

                <button type="submit" class="add-to-cart-btn" {{ $product->quantity == 0 ? 'disabled' : '' }}>

                    <span class="cart-icon">
                        <i class="bi bi-cart-plus"></i>
                    </span>

                    <span class="cart-text">
                        Add To Cart
                    </span>

                    <i class="bi bi-arrow-right cart-arrow"></i>

                </button>

            </form>

        </div>

    </div>

</div>
