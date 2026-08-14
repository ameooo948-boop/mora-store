@extends('admin.layouts.app')

@section('title', 'Stock Movements')
@section('page-title', 'Stock Movements')

@section('content')

<div class="stock-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="stock-hero">

        <div class="stock-hero-left">

            <div class="stock-hero-icon">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span class="stock-eyebrow">
                    INVENTORY MANAGEMENT
                </span>

                <h1>
                    Stock Movements
                </h1>

                <p>
                    Track and monitor all inventory movements.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="stock-stats">

        <div class="stock-stat-card">

            <div class="stock-stat-icon blue">
                <i class="bi bi-arrow-left-right"></i>
            </div>

            <div>
                <span>Total Movements</span>
                <strong>{{ $statistics['total'] }}</strong>
            </div>

        </div>


        <div class="stock-stat-card">

            <div class="stock-stat-icon green">
                <i class="bi bi-arrow-up-circle-fill"></i>
            </div>

            <div>
                <span>Increase</span>
                <strong class="text-success">
                    {{ $statistics['increase'] }}
                </strong>
            </div>

        </div>


        <div class="stock-stat-card">

            <div class="stock-stat-icon red">
                <i class="bi bi-arrow-down-circle-fill"></i>
            </div>

            <div>
                <span>Decrease</span>
                <strong class="text-danger">
                    {{ $statistics['decrease'] }}
                </strong>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="stock-filter-card">

        <div class="stock-filter-header">

            <div class="stock-filter-title">

                <div class="stock-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>
                    <strong>Search & Filter</strong>
                    <span>Find specific inventory movements.</span>
                </div>

            </div>

        </div>


        <form method="GET">

            <div class="stock-filter-body">

                <div class="stock-field search-field">

                    <label>
                        Search
                    </label>

                    <div class="stock-input-wrap">

                        <i class="bi bi-search"></i>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product...">

                    </div>

                </div>


                <div class="stock-field">

                    <label>
                        Movement Type
                    </label>

                    <div class="stock-select-wrap">

                        <i class="bi bi-arrow-left-right"></i>

                        <select name="type">

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

                </div>


                <button class="stock-filter-btn">

                    <i class="bi bi-search"></i>

                    Filter

                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         MOVEMENTS TABLE
    ====================================================== --}}

    <div class="stock-table-card">

        <div class="stock-table-header">

            <div>

                <span class="stock-table-eyebrow">
                    INVENTORY LOG
                </span>

                <h2>
                    All Stock Movements
                </h2>

            </div>

            <div class="stock-table-count">

                <i class="bi bi-box-seam"></i>

                {{ $movements->total() }} movements

            </div>

        </div>


        <div class="table-responsive">

            <table class="stock-table">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>PRODUCT</th>
                        <th>TYPE</th>
                        <th>QUANTITY</th>
                        <th>BEFORE</th>
                        <th>AFTER</th>
                        <th>USER</th>
                        <th>REFERENCE</th>
                        <th>DATE</th>
                        <th class="text-center">ACTION</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($movements as $movement)

                    <tr>

                        {{-- ID --}}

                        <td>

                            <span class="stock-id">
                                #{{ $movement->id }}
                            </span>

                        </td>


                        {{-- PRODUCT --}}

                        <td>

                            <div class="stock-product">

                                <div class="stock-product-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <div>

                                    <strong>
                                        {{ $movement->product->name }}
                                    </strong>

                                    <small>
                                        Product inventory
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- TYPE --}}

                        <td>

                            <span class="stock-type {{ strtolower($movement->type->value) }}">

                                <i class="bi {{ $movement->type->icon() }}"></i>

                                {{ $movement->type->label() }}

                            </span>

                        </td>


                        {{-- QUANTITY --}}

                        <td>

                            @if($movement->type === \App\Enums\StockMovementType::Decrease)

                            <span class="stock-quantity decrease">
                                -{{ $movement->quantity }}
                            </span>

                            @else

                            <span class="stock-quantity increase">
                                +{{ $movement->quantity }}
                            </span>

                            @endif

                        </td>


                        {{-- BEFORE --}}

                        <td>

                            <span class="stock-number">
                                {{ $movement->before_quantity }}
                            </span>

                        </td>


                        {{-- AFTER --}}

                        <td>

                            <span class="stock-number after">
                                {{ $movement->after_quantity }}
                            </span>

                        </td>


                        {{-- USER --}}

                        <td>

                            <div class="stock-user">

                                <div class="stock-user-avatar">

                                    {{ strtoupper(substr($movement->user?->name ?? 'S', 0, 1)) }}

                                </div>

                                <span>
                                    {{ $movement->user?->name ?? 'System' }}
                                </span>

                            </div>

                        </td>


                        {{-- REFERENCE --}}

                        <td>

                            @if($movement->reference)

                            @if($movement->reference instanceof \App\Models\Order)

                            <a href="{{ route('admin.orders.show', $movement->reference) }}" class="stock-reference">

                                <i class="bi bi-receipt"></i>

                                Order #{{ $movement->reference->id }}

                            </a>

                            @else

                            <span class="stock-reference-text">

                                {{ class_basename($movement->reference_type) }}

                                #{{ $movement->reference_id }}

                            </span>

                            @endif

                            @else

                            <span class="stock-empty">
                                —
                            </span>

                            @endif

                        </td>


                        {{-- DATE --}}

                        <td>

                            <div class="stock-date">

                                <strong>
                                    {{ $movement->created_at->format('M d, Y') }}
                                </strong>

                                <small>
                                    {{ $movement->created_at->format('h:i A') }}
                                </small>

                            </div>

                        </td>


                        {{-- ACTION --}}

                        <td class="text-center">

                            <a href="{{ route('admin.stock-movements.show', $movement) }}" class="stock-view-btn" title="View Movement">

                                <i class="bi bi-eye"></i>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10">

                            <div class="stock-empty-state">

                                <div class="stock-empty-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <h3>
                                    No Stock Movements Found
                                </h3>

                                <p>
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

        <div class="stock-pagination">

            {{ $movements->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
