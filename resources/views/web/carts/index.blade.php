@extends('web.layouts.app')

@section('title', 'Shopping Cart')

@section('page-title', 'Shopping Cart')

@section('content')

<div class="cart-page">

    <div class="container">

        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <div class="cart-page-header">

            <div>

                <span class="cart-eyebrow">
                    <i class="bi bi-bag-check-fill"></i>
                    YOUR SHOPPING BAG
                </span>

                <h1>
                    Shopping Cart
                </h1>

                <p>
                    Review your selected products before checkout.
                </p>

            </div>


            <a href="{{ route('products.index') }}" class="cart-continue-btn">

                <i class="bi bi-arrow-left"></i>

                <span>
                    Continue Shopping
                </span>

            </a>

        </div>


        @if($cart->items->isNotEmpty())

        {{-- =================================================
                STATISTICS
            ================================================== --}}

        <div class="cart-stats">

            {{-- Items --}}

            <div class="cart-stat-card">

                <div class="cart-stat-icon blue">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>

                    <span>
                        CART ITEMS
                    </span>

                    <strong>
                        {{ $cart->items->count() }}
                    </strong>

                </div>

            </div>


            {{-- Quantity --}}

            <div class="cart-stat-card">

                <div class="cart-stat-icon purple">
                    <i class="bi bi-layers"></i>
                </div>

                <div>

                    <span>
                        TOTAL QUANTITY
                    </span>

                    <strong>
                        {{ $cart->items->sum('quantity') }}
                    </strong>

                </div>

            </div>


            {{-- Subtotal --}}

            <div class="cart-stat-card">

                <div class="cart-stat-icon green">
                    <i class="bi bi-wallet2"></i>
                </div>

                <div>

                    <span>
                        SUBTOTAL
                    </span>

                    <strong>
                        {{ number_format($totals['subtotal'], 2) }}
                        {{ setting('currency') }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =================================================
                MAIN CART
            ================================================== --}}

        <div class="row g-3 align-items-start">


            {{-- =================================================
                    CART PRODUCTS
                ================================================== --}}

            <div id="cart-content" class="col-xl-8">

                <section class="cart-products-card">


                    {{-- Header --}}

                    <div class="cart-products-header">

                        <div>

                            <span>
                                YOUR ITEMS
                            </span>

                            <h2>
                                Cart Products
                            </h2>

                        </div>


                        <div class="cart-item-count">

                            {{ $cart->items->count() }}

                            {{ Str::plural('item', $cart->items->count()) }}

                        </div>

                    </div>


                    {{-- Products --}}

                    <div class="cart-products-list">

                        @foreach($cart->items as $item)

                        <article class="cart-product-row cart-row" data-product-id="{{ $item->product->id }}">


                            {{-- Product Image --}}

                            <a href="{{ route('products.show', $item->product) }}" class="cart-product-image">

                                @if($item->product->images->isNotEmpty())

                                <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}">

                                @else

                                <div class="cart-product-placeholder">

                                    <i class="bi bi-image"></i>

                                </div>

                                @endif

                            </a>


                            {{-- Product Info --}}

                            <div class="cart-product-info">

                                <span class="cart-product-category">

                                    {{ $item->product->category->name ?? 'Product' }}

                                </span>


                                <a href="{{ route('products.show', $item->product) }}" class="cart-product-name">

                                    {{ $item->product->name }}

                                </a>


                                <div class="cart-product-price">

                                    {{ number_format($item->product->final_price, 2) }}

                                    <span>
                                        {{ setting('currency') }}
                                    </span>

                                </div>


                                @if($item->product->quantity <= 5) <span class="cart-stock-warning">

                                    <i class="bi bi-exclamation-circle"></i>

                                    Only {{ $item->product->quantity }} left

                                    </span>

                                    @else

                                    <span class="cart-stock-good">

                                        <i class="bi bi-check-circle"></i>

                                        In stock

                                    </span>

                                    @endif

                            </div>


                            {{-- Quantity --}}

                            {{-- Quantity --}}
                            <div class="cart-quantity-area">

                                <span class="cart-field-label">
                                    QUANTITY
                                </span>

                                <form action="{{ route('cart.update', $item->product) }}" method="POST" class="cart-update-form">

                                    @csrf
                                    @method('PUT')

                                    <div class="quantity-control">

                                        <button type="button" class="quantity-btn decrease-btn" aria-label="Decrease quantity">
                                            <i class="bi bi-dash"></i>
                                        </button>

                                        <input type="number" name="quantity" class="quantity-input" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" readonly aria-label="Product quantity">

                                        <button type="button" class="quantity-btn increase-btn" aria-label="Increase quantity">
                                            <i class="bi bi-plus"></i>
                                        </button>

                                    </div>

                                </form>

                            </div>

                            {{-- Total --}}

                            <div class="cart-product-total">

                                <span>
                                    TOTAL
                                </span>

                                <strong class="row-total">

                                    {{ number_format($item->product->final_price * $item->quantity, 2) }}

                                    <small>
                                        {{ setting('currency') }}
                                    </small>

                                </strong>

                            </div>


                            {{-- Remove --}}

                            <div class="cart-product-actions">

                                <div class="dropdown">

                                    <button type="button" class="cart-more-btn" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Product actions">

                                        <i class="bi bi-three-dots"></i>

                                    </button>


                                    <ul class="dropdown-menu dropdown-menu-end cart-action-menu">

                                        <li>

                                            <form action="{{ route('cart.destroy', $item->product) }}" method="POST" class="remove-item-form">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger">

                                                    <i class="bi bi-trash3"></i>

                                                    Remove Item

                                                </button>

                                            </form>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </article>

                        @endforeach

                    </div>


                    {{-- Bottom --}}

                    <div class="cart-products-footer">

                        <a href="{{ route('products.index') }}" class="cart-back-shopping">

                            <i class="bi bi-arrow-left"></i>

                            Continue Shopping

                        </a>

                        <span>

                            <i class="bi bi-shield-check"></i>

                            Secure checkout

                        </span>

                    </div>

                </section>

            </div>


            {{-- =================================================
                    ORDER SUMMARY
                ================================================== --}}

            <div class="col-xl-4">

                <aside class="cart-summary-card">


                    {{-- Summary Header --}}

                    <div class="cart-summary-header">

                        <div>

                            <span>
                                CHECKOUT
                            </span>

                            <h2>
                                Order Summary
                            </h2>

                        </div>

                        <div class="cart-summary-icon">

                            <i class="bi bi-receipt"></i>

                        </div>

                    </div>


                    {{-- Summary Content --}}

                    <div class="cart-summary-body">


                        <div class="cart-summary-line">

                            <span>
                                Products
                            </span>

                            <strong id="summary-items">
                                {{ $cart->items->count() }}
                            </strong>

                        </div>


                        <div class="cart-summary-line">

                            <span>
                                Quantity
                            </span>

                            <strong id="summary-quantity">
                                {{ $cart->items->sum('quantity') }}
                            </strong>

                        </div>


                        <div class="cart-summary-line">

                            <span>
                                Subtotal
                            </span>

                            <strong id="summary-subtotal">

                                {{ number_format($totals['subtotal'], 2) }}

                                {{ setting('currency') }}

                            </strong>

                        </div>


                        <div class="cart-summary-line">

                            <span>
                                Shipping
                            </span>

                            <strong class="free-shipping">

                                <i class="bi bi-check-circle-fill"></i>

                                Free

                            </strong>

                        </div>


                        <div class="cart-summary-divider"></div>


                        {{-- Total --}}

                        <div class="cart-grand-total">

                            <span>
                                Total
                            </span>

                            <strong id="summary-total">

                                {{ number_format($totals['total'], 2) }}

                                <small>
                                    {{ setting('currency') }}
                                </small>

                            </strong>

                        </div>


                        {{-- Checkout --}}

                        <a href="{{ route('checkout.index') }}" class="cart-checkout-btn">

                            <span>
                                Proceed to Checkout
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </a>


                        {{-- Payment note --}}

                        <div class="cart-secure-note">

                            <i class="bi bi-lock-fill"></i>

                            <div>

                                <strong>
                                    Secure checkout
                                </strong>

                                <span>
                                    Your shopping experience is safe and protected.
                                </span>

                            </div>

                        </div>


                        {{-- Continue --}}

                        <a href="{{ route('products.index') }}" class="cart-summary-shopping">

                            Continue Shopping

                        </a>


                        {{-- Clear --}}

                        <form action="{{ route('cart.clear') }}" method="POST" class="clear-cart-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="cart-clear-btn">

                                <i class="bi bi-trash3"></i>

                                Clear Cart

                            </button>

                        </form>

                    </div>

                </aside>

            </div>

        </div>


        @else

        {{-- =================================================
                EMPTY CART
            ================================================== --}}

        <section class="cart-empty-card">

            <div class="cart-empty-icon">

                <i class="bi bi-cart-x"></i>

            </div>

            <span>
                YOUR CART IS WAITING
            </span>

            <h2>
                Your Cart Is Empty
            </h2>

            <p>
                Looks like you haven't added anything to your cart yet.
                Discover something you'll love.
            </p>

            <a href="{{ route('products.index') }}" class="cart-empty-btn">

                <i class="bi bi-bag"></i>

                Start Shopping

                <i class="bi bi-arrow-right"></i>

            </a>

        </section>

        @endif

    </div>

</div>

@endsection
