@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')

<div class="order-details-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="order-details-header">

        <div class="order-details-heading">

            <a href="{{ route('admin.orders.index') }}" class="order-back-btn" title="Back to Orders">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>

                <span class="order-details-eyebrow">
                    ORDER DETAILS
                </span>

                <h1>
                    {{ $order->order_number }}
                </h1>

                <div class="order-details-meta">

                    <span>
                        <i class="bi bi-calendar3"></i>
                        {{ $order->formatted_date }}
                    </span>

                    <span class="order-meta-dot"></span>

                    <span>
                        <i class="bi bi-hash"></i>
                        Order #{{ $order->id }}
                    </span>

                </div>

            </div>

        </div>


        <div class="order-header-status">

            <span class="order-status {{ $order->status_badge }}">

                <i class="bi {{ $order->status_icon ?? 'bi-circle-fill' }}"></i>

                {{ $order->status_label }}

            </span>

        </div>

    </div>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <div class="row g-3">

        {{-- =================================================
             LEFT
        ================================================== --}}

        <div class="col-xl-8">


            {{-- =============================================
                 PRODUCTS
            ============================================== --}}

            <div class="order-panel mb-3">

                <div class="order-panel-header">

                    <div class="order-panel-title">

                        <div class="order-panel-icon blue">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Order Items
                            </h3>

                            <span>
                                Products included in this order
                            </span>

                        </div>

                    </div>


                    <span class="order-item-count">

                        {{ $order->items->count() }}

                        {{ Str::plural('Item', $order->items->count()) }}

                    </span>

                </div>


                <div class="order-products">

                    @foreach($order->items as $item)

                    <div class="order-product">

                        <div class="order-product-image">

                            @if($item->product && $item->product->images->isNotEmpty())

                            <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}">

                            @else

                            <div class="order-product-placeholder">
                                <i class="bi bi-image"></i>
                            </div>

                            @endif

                        </div>


                        <div class="order-product-info">

                            <strong>

                                {{ $item->product->name ?? 'Product unavailable' }}

                            </strong>

                            @if($item->product?->sku)

                            <small>
                                SKU: {{ $item->product->sku }}
                            </small>

                            @endif

                        </div>


                        <div class="order-product-price">

                            <span>
                                Price
                            </span>

                            <strong>
                                {{ number_format($item->price, 2) }}
                            </strong>

                        </div>


                        <div class="order-product-qty">

                            <span>
                                Qty
                            </span>

                            <strong>
                                × {{ $item->quantity }}
                            </strong>

                        </div>


                        <div class="order-product-total">

                            <span>
                                Total
                            </span>

                            <strong>
                                {{ number_format($item->total, 2) }}
                            </strong>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>


            {{-- =============================================
                 STATUS HISTORY
            ============================================== --}}

            <div class="order-panel">

                <div class="order-panel-header">

                    <div class="order-panel-title">

                        <div class="order-panel-icon purple">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div>

                            <h3>
                                Status History
                            </h3>

                            <span>
                                Order status changes and activity
                            </span>

                        </div>

                    </div>

                </div>


                <div class="order-timeline">

                    @forelse($order->statusHistories as $history)

                    <div class="order-timeline-item">

                        <div class="timeline-marker">

                            <i class="bi bi-check-lg"></i>

                        </div>

                        <div class="timeline-content">

                            <div class="timeline-top">

                                <div>

                                    @if($history->old_status)

                                    <strong>
                                        {{ $history->old_status->label() }}
                                    </strong>

                                    <i class="bi bi-arrow-right mx-1"></i>

                                    <strong>
                                        {{ $history->new_status->label() }}
                                    </strong>

                                    @else

                                    <strong>
                                        {{ $history->new_status->label() }}
                                    </strong>

                                    <span class="timeline-initial">
                                        Initial Status
                                    </span>

                                    @endif

                                </div>


                                <time>

                                    {{ $history->changed_at->format('M d, Y') }}

                                    <span>
                                        {{ $history->changed_at->format('h:i A') }}
                                    </span>

                                </time>

                            </div>


                            @if($history->user)

                            <div class="timeline-user">

                                <i class="bi bi-person"></i>

                                Changed by
                                <strong>
                                    {{ $history->user->name }}
                                </strong>

                            </div>

                            @endif


                            @if($history->notes)

                            <div class="timeline-note">

                                <i class="bi bi-chat-left-text"></i>

                                {{ $history->notes }}

                            </div>

                            @endif

                        </div>

                    </div>

                    @empty

                    <div class="order-empty-history">

                        <div>
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <strong>
                            No status history
                        </strong>

                        <span>
                            No status changes have been recorded for this order yet.
                        </span>

                    </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- =================================================
             RIGHT
        ================================================== --}}

        <div class="col-xl-4">


            {{-- =============================================
                 CUSTOMER
            ============================================== --}}

            <div class="order-panel mb-3">

                <div class="order-panel-header">

                    <div class="order-panel-title">

                        <div class="order-panel-icon green">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Customer
                            </h3>

                            <span>
                                Customer information
                            </span>

                        </div>

                    </div>

                </div>


                <div class="customer-card">

                    <div class="customer-avatar">

                        {{ strtoupper(
                            substr($order->user->name, 0, 1)
                        ) }}

                    </div>

                    <div class="customer-info">

                        <strong>
                            {{ $order->user->name }}
                        </strong>

                        <span>
                            {{ $order->user->email }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =============================================
                 SHIPPING
            ============================================== --}}

            <div class="order-panel mb-3">

                <div class="order-panel-header">

                    <div class="order-panel-title">

                        <div class="order-panel-icon orange">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Shipping Address
                            </h3>

                            <span>
                                Delivery information
                            </span>

                        </div>

                    </div>

                </div>


                <div class="shipping-details">

                    <div class="shipping-recipient">

                        <div class="shipping-icon">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>

                            <strong>
                                {{ $order->shipping_name }}
                            </strong>

                            <span>
                                {{ $order->shipping_phone }}
                            </span>

                        </div>

                    </div>


                    <div class="shipping-line"></div>


                    <div class="shipping-location">

                        <i class="bi bi-globe2"></i>

                        <span>
                            {{ $order->shipping_country }}
                        </span>

                    </div>


                    <div class="shipping-location">

                        <i class="bi bi-map"></i>

                        <span>
                            {{ $order->shipping_state }}
                        </span>

                    </div>


                    <div class="shipping-location">

                        <i class="bi bi-buildings"></i>

                        <span>
                            {{ $order->shipping_city }}
                        </span>

                    </div>


                    <div class="shipping-location address">

                        <i class="bi bi-house-door"></i>

                        <span>
                            {{ $order->shipping_address }}
                        </span>

                    </div>


                    @if($order->shipping_postal_code)

                    <div class="shipping-location">

                        <i class="bi bi-mailbox"></i>

                        <span>
                            {{ $order->shipping_postal_code }}
                        </span>

                    </div>

                    @endif

                </div>

            </div>


            {{-- =============================================
                 ORDER SUMMARY
            ============================================== --}}

            <div class="order-panel mb-3">

                <div class="order-panel-header">

                    <div class="order-panel-title">

                        <div class="order-panel-icon blue">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>

                            <h3>
                                Order Summary
                            </h3>

                            <span>
                                Payment breakdown
                            </span>

                        </div>

                    </div>

                </div>


                <div class="order-summary">

                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            {{ number_format($order->subtotal, 2) }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Shipping
                        </span>

                        <strong>
                            {{ number_format($order->shipping, 2) }}
                        </strong>

                    </div>


                    <div class="summary-row discount">

                        <span>
                            Discount
                        </span>

                        <strong>
                            - {{ number_format($order->discount, 2) }}
                        </strong>

                    </div>


                    <div class="summary-divider"></div>


                    <div class="summary-total">

                        <span>
                            Total
                        </span>

                        <strong>
                            {{ number_format($order->total, 2) }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =============================================
                 UPDATE STATUS
            ============================================== --}}

            <div class="order-panel">

                <div class="order-panel-header">

                    <div class="order-panel-title">

                        <div class="order-panel-icon indigo">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>

                        <div>

                            <h3>
                                Update Status
                            </h3>

                            <span>
                                Change order status
                            </span>

                        </div>

                    </div>

                </div>


                <div class="status-update-body">

                    @if(count($availableStatuses))

                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">

                        @csrf
                        @method('PATCH')

                        <label>
                            New Status
                        </label>

                        <div class="status-select-wrapper">

                            <i class="bi bi-activity"></i>

                            <select name="status" required>

                                @foreach($availableStatuses as $status)

                                <option value="{{ $status->value }}">

                                    {{ $status->label() }}

                                </option>

                                @endforeach

                            </select>

                        </div>


                        <button type="submit" class="update-status-btn">

                            <i class="bi bi-check2-circle"></i>

                            Update Order Status

                        </button>

                    </form>

                    @else

                    <div class="final-status">

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <strong>
                            Order Completed
                        </strong>

                        <span>
                            This order has reached its final status.
                        </span>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
