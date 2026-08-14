@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')

<div class="orders-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="orders-hero">

        <div class="orders-hero-content">

            <div class="orders-hero-icon">
                <i class="bi bi-bag-check-fill"></i>
            </div>

            <div>

                <span class="orders-eyebrow">
                    ORDER MANAGEMENT
                </span>

                <h1>
                    Orders
                </h1>

                <p>
                    Manage, monitor and track all customer orders.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="orders-statistics">

        <div class="order-stat-card total">

            <div class="order-stat-icon">
                <i class="bi bi-bag-check-fill"></i>
            </div>

            <div class="order-stat-content">

                <span>
                    Total Orders
                </span>

                <strong>
                    {{ $statistics['total'] }}
                </strong>

            </div>

        </div>


        <div class="order-stat-card pending">

            <div class="order-stat-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>

            <div class="order-stat-content">

                <span>
                    Pending
                </span>

                <strong>
                    {{ $statistics['pending'] }}
                </strong>

            </div>

        </div>


        <div class="order-stat-card shipped">

            <div class="order-stat-icon">
                <i class="bi bi-truck"></i>
            </div>

            <div class="order-stat-content">

                <span>
                    Shipped
                </span>

                <strong>
                    {{ $statistics['shipped'] }}
                </strong>

            </div>

        </div>


        <div class="order-stat-card delivered">

            <div class="order-stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="order-stat-content">

                <span>
                    Delivered
                </span>

                <strong>
                    {{ $statistics['delivered'] }}
                </strong>

            </div>

        </div>


        <div class="order-stat-card cancelled">

            <div class="order-stat-icon">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div class="order-stat-content">

                <span>
                    Cancelled
                </span>

                <strong>
                    {{ $statistics['cancelled'] }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="orders-filter-card">

        <div class="orders-filter-header">

            <div class="orders-filter-title">

                <div class="orders-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>

                    <h3>
                        Filter Orders
                    </h3>

                    <span>
                        Search orders by customer, number or status
                    </span>

                </div>

            </div>


            @if(request()->hasAny(['search', 'status']))

            <a href="{{ route('admin.orders.index') }}" class="orders-reset">
                <i class="bi bi-arrow-counterclockwise"></i>
                Reset
            </a>

            @endif

        </div>


        <form method="GET" action="{{ route('admin.orders.index') }}" class="orders-filter-form">

            <div class="orders-search-field">

                <label>
                    Search
                </label>

                <div class="orders-input-wrapper">

                    <i class="bi bi-search"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Order number or customer name...">

                </div>

            </div>


            <div class="orders-status-field">

                <label>
                    Status
                </label>

                <div class="orders-input-wrapper">

                    <i class="bi bi-activity"></i>

                    <select name="status">

                        <option value="">
                            All Status
                        </option>

                        @foreach($statuses as $status)

                        <option value="{{ $status->value }}" @selected(request('status')==$status->value)
                            >
                            {{ ucfirst($status->value) }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <button type="submit" class="orders-filter-btn">

                <i class="bi bi-search"></i>

                Apply Filter

            </button>

        </form>

    </div>


    {{-- =====================================================
         ORDERS TABLE
    ====================================================== --}}

    <div class="orders-table-card">

        <div class="orders-table-header">

            <div>

                <h3>
                    All Orders
                </h3>

                <span>
                    Customer orders and fulfillment status
                </span>

            </div>


            <div class="orders-count">

                <i class="bi bi-receipt"></i>

                {{ $orders->total() }}

                {{ Str::plural('Order', $orders->total()) }}

            </div>

        </div>


        <div class="table-responsive">

            <table class="orders-table">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
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

                        <th class="orders-actions-column">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orders as $order)

                    <tr>

                        {{-- ID --}}

                        <td>

                            <span class="order-id">
                                #{{ $order->id }}
                            </span>

                        </td>


                        {{-- Order Number --}}

                        <td>

                            <div class="order-number-wrapper">

                                <div class="order-number-icon">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>

                                <div>

                                    <strong>
                                        {{ $order->order_number }}
                                    </strong>

                                    <small>
                                        Order Number
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- Customer --}}

                        <td>

                            <div class="order-customer">

                                <div class="order-avatar">

                                    {{ strtoupper(
                                            substr($order->user->name, 0, 1)
                                        ) }}

                                </div>

                                <div>

                                    <strong>
                                        {{ $order->user->name }}
                                    </strong>

                                    <small>
                                        {{ $order->user->email }}
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- Items --}}

                        <td>

                            <span class="order-items">

                                <i class="bi bi-box-seam"></i>

                                {{ $order->items_count }}

                            </span>

                        </td>


                        {{-- Total --}}

                        <td>

                            <strong class="order-total">

                                ${{ number_format($order->total, 2) }}

                            </strong>

                        </td>


                        {{-- Status --}}

                        <td>

                            <span class="order-status {{ $order->status_badge }}">

                                <i class="bi {{ $order->status_icon ?? 'bi-circle-fill' }}"></i>

                                {{ $order->status_label }}

                            </span>

                        </td>


                        {{-- Date --}}

                        <td>

                            <div class="order-date">

                                <span>
                                    {{ $order->created_at->format('d M Y') }}
                                </span>

                                <small>
                                    {{ $order->created_at->format('h:i A') }}
                                </small>

                            </div>

                        </td>


                        {{-- Actions --}}

                        <td>

                            <div class="order-actions">

                                <a href="{{ route('admin.orders.show', $order) }}" class="order-action view" title="View Order">

                                    <i class="bi bi-eye"></i>

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8">

                            <div class="orders-empty">

                                <div class="orders-empty-icon">
                                    <i class="bi bi-receipt"></i>
                                </div>

                                <h3>
                                    No Orders Found
                                </h3>

                                <p>
                                    There are no orders matching your current filters.
                                </p>

                                @if(request()->hasAny(['search', 'status']))

                                <a href="{{ route('admin.orders.index') }}" class="orders-empty-btn">

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                    Clear Filters

                                </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($orders->hasPages())

        <div class="orders-pagination">

            {{ $orders->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
