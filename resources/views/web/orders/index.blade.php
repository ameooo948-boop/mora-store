@extends('admin.layouts.app')

@section('title', 'My Orders')

@section('page-title', 'My Orders')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                My Orders
            </h3>

            <p class="text-muted mb-0">
                View and track your orders
            </p>

        </div>

        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">

            <i class="bi bi-shop me-2"></i>

            Continue Shopping

        </a>

    </div>

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Orders
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $statistics['total'] }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Pending
                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $statistics['pending'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Delivered
                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['delivered'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- Orders Table --}}
    <div class="card">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Order Number</th>

                        <th>Items</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th width="80"></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($orders as $order)

                    <tr>

                        <td>{{ $order->id }}</td>

                        <td>

                            <span class="badge bg-secondary">

                                {{ $order->order_number }}

                            </span>

                        </td>

                        <td>

                            {{ $order->items->count() }}

                        </td>

                        <td>

                            <strong>

                                ${{ number_format($order->total,2) }}

                            </strong>

                        </td>

                        <td>

                            <span class="badge {{ $order->status_badge }}">
                                <i class="bi {{ $order->status_icon }} me-1"></i>
                                {{ $order->status_label }}
                            </span>

                        </td>

                        <td>

                            {{ $order->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('orders.show',$order) }}" class="dropdown-item">

                                            <i class="bi bi-eye me-2"></i>

                                            View

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7">

                            <div class="text-center py-5">

                                <i class="bi bi-bag-x display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Orders Found

                                </h5>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($orders->hasPages())

        <div class="card-footer">

            {{ $orders->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
