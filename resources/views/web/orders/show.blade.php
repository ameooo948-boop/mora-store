@extends('web.layouts.app')

@section('title', 'Order Details')

@section('page-title', 'Order Details')

@section('content')

@php
$steps = [
'pending' => 'Pending',
'processing' => 'Processing',
'shipped' => 'Shipped',
'delivered' => 'Delivered',
];

$currentStatus = $order->status->value;

$currentStep = array_key_exists($currentStatus, $steps)
? array_search($currentStatus, array_keys($steps))
: -1;
@endphp


<div class="order-details-page">

    <div class="container">

        {{-- =====================================================
            ORDER HERO
        ====================================================== --}}

        <div class="order-hero">

            <div class="order-hero-left">

                <div class="order-back">

                    <a href="{{ route('orders.index') }}">
                        <i class="bi bi-arrow-left"></i>
                        Back to Orders
                    </a>

                </div>

                <span class="order-eyebrow">
                    <i class="bi bi-receipt"></i>
                    ORDER DETAILS
                </span>

                <h1>
                    #{{ $order->order_number }}
                </h1>

                <p>
                    Placed on {{ $order->formatted_date }}
                </p>

            </div>


            <div class="order-hero-right">

                <div class="order-status-large {{ $order->status_badge }}">

                    <span class="status-pulse"></span>

                    <i class="bi {{ $order->status_icon }}"></i>

                    {{ $order->status_label }}

                </div>

            </div>

        </div>


        {{-- =====================================================
            ORDER STATS
        ====================================================== --}}

        <div class="order-stats">

            <div class="order-detail-stat">

                <div class="order-detail-stat-icon blue">
                    <i class="bi bi-hash"></i>
                </div>

                <div>
                    <span>Order Number</span>
                    <strong>{{ $order->order_number }}</strong>
                </div>

            </div>


            <div class="order-detail-stat">

                <div class="order-detail-stat-icon purple">
                    <i class="bi bi-calendar3"></i>
                </div>

                <div>
                    <span>Order Date</span>
                    <strong>{{ $order->formatted_date }}</strong>
                </div>

            </div>


            <div class="order-detail-stat">

                <div class="order-detail-stat-icon orange">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>
                    <span>Items</span>
                    <strong>{{ $order->items_count }}</strong>
                </div>

            </div>


            <div class="order-detail-stat">

                <div class="order-detail-stat-icon green">
                    <i class="bi bi-wallet2"></i>
                </div>

                <div>
                    <span>Total</span>
                    <strong>
                        {{ $order->formatted_total }}
                        <small>{{ setting('currency') }}</small>
                    </strong>
                </div>

            </div>

        </div>


        {{-- =====================================================
            INFORMATION GRID
        ====================================================== --}}

        <div class="order-info-grid">


            {{-- Customer --}}

            <section class="order-info-card">

                <div class="order-card-heading">

                    <div class="order-heading-icon blue">
                        <i class="bi bi-person"></i>
                    </div>

                    <div>
                        <span>ORDER CUSTOMER</span>
                        <h2>Customer</h2>
                    </div>

                </div>


                <div class="customer-profile">

                    <div class="customer-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="customer-info">

                        <strong>
                            {{ $order->user->name }}
                        </strong>

                        <a href="mailto:{{ $order->user->email }}">
                            <i class="bi bi-envelope"></i>
                            {{ $order->user->email }}
                        </a>

                    </div>

                </div>

            </section>


            {{-- Shipping --}}

            <section class="order-info-card">

                <div class="order-card-heading">

                    <div class="order-heading-icon green">
                        <i class="bi bi-geo-alt"></i>
                    </div>

                    <div>
                        <span>DELIVERY INFORMATION</span>
                        <h2>Shipping Address</h2>
                    </div>

                </div>


                <div class="shipping-details">

                    <div class="shipping-person">

                        <strong>
                            {{ $order->shipping_name }}
                        </strong>

                        <a href="tel:{{ $order->shipping_phone }}">
                            <i class="bi bi-telephone"></i>
                            {{ $order->shipping_phone }}
                        </a>

                    </div>


                    <div class="shipping-line">

                        <i class="bi bi-globe2"></i>

                        <span>
                            {{ $order->shipping_country }}
                        </span>

                    </div>


                    <div class="shipping-line">

                        <i class="bi bi-map"></i>

                        <span>
                            {{ $order->shipping_state }},
                            {{ $order->shipping_city }}
                        </span>

                    </div>


                    <div class="shipping-line">

                        <i class="bi bi-house"></i>

                        <span>
                            {{ $order->shipping_address }}
                        </span>

                    </div>


                    @if($order->shipping_postal_code)

                    <div class="shipping-line">

                        <i class="bi bi-mailbox2"></i>

                        <span>
                            {{ $order->shipping_postal_code }}
                        </span>

                    </div>

                    @endif

                </div>

            </section>


            {{-- Progress --}}

            <section class="order-info-card order-progress-card">

                <div class="order-card-heading">

                    <div class="order-heading-icon purple">
                        <i class="bi bi-activity"></i>
                    </div>

                    <div>
                        <span>ORDER STATUS</span>
                        <h2>Order Progress</h2>
                    </div>

                </div>


                <div class="order-timeline">

                    @foreach($steps as $key => $label)

                    @php
                    $stepIndex = $loop->index;
                    $active = $stepIndex <= $currentStep; $current=$key===$currentStatus; @endphp <div class="timeline-step {{ $active ? 'completed' : '' }} {{ $current ? 'current' : '' }}">

                        <div class="timeline-marker">

                            @if($active)

                            <i class="bi bi-check-lg"></i>

                            @else

                            <span>
                                {{ $loop->iteration }}
                            </span>

                            @endif

                        </div>

                        <div class="timeline-label">

                            <strong>
                                {{ $label }}
                            </strong>

                            @if($current)

                            <small>
                                Current status
                            </small>

                            @endif

                        </div>

                </div>

                @endforeach

        </div>

        </section>

    </div>


    {{-- =====================================================
            ORDER ITEMS
        ====================================================== --}}

    <section class="order-items-card">

        <div class="order-section-header">

            <div>

                <span class="order-section-eyebrow">
                    PURCHASED PRODUCTS
                </span>

                <h2>
                    Order Items
                </h2>

            </div>

            <div class="items-count-badge">

                <i class="bi bi-box-seam"></i>

                {{ $order->items_count }}
                {{ Str::plural('Item', $order->items_count) }}

            </div>

        </div>


        <div class="order-items-table-wrapper">

            <table class="order-items-table">

                <thead>

                    <tr>

                        <th>
                            Product
                        </th>

                        <th>
                            SKU
                        </th>

                        <th class="text-center">
                            Price
                        </th>

                        <th class="text-center">
                            Qty
                        </th>

                        <th class="text-end">
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($order->items as $item)

                    <tr>

                        <td>

                            <div class="ordered-product">

                                <div class="ordered-product-image">

                                    @if($item->product?->images->isNotEmpty())

                                    <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}">

                                    @else

                                    <div class="product-no-image">
                                        <i class="bi bi-image"></i>
                                    </div>

                                    @endif

                                </div>


                                <div class="ordered-product-info">

                                    @if($item->product)

                                    <strong>
                                        {{ $item->product->name }}
                                    </strong>

                                    @else

                                    <strong class="deleted-product">
                                        Product Deleted
                                    </strong>

                                    @endif

                                    <span>
                                        Product item
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            @if($item->product)

                            <span class="sku-badge">
                                {{ $item->product->sku }}
                            </span>

                            @else

                            <span class="sku-badge muted">
                                N/A
                            </span>

                            @endif

                        </td>


                        <td class="text-center">

                            <span class="item-price">
                                {{ number_format($item->price, 2) }}
                                <small>{{ setting('currency') }}</small>
                            </span>

                        </td>


                        <td class="text-center">

                            <span class="quantity-badge">
                                ×{{ $item->quantity }}
                            </span>

                        </td>


                        <td class="text-end">

                            <strong class="item-total">
                                {{ number_format($item->total, 2) }}
                                <small>{{ setting('currency') }}</small>
                            </strong>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Mobile items --}}

        <div class="order-items-mobile">

            @foreach($order->items as $item)

            <article class="mobile-order-item">

                <div class="mobile-item-image">

                    @if($item->product?->images->isNotEmpty())

                    <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}">

                    @else

                    <i class="bi bi-image"></i>

                    @endif

                </div>


                <div class="mobile-item-info">

                    <strong>
                        {{ $item->product?->name ?? 'Product Deleted' }}
                    </strong>

                    <span>
                        {{ $item->product?->sku ?? 'N/A' }}
                    </span>

                    <div>

                        <b>
                            ×{{ $item->quantity }}
                        </b>

                        <strong>
                            {{ number_format($item->total, 2) }}
                            {{ setting('currency') }}
                        </strong>

                    </div>

                </div>

            </article>

            @endforeach

        </div>

    </section>


    {{-- =====================================================
            SUMMARY
        ====================================================== --}}

    <div class="order-bottom-grid">


        <div class="order-note-card">

            <div class="order-note-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <div>

                <strong>
                    Order secured
                </strong>

                <p>
                    Your order information and payment details are securely protected.
                </p>

            </div>

        </div>


        <section class="order-summary-card">

            <div class="order-section-header compact">

                <div>

                    <span class="order-section-eyebrow">
                        PAYMENT BREAKDOWN
                    </span>

                    <h2>
                        Order Summary
                    </h2>

                </div>

            </div>


            <div class="summary-row">

                <span>
                    Subtotal
                </span>

                <strong>
                    {{ $order->formatted_subtotal }}
                    {{ setting('currency') }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Shipping
                </span>

                <strong>
                    {{ $order->formatted_shipping }}
                    {{ setting('currency') }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Discount
                </span>

                <strong class="discount">
                    -{{ $order->formatted_discount }}
                    {{ setting('currency') }}
                </strong>

            </div>


            <div class="summary-divider"></div>


            <div class="summary-total">

                <div>

                    <span>
                        Grand Total
                    </span>

                    <small>
                        Including all charges
                    </small>

                </div>

                <strong>
                    {{ $order->formatted_total }}
                    <small>{{ setting('currency') }}</small>
                </strong>

            </div>


            <div class="summary-actions">

                <a href="{{ route('products.index') }}" class="continue-shopping-btn">
                    <i class="bi bi-bag"></i>
                    Continue Shopping
                </a>


                <button type="button" onclick="window.print()" class="print-order-btn">
                    <i class="bi bi-printer"></i>
                    Print
                </button>

            </div>

        </section>

    </div>

</div>

</div>

@endsection
