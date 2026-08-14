@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="admin-dashboard">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="dashboard-hero">

        <div class="dashboard-hero-content">

            <div class="dashboard-hero-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>

            <div>

                <span class="dashboard-eyebrow">
                    ADMINISTRATION
                </span>

                <h1>
                    Dashboard
                </h1>

                <p>
                    Welcome back 👋
                    Here's what's happening with your store today.
                </p>

            </div>

        </div>


        <div class="dashboard-date">

            <i class="bi bi-calendar3"></i>

            <span>
                {{ now()->format('l, d M Y') }}
            </span>

        </div>

    </section>



    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <section class="dashboard-stats">

        {{-- Revenue --}}

        <div class="dashboard-stat-card revenue">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

                <span class="stat-label">
                    Revenue
                </span>

            </div>

            <div class="stat-value">
                {{ number_format($statistics['revenue'], 2) }}
            </div>

            <div class="stat-footer">

                <span>
                    <i class="bi bi-graph-up-arrow"></i>
                    Total revenue
                </span>

            </div>

        </div>


        {{-- Orders --}}

        <div class="dashboard-stat-card orders">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-bag-check-fill"></i>
                </div>

                <span class="stat-label">
                    Orders
                </span>

            </div>

            <div class="stat-value">
                {{ $statistics['orders'] }}
            </div>

            <div class="stat-footer">

                <span>
                    <i class="bi bi-cart-check"></i>
                    Total orders
                </span>

            </div>

        </div>


        {{-- Customers --}}

        <div class="dashboard-stat-card customers">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <span class="stat-label">
                    Customers
                </span>

            </div>

            <div class="stat-value">
                {{ $statistics['customers'] }}
            </div>

            <div class="stat-footer">

                <span>
                    <i class="bi bi-person-check"></i>
                    Registered customers
                </span>

            </div>

        </div>


        {{-- Products --}}

        <div class="dashboard-stat-card products">

            <div class="stat-card-top">

                <div class="stat-icon">
                    <i class="bi bi-box-seam-fill"></i>
                </div>

                <span class="stat-label">
                    Products
                </span>

            </div>

            <div class="stat-value">
                {{ $statistics['products'] }}
            </div>

            <div class="stat-footer">

                <span>
                    <i class="bi bi-boxes"></i>
                    Products in catalog
                </span>

            </div>

        </div>

    </section>



    {{-- =====================================================
         ANALYTICS
    ====================================================== --}}

    <section class="dashboard-analytics">

        {{-- Revenue Chart --}}

        <div class="dashboard-panel revenue-panel">

            <div class="dashboard-panel-header">

                <div class="panel-title">

                    <div class="panel-icon blue">
                        <i class="bi bi-graph-up"></i>
                    </div>

                    <div>

                        <h3>
                            Revenue Overview
                        </h3>

                        <p>
                            Revenue performance over time
                        </p>

                    </div>

                </div>

            </div>

            <div class="dashboard-chart">

                <div id="revenueChart"></div>

            </div>

        </div>


        {{-- Orders Chart --}}

        <div class="dashboard-panel orders-panel">

            <div class="dashboard-panel-header">

                <div class="panel-title">

                    <div class="panel-icon purple">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Orders Overview
                        </h3>

                        <p>
                            Orders performance
                        </p>

                    </div>

                </div>

            </div>

            <div class="dashboard-chart">

                <div id="ordersChart"></div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         QUICK ACTIONS
    ====================================================== --}}

    <section class="quick-actions">

        <div class="section-heading">

            <div>

                <span>
                    SHORTCUTS
                </span>

                <h2>
                    Quick Actions
                </h2>

            </div>

        </div>


        <div class="quick-actions-grid">

            <a href="{{ route('admin.products.create') }}" class="quick-action primary">

                <span class="quick-action-icon">
                    <i class="bi bi-plus-lg"></i>
                </span>

                <span class="quick-action-content">

                    <strong>
                        Add Product
                    </strong>

                    <small>
                        Create a new product
                    </small>

                </span>

                <i class="bi bi-arrow-up-right quick-action-arrow"></i>

            </a>


            <a href="{{ route('admin.orders.index') }}" class="quick-action">

                <span class="quick-action-icon">
                    <i class="bi bi-bag-check"></i>
                </span>

                <span class="quick-action-content">

                    <strong>
                        Orders
                    </strong>

                    <small>
                        Manage customer orders
                    </small>

                </span>

                <i class="bi bi-arrow-up-right quick-action-arrow"></i>

            </a>


            <a href="{{ route('admin.coupons.index') }}" class="quick-action">

                <span class="quick-action-icon">
                    <i class="bi bi-ticket-perforated"></i>
                </span>

                <span class="quick-action-content">

                    <strong>
                        Coupons
                    </strong>

                    <small>
                        Manage discounts
                    </small>

                </span>

                <i class="bi bi-arrow-up-right quick-action-arrow"></i>

            </a>


            <a href="{{ route('admin.brands.index') }}" class="quick-action">

                <span class="quick-action-icon">
                    <i class="bi bi-tags"></i>
                </span>

                <span class="quick-action-content">

                    <strong>
                        Brands
                    </strong>

                    <small>
                        Manage product brands
                    </small>

                </span>

                <i class="bi bi-arrow-up-right quick-action-arrow"></i>

            </a>

        </div>

    </section>



    {{-- =====================================================
         TOP SELLING + LOW STOCK
    ====================================================== --}}

    <section class="dashboard-grid-two">


        {{-- Top Selling --}}

        <div class="dashboard-panel table-panel">

            <div class="dashboard-panel-header">

                <div class="panel-title">

                    <div class="panel-icon orange">
                        <i class="bi bi-trophy-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Top Selling Products
                        </h3>

                        <p>
                            Best performing products
                        </p>

                    </div>

                </div>

                <span class="panel-badge">
                    TOP SELLERS
                </span>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>
                                Product
                            </th>

                            <th class="text-end">
                                Sold
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($topSellingProducts as $item)

                        <tr>

                            <td>

                                <div class="table-product">

                                    <div class="table-product-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>

                                    <span>
                                        {{ $item->product?->name }}
                                    </span>

                                </div>

                            </td>

                            <td class="text-end">

                                <span class="quantity-badge success">
                                    {{ $item->sold }}
                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="2">

                                <div class="empty-table">
                                    <i class="bi bi-inbox"></i>
                                    <span>No data available</span>
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>



        {{-- Low Stock --}}

        <div class="dashboard-panel table-panel">

            <div class="dashboard-panel-header">

                <div class="panel-title">

                    <div class="panel-icon red">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Low Stock Products
                        </h3>

                        <p>
                            Products that need attention
                        </p>

                    </div>

                </div>

                <span class="panel-badge danger">
                    STOCK ALERT
                </span>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>
                                Product
                            </th>

                            <th class="text-end">
                                Quantity
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($lowStockProducts as $product)

                        <tr>

                            <td>

                                <div class="table-product">

                                    <div class="table-product-icon warning">
                                        <i class="bi bi-box-seam"></i>
                                    </div>

                                    <span>
                                        {{ $product->name }}
                                    </span>

                                </div>

                            </td>

                            <td class="text-end">

                                @if($product->quantity <= 5) <span class="quantity-badge danger">
                                    {{ $product->quantity }}
                                    </span>

                                    @else

                                    <span class="quantity-badge">
                                        {{ $product->quantity }}
                                    </span>

                                    @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="2">

                                <div class="empty-table">
                                    <i class="bi bi-check-circle"></i>
                                    <span>No low stock products</span>
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </section>



    {{-- =====================================================
         ORDERS + PAYMENTS
    ====================================================== --}}

    <section class="dashboard-grid-two">


        {{-- Latest Orders --}}

        <div class="dashboard-panel table-panel">

            <div class="dashboard-panel-header">

                <div class="panel-title">

                    <div class="panel-icon blue">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Latest Orders
                        </h3>

                        <p>
                            Most recent customer orders
                        </p>

                    </div>

                </div>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>
                                Order
                            </th>

                            <th>
                                Customer
                            </th>

                            <th class="text-end">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($latestOrders as $order)

                        <tr>

                            <td>

                                <span class="order-number">
                                    {{ $order->order_number }}
                                </span>

                            </td>

                            <td>

                                <div class="customer-name">

                                    <span class="customer-avatar">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </span>

                                    <span>
                                        {{ $order->user->name }}
                                    </span>

                                </div>

                            </td>

                            <td class="text-end">

                                <strong class="table-amount">
                                    {{ number_format($order->total, 2) }}
                                </strong>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3">

                                <div class="empty-table">
                                    <i class="bi bi-bag-x"></i>
                                    <span>No orders found</span>
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>



        {{-- Latest Payments --}}

        <div class="dashboard-panel table-panel">

            <div class="dashboard-panel-header">

                <div class="panel-title">

                    <div class="panel-icon green">
                        <i class="bi bi-credit-card-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Latest Payments
                        </h3>

                        <p>
                            Recent payment activity
                        </p>

                    </div>

                </div>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>
                                Order
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Amount
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($latestPayments as $payment)

                        <tr>

                            <td>

                                <span class="order-number">
                                    {{ $payment->order->order_number }}
                                </span>

                            </td>

                            <td>

                                <span class="payment-status bg-{{ $payment->status->badge() }}">
                                    {{ $payment->status->label() }}
                                </span>

                            </td>

                            <td class="text-end">

                                <strong class="table-amount">
                                    {{ number_format($payment->amount, 2) }}
                                </strong>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3">

                                <div class="empty-table">
                                    <i class="bi bi-credit-card"></i>
                                    <span>No payments found</span>
                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </section>



    {{-- =====================================================
         RECENT ACTIVITY
    ====================================================== --}}

    <section class="dashboard-panel activity-panel">

        <div class="dashboard-panel-header">

            <div class="panel-title">

                <div class="panel-icon purple">
                    <i class="bi bi-activity"></i>
                </div>

                <div>

                    <h3>
                        Recent Activity
                    </h3>

                    <p>
                        Latest activity across your store
                    </p>

                </div>

            </div>

        </div>


        <div class="activity-grid">


            {{-- Orders --}}

            <div class="activity-column">

                <div class="activity-heading">

                    <div class="activity-heading-icon blue">
                        <i class="bi bi-bag-check"></i>
                    </div>

                    <span>
                        Orders
                    </span>

                </div>


                @forelse($recentActivity['orders'] as $order)

                <div class="activity-item">

                    <div class="activity-dot blue"></div>

                    <div>

                        <strong>
                            {{ $order->order_number }}
                        </strong>

                        <small>
                            {{ $order->created_at?->format('d M Y H:i') }}
                        </small>

                    </div>

                </div>

                @empty

                <div class="activity-empty">
                    No recent orders.
                </div>

                @endforelse

            </div>



            {{-- Payments --}}

            <div class="activity-column">

                <div class="activity-heading">

                    <div class="activity-heading-icon green">
                        <i class="bi bi-credit-card"></i>
                    </div>

                    <span>
                        Payments
                    </span>

                </div>


                @forelse($recentActivity['payments'] as $payment)

                <div class="activity-item">

                    <div class="activity-dot green"></div>

                    <div>

                        <strong>
                            {{ number_format($payment->amount, 2) }}
                        </strong>

                        <small>
                            {{ $payment->created_at?->format('d M Y H:i') }}
                        </small>

                    </div>

                </div>

                @empty

                <div class="activity-empty">
                    No recent payments.
                </div>

                @endforelse

            </div>



            {{-- Reviews --}}

            <div class="activity-column">

                <div class="activity-heading">

                    <div class="activity-heading-icon orange">
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <span>
                        Reviews
                    </span>

                </div>


                @forelse($recentActivity['reviews'] as $review)

                <div class="activity-item">

                    <div class="activity-dot orange"></div>

                    <div>

                        <strong>
                            {{ $review->rating }}/5
                        </strong>

                        <small>
                            {{ $review->created_at?->format('d M Y H:i') }}
                        </small>

                    </div>

                </div>

                @empty

                <div class="activity-empty">
                    No recent reviews.
                </div>

                @endforelse

            </div>



            {{-- Stock --}}

            <div class="activity-column">

                <div class="activity-heading">

                    <div class="activity-heading-icon red">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <span>
                        Stock
                    </span>

                </div>


                @forelse($recentActivity['stock'] as $movement)

                <div class="activity-item">

                    <div class="activity-dot red"></div>

                    <div>

                        <strong>
                            {{ $movement->quantity }}
                        </strong>

                        <small>
                            {{ $movement->created_at?->format('d M Y H:i') }}
                        </small>

                    </div>

                </div>

                @empty

                <div class="activity-empty">
                    No recent stock movements.
                </div>

                @endforelse

            </div>

        </div>

    </section>


