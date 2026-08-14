@extends('web.layouts.app')

@section('title', 'Checkout')

@section('page-title', 'Checkout')

@section('content')

<div class="checkout-page">

    <div class="container">

        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <div class="checkout-header">

            <div>

                <span class="checkout-eyebrow">
                    <i class="bi bi-shield-check-fill"></i>
                    SECURE CHECKOUT
                </span>

                <h1>
                    Complete Your Order
                </h1>

                <p>
                    Review your order, choose your delivery address,
                    and select your preferred payment method.
                </p>

            </div>

            <a href="{{ route('cart.index') }}" class="checkout-back-btn">

                <i class="bi bi-arrow-left"></i>

                Back To Cart

            </a>

        </div>


        {{-- =====================================================
            CHECKOUT STEPS
        ====================================================== --}}

        <div class="checkout-steps">

            <div class="checkout-step active">

                <span class="checkout-step-icon">
                    <i class="bi bi-bag-check-fill"></i>
                </span>

                <div>
                    <strong>
                        Review
                    </strong>

                    <small>
                        Your order
                    </small>
                </div>

            </div>


            <div class="checkout-step-line"></div>


            <div class="checkout-step active">

                <span class="checkout-step-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </span>

                <div>
                    <strong>
                        Delivery
                    </strong>

                    <small>
                        Your address
                    </small>
                </div>

            </div>


            <div class="checkout-step-line"></div>


            <div class="checkout-step">

                <span class="checkout-step-icon">
                    <i class="bi bi-credit-card-fill"></i>
                </span>

                <div>
                    <strong>
                        Payment
                    </strong>

                    <small>
                        Place order
                    </small>
                </div>

            </div>

        </div>


        <div class="row g-4 align-items-start">


            {{-- =================================================
                LEFT SIDE
            ================================================== --}}

            <div class="col-xl-8">


                {{-- =================================================
                    ORDER ITEMS
                ================================================== --}}

                <section class="checkout-card">

                    <div class="checkout-card-header">

                        <div>

                            <span>
                                YOUR ORDER
                            </span>

                            <h2>
                                Order Items
                            </h2>

                        </div>

                        <span class="checkout-items-count">

                            {{ $cart->items->count() }}

                            {{ Str::plural('item', $cart->items->count()) }}

                        </span>

                    </div>


                    <div class="checkout-items">

                        @foreach($cart->items as $item)

                        <div class="checkout-item">

                            <a href="{{ route('products.show', $item->product) }}" class="checkout-item-image">

                                @if($item->product->images->isNotEmpty())

                                <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}">

                                @else

                                <div>
                                    <i class="bi bi-image"></i>
                                </div>

                                @endif

                            </a>


                            <div class="checkout-item-info">

                                <span>
                                    {{ $item->product->category->name ?? 'Product' }}
                                </span>

                                <a href="{{ route('products.show', $item->product) }}">
                                    {{ $item->product->name }}
                                </a>

                                <small>
                                    Quantity: {{ $item->quantity }}
                                </small>

                            </div>


                            <div class="checkout-item-price">

                                <span>
                                    {{ number_format($item->price, 2) }}
                                    {{ setting('currency') }}
                                </span>

                                <strong>
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                    {{ setting('currency') }}
                                </strong>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </section>


                {{-- =================================================
                    COUPON
                ================================================== --}}

                <section class="checkout-card checkout-coupon-card">

                    @if(session()->has('coupon'))

                    <div class="coupon-applied">

                        <div class="coupon-applied-icon">

                            <i class="bi bi-ticket-perforated-fill"></i>

                        </div>

                        <div>

                            <span>
                                COUPON APPLIED
                            </span>

                            <strong>
                                {{ session('coupon.code') }}
                            </strong>

                        </div>


                        <form action="{{ route('checkout.coupon.destroy') }}" method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="coupon-remove-btn">

                                <i class="bi bi-x-lg"></i>

                                Remove

                            </button>

                        </form>

                    </div>

                    @else

                    <div class="coupon-header">

                        <div class="coupon-icon">

                            <i class="bi bi-ticket-perforated"></i>

                        </div>

                        <div>

                            <h3>
                                Have a coupon?
                            </h3>

                            <p>
                                Enter your promo code to unlock a discount.
                            </p>

                        </div>

                    </div>


                    <form action="{{ route('checkout.coupon.store') }}" method="POST" class="coupon-form">

                        @csrf

                        <div>

                            <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Enter coupon code" class="@error('coupon_code') is-invalid @enderror">

                            @error('coupon_code')

                            <small class="coupon-error">
                                {{ $message }}
                            </small>

                            @enderror

                        </div>


                        <button type="submit">

                            <i class="bi bi-arrow-right-circle"></i>

                            Apply

                        </button>

                    </form>


                    @if(session('coupon_success'))

                    <div class="coupon-message success">

                        <i class="bi bi-check-circle-fill"></i>

                        {{ session('coupon_success') }}

                    </div>

                    @endif


                    @if(session('coupon_error'))

                    <div class="coupon-message error">

                        <i class="bi bi-exclamation-circle-fill"></i>

                        {{ session('coupon_error') }}

                    </div>

                    @endif

                    @endif

                </section>


                {{-- =================================================
                    SHIPPING ADDRESS
                ================================================== --}}

                <section class="checkout-card">

                    <div class="checkout-card-header">

                        <div>

                            <span>
                                DELIVERY
                            </span>

                            <h2>
                                Shipping Address
                            </h2>

                        </div>


                        <a href="{{ route('addresses.create') }}" class="checkout-add-btn">

                            <i class="bi bi-plus-lg"></i>

                            Add Address

                        </a>

                    </div>


                    <div class="checkout-addresses">

                        @forelse($addresses as $address)

                        <label class="address-option">

                            <input type="radio" name="address_id" value="{{ $address->id }}" form="checkout-form" @checked( old( 'address_id' , optional( $addresses->firstWhere('is_default', true)
                            )->id
                            ) == $address->id
                            )
                            >


                            <div class="address-option-body">

                                <div class="address-option-top">

                                    <div class="address-person">

                                        <span class="address-radio">

                                            <i class="bi bi-check"></i>

                                        </span>

                                        <strong>
                                            {{ $address->full_name }}
                                        </strong>

                                    </div>


                                    @if($address->is_default)

                                    <span class="address-default">

                                        <i class="bi bi-check-circle-fill"></i>

                                        Default

                                    </span>

                                    @endif

                                </div>


                                <div class="address-details">

                                    <span>

                                        <i class="bi bi-telephone-fill"></i>

                                        {{ $address->phone }}

                                    </span>

                                    <span>

                                        <i class="bi bi-geo-alt-fill"></i>

                                        {{ $address->country }},
                                        {{ $address->state }},
                                        {{ $address->city }}

                                    </span>

                                    <span>

                                        <i class="bi bi-house-fill"></i>

                                        {{ $address->address_line }}

                                    </span>


                                    @if($address->postal_code)

                                    <span>

                                        <i class="bi bi-mailbox2"></i>

                                        {{ $address->postal_code }}

                                    </span>

                                    @endif

                                </div>

                            </div>

                        </label>

                        @empty

                        <div class="checkout-empty-address">

                            <div>

                                <i class="bi bi-geo-alt"></i>

                            </div>

                            <strong>
                                No delivery address
                            </strong>

                            <p>
                                Add an address before placing your order.
                            </p>

                            <a href="{{ route('addresses.create') }}">

                                <i class="bi bi-plus-lg"></i>

                                Add New Address

                            </a>

                        </div>

                        @endforelse


                        @error('address_id')

                        <div class="checkout-field-error">

                            <i class="bi bi-exclamation-circle"></i>

                            {{ $message }}

                        </div>

                        @enderror

                    </div>

                </section>


                {{-- =================================================
                    PAYMENT
                ================================================== --}}

                <section class="checkout-card">

                    <div class="checkout-card-header">

                        <div>

                            <span>
                                PAYMENT
                            </span>

                            <h2>
                                Payment Method
                            </h2>

                        </div>

                        <div class="payment-secure">

                            <i class="bi bi-shield-lock-fill"></i>

                            Secure

                        </div>

                    </div>


                    <div class="payment-options">

                        @foreach($paymentMethods as $method)

                        <label class="payment-option">

                            <input type="radio" name="payment_method" id="{{ $method->value }}" value="{{ $method->value }}" form="checkout-form" @checked( old( 'payment_method' , \App\Enums\PaymentMethod::CashOnDelivery->value
                            ) === $method->value
                            )
                            >


                            <div class="payment-option-body">

                                <div class="payment-radio">

                                    <i class="bi bi-check"></i>

                                </div>


                                <div class="payment-method-icon">

                                    <i class="bi {{ $method->icon() }}"></i>

                                </div>


                                <div class="payment-method-info">

                                    <strong>
                                        {{ $method->label() }}
                                    </strong>

                                    <span>
                                        {{ $method->description() }}
                                    </span>

                                </div>

                            </div>

                        </label>

                        @endforeach

                    </div>


                    @error('payment_method')

                    <div class="checkout-field-error">

                        <i class="bi bi-exclamation-circle"></i>

                        {{ $message }}

                    </div>

                    @enderror

                </section>

            </div>


            {{-- =================================================
                RIGHT SIDE — SUMMARY
            ================================================== --}}

            <div class="col-xl-4">

                <aside class="checkout-summary">

                    <div class="checkout-summary-header">

                        <div>

                            <span>
                                ORDER REVIEW
                            </span>

                            <h2>
                                Summary
                            </h2>

                        </div>

                        <div class="checkout-summary-icon">

                            <i class="bi bi-receipt-cutoff"></i>

                        </div>

                    </div>


                    <div class="checkout-summary-body">

                        {{-- Coupon discount --}}

                        <div class="checkout-summary-line">

                            <span>
                                Subtotal
                            </span>

                            <strong>

                                {{ number_format($totals['subtotal'], 2) }}

                                {{ setting('currency') }}

                            </strong>

                        </div>


                        <div class="checkout-summary-line">

                            <span>
                                Shipping
                            </span>

                            <strong>

                                {{ number_format($totals['shipping'], 2) }}

                                {{ setting('currency') }}

                            </strong>

                        </div>


                        <div class="checkout-summary-line">

                            <span>
                                Discount
                            </span>

                            <strong class="discount">

                                -

                                {{ number_format($totals['discount'], 2) }}

                                {{ setting('currency') }}

                            </strong>

                        </div>


                        <div class="checkout-summary-divider"></div>


                        <div class="checkout-total">

                            <span>
                                Total
                            </span>

                            <strong>

                                {{ number_format($totals['total'], 2) }}

                                <small>
                                    {{ setting('currency') }}
                                </small>

                            </strong>

                        </div>


                        {{-- Submit Form --}}

                        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">

                            @csrf

                            <button type="submit" class="place-order-btn">

                                <span>

                                    <i class="bi bi-lock-fill"></i>

                                    Place Order

                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </button>

                        </form>


                        <div class="checkout-protection">

                            <i class="bi bi-shield-check-fill"></i>

                            <div>

                                <strong>
                                    Safe & Secure
                                </strong>

                                <span>
                                    Your order information is protected.
                                </span>

                            </div>

                        </div>


                        <div class="checkout-summary-note">

                            <i class="bi bi-info-circle"></i>

                            By placing your order, you agree to our
                            shopping and delivery terms.

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</div>

@endsection
