@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Dashboard

            </h3>

            <p class="text-muted mb-0">

                Welcome back 👋

            </p>

        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Revenue

                    </small>

                    <h3 class="fw-bold mt-2">

                        {{ number_format($statistics['revenue'],2) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Orders

                    </small>

                    <h3 class="fw-bold mt-2">

                        {{ $statistics['orders'] }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Customers

                    </small>

                    <h3 class="fw-bold mt-2">

                        {{ $statistics['customers'] }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Products

                    </small>

                    <h3 class="fw-bold mt-2">

                        {{ $statistics['products'] }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Revenue

                </div>

                <div class="card-body">

                    <div id="revenueChart"></div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Orders

                </div>

                <div class="card-body">

                    <div id="ordersChart"></div>

                </div>

            </div>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col">

            <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100">

                <i class="bi bi-plus-circle me-2"></i>

                Add Product

            </a>

        </div>

        <div class="col">

            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary w-100">

                Orders

            </a>

        </div>

        <div class="col">

            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-primary w-100">

                Coupons

            </a>

        </div>

        <div class="col">

            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-primary w-100">

                Brands

            </a>

        </div>

    </div>

    <div class="row mt-4">

        {{-- Top Selling Products --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Top Selling Products

                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th class="text-end">

                                    Sold

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($topSellingProducts as $item)

                            <tr>

                                <td>

                                    {{ $item->product?->name }}

                                </td>

                                <td class="text-end fw-bold">

                                    {{ $item->sold }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="2" class="text-center py-4">

                                    No Data

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Low Stock --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Low Stock Products

                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th class="text-end">

                                    Quantity

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($lowStockProducts as $product)

                            <tr>

                                <td>

                                    {{ $product->name }}

                                </td>

                                <td class="text-end">

                                    @if($product->quantity <= 5) <span class="badge bg-danger">

                                        {{ $product->quantity }}

                                        </span>

                                        @else

                                        {{ $product->quantity }}

                                        @endif

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="2" class="text-center py-4">

                                    No Data

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        {{-- Latest Orders --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Latest Orders

                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Order</th>

                                <th>Customer</th>

                                <th>Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($latestOrders as $order)

                            <tr>

                                <td>

                                    {{ $order->order_number }}

                                </td>

                                <td>

                                    {{ $order->user->name }}

                                </td>

                                <td>

                                    {{ number_format($order->total,2) }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center py-4">

                                    No Orders

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Latest Payments --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Latest Payments

                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Order</th>

                                <th>Status</th>

                                <th>Amount</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($latestPayments as $payment)

                            <tr>

                                <td>

                                    {{ $payment->order->order_number }}

                                </td>

                                <td>

                                    <span class="badge bg-{{ $payment->status->badge() }}">

                                        {{ $payment->status->label() }}

                                    </span>

                                </td>

                                <td>

                                    {{ number_format($payment->amount,2) }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center py-4">

                                    No Payments

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const revenueOptions = {

        chart: {

            type: 'line',

            height: 350,

            toolbar: {

                show: false

            }

        },

        stroke: {

            curve: 'smooth',

            width: 3

        },

        dataLabels: {

            enabled: false

        },

        series: [

            {

                name: 'Revenue',

                data: @json(array_values($revenueChart))

            }

        ],

        xaxis: {

            categories: @json(array_keys($revenueChart))

        },

        yaxis: {

            labels: {

                formatter: function(value) {

                    return value.toFixed(2);

                }

            }

        },

        tooltip: {

            y: {

                formatter: function(value) {

                    return value.toFixed(2);

                }

            }

        }

    };

    new ApexCharts(

        document.querySelector('#revenueChart'),

        revenueOptions

    ).render();

    const ordersOptions = {

        chart: {

            type: 'bar',

            height: 350,

            toolbar: {

                show: false

            }

        },

        plotOptions: {

            bar: {

                borderRadius: 6,

                columnWidth: '50%'

            }

        },

        dataLabels: {

            enabled: false

        },

        series: [

            {

                name: 'Orders',

                data: @json(array_values($ordersChart))

            }

        ],

        xaxis: {

            categories: @json(array_keys($ordersChart))

        }

    };

    new ApexCharts(

        document.querySelector('#ordersChart'),

        ordersOptions

    ).render();

</script>

@endpush

@endsection
