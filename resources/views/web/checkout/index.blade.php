@extends('web.layouts.app')

@section('title', 'Checkout')

@section('page-title', 'Checkout')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Checkout
            </h3>

            <p class="text-muted mb-0">
                Review your order before placing it
            </p>
        </div>

        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i>
            Back To Cart
        </a>
    </div>

    <div class="row">

        {{-- Order Items --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        Order Items
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($cart->items as $item)
                            <tr>

                                <td>
                                    @if($item->product->images->isNotEmpty())
                                    <img src="{{ $item->product->images->first()->image_url }}" width="60" height="60" class="rounded" style="object-fit:cover;">
                                    @else
                                    <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width:60px;height:60px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                    @endif
                                </td>

                                <td>
                                    <strong>
                                        {{ $item->product->name }}
                                    </strong>
                                </td>

                                <td>
                                    ${{ number_format($item->price, 2) }}
                                </td>

                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>
                                    <strong>
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </strong>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if(session()->has('coupon'))
            <div class="alert alert-success mt-3">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <strong>Coupon Applied</strong>
                        <br>
                        {{ session('coupon.code') }}
                    </div>

                    <form action="{{ route('checkout.coupon.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-outline-danger">
                            Remove
                        </button>
                    </form>

                </div>
            </div>
            @endif
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">

                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            Order Summary
                        </h5>
                    </div>

                    {{-- Coupon Form --}}
                    <form action="{{ route('checkout.coupon.store') }}" method="POST">
                        @csrf

                        <div class="mb-4 mt-3">

                            <label class="form-label fw-bold">
                                Coupon Code
                            </label>

                            <div class="input-group">

                                <input type="text" name="coupon_code" class="form-control @error('coupon_code') is-invalid @enderror" value="{{ old('coupon_code') }}" placeholder="Enter coupon code">

                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-ticket-perforated"></i>
                                    Apply
                                </button>

                            </div>

                            @error('coupon_code')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror

                            @if(session('coupon_success'))
                            <div class="alert alert-success mt-3 mb-0">
                                {{ session('coupon_success') }}
                            </div>
                            @endif

                            @if(session('coupon_error'))
                            <div class="alert alert-danger mt-3 mb-0">
                                {{ session('coupon_error') }}
                            </div>
                            @endif

                        </div>
                    </form>

                    {{-- Checkout Form --}}
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>

                            <strong>
                                ${{ number_format($totals['subtotal'], 2) }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>

                            <strong>
                                ${{ number_format($totals['shipping'], 2) }}
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Discount</span>

                            <strong class="text-danger">
                                -${{ number_format($totals['discount'], 2) }}
                            </strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <h5>Total</h5>

                            <h4 class="text-success">
                                ${{ number_format($totals['total'], 2) }}
                            </h4>
                        </div>

                        <hr>

                        {{-- Shipping Address --}}
                        <div class="mb-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h6 class="fw-bold mb-0">
                                    Shipping Address
                                </h6>

                                <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Add Address
                                </a>

                            </div>

                            @forelse($addresses as $address)

                            <label class="card border shadow-sm mb-3" style="cursor:pointer;">

                                <div class="card-body">

                                    <div class="form-check">

                                        <input class="form-check-input" type="radio" name="address_id" value="{{ $address->id }}" @checked( old( 'address_id' , optional( $addresses->firstWhere('is_default', true)
                                        )->id
                                        ) == $address->id
                                        )
                                        >

                                        <span class="fw-bold ms-2">
                                            {{ $address->full_name }}
                                        </span>

                                        @if($address->is_default)
                                        <span class="badge bg-success ms-2">
                                            Default
                                        </span>
                                        @endif

                                    </div>

                                    <div class="mt-3">

                                        <div>
                                            <i class="bi bi-telephone me-2 text-primary"></i>
                                            {{ $address->phone }}
                                        </div>

                                        <div>
                                            <i class="bi bi-geo-alt me-2 text-primary"></i>
                                            {{ $address->country }},
                                            {{ $address->state }},
                                            {{ $address->city }}
                                        </div>
                                        <div>
                                            <i class="bi bi-house-door me-2 text-primary"></i>
                                            {{ $address->address_line }}
                                        </div>

                                        @if($address->postal_code)
                                        <div>
                                            <i class="bi bi-mailbox me-2 text-primary"></i>
                                            {{ $address->postal_code }}
                                        </div>
                                        @endif

                                    </div>

                                </div>

                            </label>

                            @empty

                            <div class="alert alert-warning">
                                You don't have any addresses.
                            </div>

                            @endforelse

                            @error('address_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Payment Method
                            </label>

                            @foreach($paymentMethods as $method)

                            <div class="form-check mb-2">

                                <input class="form-check-input" type="radio" name="payment_method" id="{{ $method->value }}" value="{{ $method->value }}" @checked( old( 'payment_method' , \App\Enums\PaymentMethod::CashOnDelivery->value
                                ) === $method->value
                                )
                                >

                                <label class="form-check-label" for="{{ $method->value }}">

                                    <i class="bi {{ $method->icon() }} me-2"></i>

                                    <strong>
                                        {{ $method->label() }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        {{ $method->description() }}
                                    </small>

                                </label>

                            </div>

                            @endforeach

                            @error('payment_method')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-credit-card me-2"></i>
                            Place Order
                        </button>

                    </form>

                    @if(session()->has('coupon'))

                    <form action="{{ route('checkout.coupon.destroy') }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger w-100">
                            <i class="bi bi-x-circle me-2"></i>
                            Remove Coupon
                        </button>

                    </form>

                    @endif

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