</div>

@endsection



@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* =====================================================
           REVENUE CHART
        ====================================================== */

        const revenueElement =
            document.querySelector('#revenueChart');

        if (revenueElement) {

            const revenueOptions = {

                chart: {
                    type: 'area'
                    , height: 330
                    , toolbar: {
                        show: false
                    }
                    , fontFamily: 'Inter, sans-serif'
                },

                series: [{
                    name: 'Revenue'
                    , data: @json(array_values($revenueChart))
                }],

                xaxis: {
                    categories: @json(array_keys($revenueChart))
                    , labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                    , axisBorder: {
                        show: false
                    }
                    , axisTicks: {
                        show: false
                    }
                },

                yaxis: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                        , formatter: function(value) {
                            return value.toFixed(0);
                        }
                    }
                },

                stroke: {
                    curve: 'smooth'
                    , width: 3
                },

                fill: {
                    type: 'gradient'
                    , gradient: {
                        shadeIntensity: 1
                        , opacityFrom: .25
                        , opacityTo: .02
                        , stops: [0, 90, 100]
                    }
                },

                dataLabels: {
                    enabled: false
                },

                grid: {
                    borderColor: '#eef2f7'
                    , strokeDashArray: 4
                    , xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value.toFixed(2);
                        }
                    }
                },

                markers: {
                    size: 0
                    , hover: {
                        size: 5
                    }
                }

            };

            new ApexCharts(
                revenueElement
                , revenueOptions
            ).render();

        }



        /* =====================================================
           ORDERS CHART
        ====================================================== */

        const ordersElement =
            document.querySelector('#ordersChart');

        if (ordersElement) {

            const ordersOptions = {

                chart: {
                    type: 'bar'
                    , height: 330
                    , toolbar: {
                        show: false
                    }
                    , fontFamily: 'Inter, sans-serif'
                },

                series: [{
                    name: 'Orders'
                    , data: @json(array_values($ordersChart))
                }],

                xaxis: {
                    categories: @json(array_keys($ordersChart))
                    , labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                    , axisBorder: {
                        show: false
                    }
                    , axisTicks: {
                        show: false
                    }
                },

                plotOptions: {
                    bar: {
                        borderRadius: 7
                        , columnWidth: '45%'
                    }
                },

                dataLabels: {
                    enabled: false
                },

                grid: {
                    borderColor: '#eef2f7'
                    , strokeDashArray: 4
                    , xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },

                yaxis: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                },

                tooltip: {
                    theme: 'light'
                }

            };

            new ApexCharts(
                ordersElement
                , ordersOptions
            ).render();

        }

    });

</script>

@endpush
