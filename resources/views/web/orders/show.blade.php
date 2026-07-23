@extends('web.layouts.app')

@section('title', 'Order Details')

@section('page-title', 'Order Details')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Order #{{ $order->order_number }}

            </h2>

            <p class="text-muted mb-0">

                Placed on {{ $order->formatted_date }}

            </p>

        </div>

        <div class="d-flex gap-2">

            <span class="badge {{ $order->status_badge }} fs-6 px-3 py-2">

                <i class="bi {{ $order->status_icon }} me-2"></i>

                {{ $order->status_label }}

            </span>

            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Order Number

                    </small>

                    <h5 class="fw-bold mt-2">

                        {{ $order->order_number }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Order Date

                    </small>

                    <h5 class="fw-bold mt-2">

                        {{ $order->formatted_date }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Items

                    </small>

                    <h5 class="fw-bold mt-2">

                        {{ $order->items_count }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">

                        Total

                    </small>

                    <h5 class="fw-bold text-success mt-2">

                        ${{ $order->formatted_total }}

                    </h5>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        {{-- Customer --}}
        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Customer

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex align-items-center mb-4">

                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width:60px;height:60px;">

                            <i class="bi bi-person-fill fs-3"></i>

                        </div>

                        <div class="ms-3">

                            <h6 class="mb-1">

                                {{ $order->user->name }}

                            </h6>

                            <small class="text-muted">

                                {{ $order->user->email }}

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Shipping --}}
        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Shipping Address

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <h6 class="fw-bold mb-1">

                            {{ $order->shipping_name }}

                        </h6>

                        <small class="text-muted">

                            <i class="bi bi-telephone me-2"></i>

                            {{ $order->shipping_phone }}

                        </small>

                    </div>

                    <div class="mb-3">

                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>

                        {{ $order->shipping_country }}

                    </div>

                    <div class="mb-3">

                        <i class="bi bi-map-fill text-primary me-2"></i>

                        {{ $order->shipping_state }},
                        {{ $order->shipping_city }}

                    </div>

                    <div class="mb-3">

                        <i class="bi bi-house-door-fill text-primary me-2"></i>

                        {{ $order->shipping_address }}

                    </div>

                    @if($order->shipping_postal_code)

                    <div>

                        <i class="bi bi-mailbox2 text-primary me-2"></i>

                        {{ $order->shipping_postal_code }}

                    </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- Timeline --}}
        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Order Progress

                    </h5>

                </div>

                <div class="card-body">

                    @php

                    $steps = [

                    'pending' => 'Pending',

                    'processing' => 'Processing',

                    'shipped' => 'Shipped',

                    'delivered' => 'Delivered',

                    ];

                    $current = array_search($order->status->value, array_keys($steps));

                    @endphp

                    @foreach($steps as $key => $label)

                    @php

                    $active = $loop->index <= $current; @endphp <div class="d-flex align-items-center mb-3">

                        <div class="rounded-circle {{ $active ? 'bg-success text-white' : 'bg-light text-muted' }} d-flex justify-content-center align-items-center" style="width:36px;height:36px;">

                            @if($active)

                            <i class="bi bi-check"></i>

                            @else

                            {{ $loop->iteration }}

                            @endif

                        </div>

                        <div class="ms-3">

                            <strong>

                                {{ $label }}

                            </strong>

                        </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

{{-- Order Items --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            Order Items

        </h5>

        <span class="badge bg-primary">

            {{ $order->items_count }} Items

        </span>

    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="80">Image</th>

                    <th>Product</th>

                    <th class="text-center">Price</th>

                    <th class="text-center">Qty</th>

                    <th class="text-end">Total</th>

                </tr>

            </thead>

            <tbody>

                @foreach($order->items as $item)

                <tr>

                    <td>

                        @if($item->product?->images->isNotEmpty())

                        <img src="{{ $item->product->images->first()->image_url }}" class="rounded border" width="60" height="60" style="object-fit: cover;">

                        @else

                        <div class="bg-light rounded border d-flex justify-content-center align-items-center" style="width:60px;height:60px;">

                            <i class="bi bi-image text-secondary"></i>

                        </div>

                        @endif

                    </td>

                    <td>

                        @if($item->product)

                        {{-- <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none fw-semibold">

                        {{ $item->product->name }}

                        </a> --}}

                        <div>

                            <small class="text-muted">

                                SKU:
                                {{ $item->product->sku }}

                            </small>

                        </div>

                        @else

                        <span class="text-danger">

                            Product Deleted

                        </span>

                        @endif

                    </td>

                    <td class="text-center">

                        ${{ number_format($item->price,2) }}

                    </td>

                    <td class="text-center">

                        <span class="badge bg-secondary">

                            {{ $item->quantity }}

                        </span>

                    </td>

                    <td class="text-end fw-bold">

                        ${{ number_format($item->total,2) }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- Summary --}}
<div class="row justify-content-end">

    <div class="col-lg-5">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Order Summary

                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <span>

                        Subtotal

                    </span>

                    <strong>

                        ${{ $order->formatted_subtotal }}

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>

                        Shipping

                    </span>

                    <strong>

                        ${{ $order->formatted_shipping }}

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>

                        Discount

                    </span>

                    <strong class="text-danger">

                        -${{ $order->formatted_discount }}

                    </strong>

                </div>

                <hr>

                <div class="d-flex justify-content-between">

                    <h4 class="mb-0">

                        Grand Total

                    </h4>

                    <h3 class="text-success mb-0">

                        ${{ $order->formatted_total }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">

            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">

                <i class="bi bi-shop me-2"></i>

                Continue Shopping

            </a>

            <button onclick="window.print()" class="btn btn-dark">

                <i class="bi bi-printer me-2"></i>

                Print

            </button>

        </div>

    </div>

</div>

</div>

@endsection
