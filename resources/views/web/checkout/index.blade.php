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

                                    <img src="{{ $item->product->images->first()->image_url }}" width="60" height="60" class="rounded" style="object-fit: cover;">

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

        </div>

        {{-- Summary --}}
        <div class="col-lg-4">

            <div class="card">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Order Summary

                    </h5>

                </div>

                <div class="card-body">

                    <form action="{{ route('checkout.store') }}" method="POST">

                        @csrf

                        <div class="d-flex justify-content-between mb-3">

                            <span>

                                Subtotal

                            </span>

                            <strong>

                                ${{ number_format($totals['subtotal'], 2) }}

                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>

                                Shipping

                            </span>

                            <strong>

                                ${{ number_format($totals['shipping'], 2) }}

                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>

                                Discount

                            </span>

                            <strong class="text-danger">

                                -${{ number_format($totals['discount'], 2) }}

                            </strong>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">

                            <h5>

                                Total

                            </h5>

                            <h4 class="text-success">

                                ${{ number_format($totals['total'], 2) }}

                            </h4>

                        </div>

                        <hr>

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

                            <label for="address{{ $address->id }}" class="card border shadow-sm mb-3" style="cursor:pointer;">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-start">

                                        <div class="form-check">

                                            <input id="address{{ $address->id }}" class="form-check-input" type="radio" name="address_id" value="{{ $address->id }}" {{ old('address_id', optional($addresses->firstWhere('is_default', true))->id) == $address->id ? 'checked' : '' }}>

                                            <span class="fw-bold ms-2">

                                                {{ $address->full_name }}

                                            </span>

                                            @if($address->is_default)

                                            <span class="badge bg-success ms-2">

                                                Default

                                            </span>

                                            @endif

                                        </div>

                                        <a href="{{ route('addresses.edit', $address) }}" class="btn btn-sm btn-light">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                    </div>

                                    <div class="mt-3">

                                        <div class="mb-2">

                                            <i class="bi bi-telephone me-2 text-primary"></i>

                                            {{ $address->phone }}

                                        </div>

                                        <div class="mb-2">

                                            <i class="bi bi-geo-alt me-2 text-primary"></i>

                                            {{ $address->country }},
                                            {{ $address->state }},
                                            {{ $address->city }}

                                        </div>

                                        <div class="mb-2">

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

                                <i class="bi bi-exclamation-circle me-2"></i>

                                You don't have any shipping addresses.

                                <hr>

                                <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-primary">

                                    <i class="bi bi-plus-circle me-2"></i>

                                    Add Your First Address

                                </a>

                            </div>

                            @endforelse

                            @error('address_id')

                            <div class="text-danger small">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <button type="submit" class="btn btn-success w-100">

                            <i class="bi bi-credit-card me-2"></i>

                            Place Order

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
