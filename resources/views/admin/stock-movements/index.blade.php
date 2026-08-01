@extends('admin.layouts.app')

@section('title', 'Stock Movements')

@section('page-title', 'Stock Movements')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Stock Movements
            </h3>

            <p class="text-muted mb-0">
                Track all inventory movements
            </p>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Movements
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
                        Increase
                    </small>

                    <h2 class="fw-bold text-success mt-2">
                        {{ $statistics['increase'] }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Decrease
                    </small>

                    <h2 class="fw-bold text-danger mt-2">
                        {{ $statistics['decrease'] }}
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

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by product...">

                    </div>

                    <div class="col-md-3">

                        <select name="type" class="form-select">

                            <option value="">
                                All Types
                            </option>

                            @foreach($types as $type)

                            <option value="{{ $type->value }}" @selected(request('type')==$type->value)
                                >

                                {{ $type->label() }}

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

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                Stock Movements

            </h5>

            <small class="text-muted">

                Showing {{ $movements->total() }} Movements

            </small>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Product</th>

                        <th>Type</th>

                        <th>Quantity</th>

                        <th>Before</th>

                        <th>After</th>

                        <th>User</th>

                        <th>Reference</th>

                        <th>Date</th>

                        <th width="80" class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($movements as $movement)

                    <tr>

                        <td>

                            <span class="badge bg-light text-dark">

                                #{{ $movement->id }}

                            </span>

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $movement->product->name }}

                            </div>

                        </td>

                        <td>

                            <span class="badge bg-{{ $movement->type->badge() }}">

                                <i class="bi {{ $movement->type->icon() }} me-1"></i>

                                {{ $movement->type->label() }}

                            </span>

                        </td>

                        <td>

                            @if($movement->type === \App\Enums\StockMovementType::Decrease)

                            <span class="fw-bold text-danger">

                                -{{ $movement->quantity }}

                            </span>

                            @else

                            <span class="fw-bold text-success">

                                +{{ $movement->quantity }}

                            </span>

                            @endif

                        </td>

                        <td>

                            {{ $movement->before_quantity }}

                        </td>

                        <td>

                            {{ $movement->after_quantity }}

                        </td>

                        <td>

                            {{ $movement->user?->name ?? 'System' }}

                        </td>

                        <td>

                            @if($movement->reference)

                            @if($movement->reference instanceof \App\Models\Order)

                            <a href="{{ route('admin.orders.show', $movement->reference) }}" class="text-decoration-none">

                                Order #{{ $movement->reference->id }}

                            </a>

                            @else

                            {{ class_basename($movement->reference_type) }}

                            #{{ $movement->reference_id }}

                            @endif

                            @else

                            <span class="text-muted">

                                -

                            </span>

                            @endif

                        </td>

                        <td>

                            {{ $movement->created_at->format('M d, Y h:i A') }}

                        </td>

                        <td class="text-center">

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.stock-movements.show', $movement) }}" class="dropdown-item">

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

                        <td colspan="10">

                            <div class="text-center py-5">

                                <i class="bi bi-box-seam display-4 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Stock Movements Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are no stock movements matching your search.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($movements->hasPages())

        <div class="card-footer">

            {{ $movements->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
