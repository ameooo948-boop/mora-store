@extends('web.layouts.app')

@section('title', 'My Orders')

@section('page-title', 'My Orders')

@section('content')

<div class="orders-page">

    <div class="container">

        {{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <div class="orders-header">

            <div>

                <span class="orders-eyebrow">
                    <i class="bi bi-bag-check-fill"></i>
                    ORDER CENTER
                </span>

                <h1>
                    My Orders
                </h1>

                <p>
                    View your purchases, track their status, and manage your orders.
                </p>

            </div>


            <a href="{{ route('products.index') }}" class="orders-shop-btn">
                <i class="bi bi-bag"></i>

                Continue Shopping

                <i class="bi bi-arrow-right"></i>
            </a>

        </div>


        {{-- =====================================================
            STATISTICS
        ====================================================== --}}

        <div class="orders-statistics">

            {{-- Total --}}

            <div class="order-stat-card total">

                <div class="order-stat-icon">
                    <i class="bi bi-bag-check"></i>
                </div>

                <div class="order-stat-content">

                    <span>
                        Total Orders
                    </span>

                    <strong>
                        {{ $statistics['total'] }}
                    </strong>

                    <small>
                        All your orders
                    </small>

                </div>

            </div>


            {{-- Pending --}}

            <div class="order-stat-card pending">

                <div class="order-stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div class="order-stat-content">

                    <span>
                        Pending
                    </span>

                    <strong>
                        {{ $statistics['pending'] }}
                    </strong>

                    <small>
                        Being processed
                    </small>

                </div>

            </div>


            {{-- Delivered --}}

            <div class="order-stat-card delivered">

                <div class="order-stat-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div class="order-stat-content">

                    <span>
                        Delivered
                    </span>

                    <strong>
                        {{ $statistics['delivered'] }}
                    </strong>

                    <small>
                        Successfully delivered
                    </small>

                </div>

            </div>

        </div>


        {{-- =====================================================
            ORDERS
        ====================================================== --}}

        <div class="orders-panel">

            <div class="orders-panel-header">

                <div>

                    <span class="orders-panel-eyebrow">
                        PURCHASE HISTORY
                    </span>

                    <h2>
                        Recent Orders
                    </h2>

                </div>

                @if($orders->total())

                <span class="orders-total-count">
                    {{ $orders->total() }}
                    {{ Str::plural('order', $orders->total()) }}
                </span>

                @endif

            </div>


            @if($orders->count())

            {{-- Desktop Table --}}

            <div class="orders-table-wrapper">

                <table class="orders-table">

                    <thead>

                        <tr>

                            <th>
                                Order
                            </th>

                            <th>
                                Items
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($orders as $order)

                        <tr>

                            {{-- Order --}}

                            <td>

                                <div class="order-number">

                                    <div class="order-icon">
                                        <i class="bi bi-receipt"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $order->order_number }}
                                        </strong>

                                        <span>
                                            Order #{{ $order->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- Items --}}

                            <td>

                                <span class="order-items">

                                    <i class="bi bi-box-seam"></i>

                                    {{ $order->items_count }}

                                    {{ Str::plural('item', $order->items_count) }}

                                </span>

                            </td>


                            {{-- Total --}}

                            <td>

                                <div class="order-total">

                                    <strong>
                                        {{ number_format($order->total, 2) }}
                                    </strong>

                                    <span>
                                        {{ setting('currency') }}
                                    </span>

                                </div>

                            </td>


                            {{-- Status --}}

                            <td>

                                <span class="order-status {{ $order->status_badge }}">

                                    <i class="bi {{ $order->status_icon }}"></i>

                                    {{ $order->status_label }}

                                </span>

                            </td>


                            {{-- Date --}}

                            <td>

                                <div class="order-date">

                                    <strong>
                                        {{ $order->created_at->format('d M Y') }}
                                    </strong>

                                    <span>
                                        {{ $order->created_at->format('h:i A') }}
                                    </span>

                                </div>

                            </td>


                            {{-- Action --}}

                            <td>

                                <a href="{{ route('orders.show', $order) }}" class="order-view-btn" title="View Order">
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Mobile Orders --}}

            <div class="orders-mobile-list">

                @foreach($orders as $order)

                <article class="mobile-order-card">

                    <div class="mobile-order-top">

                        <div class="order-number">

                            <div class="order-icon">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div>

                                <strong>
                                    {{ $order->order_number }}
                                </strong>

                                <span>
                                    {{ $order->created_at->format('d M Y') }}
                                </span>

                            </div>

                        </div>


                        <span class="order-status {{ $order->status_badge }}">

                            <i class="bi {{ $order->status_icon }}"></i>

                            {{ $order->status_label }}

                        </span>

                    </div>


                    <div class="mobile-order-details">

                        <div>

                            <span>
                                Items
                            </span>

                            <strong>
                                {{ $order->items_count }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Total
                            </span>

                            <strong>
                                {{ number_format($order->total, 2) }}
                                {{ setting('currency') }}
                            </strong>

                        </div>

                    </div>


                    <a href="{{ route('orders.show', $order) }}" class="mobile-order-view">
                        View Order
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </article>

                @endforeach

            </div>


            {{-- Pagination --}}

            @if($orders->hasPages())

            <div class="orders-pagination">

                {{ $orders->links() }}

            </div>

            @endif


            @else

            {{-- =====================================================
                    EMPTY STATE
                ====================================================== --}}

            <div class="orders-empty">

                <div class="orders-empty-icon">

                    <i class="bi bi-bag-x"></i>

                </div>

                <span class="orders-eyebrow">
                    NO PURCHASES YET
                </span>

                <h3>
                    Your order history is empty
                </h3>

                <p>
                    You haven't placed any orders yet.
                    Discover something you love and start shopping today.
                </p>

                <a href="{{ route('products.index') }}" class="orders-empty-btn">
                    <i class="bi bi-bag"></i>

                    Start Shopping

                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

            @endif

        </div>

    </div>

</div>

@endsection
