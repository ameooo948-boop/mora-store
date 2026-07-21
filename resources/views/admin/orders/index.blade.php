@extends('admin.layouts.app')

@section('title', 'Orders')

@section('page-title', 'Orders')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Orders

            </h3>

            <p class="text-muted mb-0">

                Manage all orders

            </p>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col">

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

        <div class="col">

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

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Shipped

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['shipped'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

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

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Cancelled

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['cancelled'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-6">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by order number or customer...">

                    </div>

                    <div class="col-md-3">

                        <select name="status" class="form-select">

                            <option value="">

                                All Status

                            </option>

                            @foreach($statuses as $status)

                            <option value="{{ $status->value }}" @selected(request('status')==$status->value)>

                                {{ ucfirst($status->value) }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    Orders

                </h5>

                <small class="text-muted">

                    Showing {{ $orders->total() }} Orders

                </small>

            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center" width="80">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($orders as $order)

                        <tr>

                            <td>

                                <span class="badge bg-light text-dark">

                                    #{{ $order->id }}

                                </span>

                            </td>

                            <td>

                                <div class="fw-semibold">

                                    {{ $order->order_number }}

                                </div>

                            </td>

                            <td>

                                <div class="fw-semibold">

                                    {{ $order->user->name }}

                                </div>

                                <small class="text-muted">

                                    {{ $order->user->email }}

                                </small>

                            </td>

                            <td>

                                <span class="badge bg-primary">

                                    {{ $order->items_count }}

                                </span>

                            </td>

                            <td>

                                <span class="fw-bold">

                                    ${{ number_format($order->total,2) }}

                                </span>

                            </td>

                            <td>

                                <span class="badge {{ $order->status_badge }}">

                                    {{ $order->status_label }}

                                </span>

                            </td>

                            <td>

                                {{ $order->formatted_date }}

                            </td>


                            <td class="text-center">

                                <div class="dropdown">

                                    <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                        <i class="bi bi-three-dots-vertical"></i>

                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">

                                        <li>

                                            <a href="{{ route('admin.orders.show',$order) }}" class="dropdown-item">

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

                            <td colspan="8">

                                <div class="text-center py-5">

                                    <i class="bi bi-receipt display-4 text-secondary"></i>

                                    <h5 class="mt-3">

                                        No Orders Found

                                    </h5>

                                    <p class="text-muted mb-0">

                                        There are no orders matching your search.

                                    </p>

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

</div>

@endsection
