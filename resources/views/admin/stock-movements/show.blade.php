@extends('admin.layouts.app')

@section('title', 'Stock Movement Details')
@section('page-title', 'Stock Movement Details')

@section('content')

<div class="stock-details-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="stock-details-header">

        <div class="stock-details-title">

            <div class="stock-details-icon">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span class="stock-details-eyebrow">
                    INVENTORY MOVEMENT
                </span>

                <h1>
                    Movement #{{ $movement->id }}
                </h1>

                <p>
                    {{ $movement->created_at->format('M d, Y') }}
                    <span>•</span>
                    {{ $movement->created_at->format('h:i A') }}
                </p>

            </div>

        </div>


        <div class="stock-details-status
            {{ $movement->type === \App\Enums\StockMovementType::Decrease ? 'decrease' : 'increase' }}">

            <i class="bi {{ $movement->type->icon() }}"></i>

            {{ $movement->type->label() }}

        </div>

    </div>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <div class="stock-details-grid">


        {{-- =================================================
             LEFT
        ================================================== --}}

        <div class="stock-details-main">


            {{-- MOVEMENT INFORMATION --}}

            <div class="stock-details-card">

                <div class="stock-details-card-header">

                    <div class="stock-card-title">

                        <div class="stock-card-icon blue">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>

                        <div>

                            <strong>
                                Movement Information
                            </strong>

                            <span>
                                Inventory quantity changes
                            </span>

                        </div>

                    </div>

                </div>


                <div class="stock-details-card-body">


                    {{-- Quantity --}}

                    <div class="stock-info-row">

                        <div class="stock-info-label">

                            <i class="bi bi-box-arrow-in-right"></i>

                            <span>
                                Quantity
                            </span>

                        </div>

                        @if($movement->type === \App\Enums\StockMovementType::Decrease)

                        <strong class="stock-value decrease">
                            -{{ $movement->quantity }}
                        </strong>

                        @else

                        <strong class="stock-value increase">
                            +{{ $movement->quantity }}
                        </strong>

                        @endif

                    </div>


                    {{-- Before --}}

                    <div class="stock-info-row">

                        <div class="stock-info-label">

                            <i class="bi bi-box"></i>

                            <span>
                                Before Quantity
                            </span>

                        </div>

                        <strong class="stock-value">
                            {{ $movement->before_quantity }}
                        </strong>

                    </div>


                    {{-- After --}}

                    <div class="stock-info-row">

                        <div class="stock-info-label">

                            <i class="bi bi-box-seam"></i>

                            <span>
                                After Quantity
                            </span>

                        </div>

                        <strong class="stock-value after">
                            {{ $movement->after_quantity }}
                        </strong>

                    </div>


                    {{-- Type --}}

                    <div class="stock-info-row">

                        <div class="stock-info-label">

                            <i class="bi {{ $movement->type->icon() }}"></i>

                            <span>
                                Movement Type
                            </span>

                        </div>

                        <span class="stock-mini-badge
                            {{ $movement->type === \App\Enums\StockMovementType::Decrease ? 'decrease' : 'increase' }}">

                            <i class="bi {{ $movement->type->icon() }}"></i>

                            {{ $movement->type->label() }}

                        </span>

                    </div>


                </div>

            </div>


            {{-- QUANTITY FLOW --}}

            <div class="stock-details-card">

                <div class="stock-details-card-header">

                    <div class="stock-card-title">

                        <div class="stock-card-icon purple">
                            <i class="bi bi-bar-chart-steps"></i>
                        </div>

                        <div>

                            <strong>
                                Stock Flow
                            </strong>

                            <span>
                                Quantity before and after movement
                            </span>

                        </div>

                    </div>

                </div>


                <div class="stock-flow">

                    <div class="stock-flow-item">

                        <span>
                            BEFORE
                        </span>

                        <strong>
                            {{ $movement->before_quantity }}
                        </strong>

                    </div>


                    <div class="stock-flow-arrow
                        {{ $movement->type === \App\Enums\StockMovementType::Decrease ? 'decrease' : 'increase' }}">

                        <i class="bi bi-arrow-right"></i>

                    </div>


                    <div class="stock-flow-item">

                        <span>
                            AFTER
                        </span>

                        <strong>
                            {{ $movement->after_quantity }}
                        </strong>

                    </div>

                </div>

            </div>


        </div>


        {{-- =================================================
             RIGHT SIDEBAR
        ================================================== --}}

        <div class="stock-details-sidebar">


            {{-- PRODUCT --}}

            <div class="stock-details-card">

                <div class="stock-details-card-header">

                    <div class="stock-card-title">

                        <div class="stock-card-icon blue">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div>

                            <strong>
                                Product
                            </strong>

                            <span>
                                Related product
                            </span>

                        </div>

                    </div>

                </div>


                <div class="stock-sidebar-body">

                    <div class="stock-product-large">

                        <div class="stock-product-large-icon">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                        <div>

                            <strong>
                                {{ $movement->product->name }}
                            </strong>

                            @if(!empty($movement->product->sku))

                            <span>
                                SKU: {{ $movement->product->sku }}
                            </span>

                            @endif

                        </div>

                    </div>


                    <div class="stock-current-stock">

                        <span>
                            Current Stock
                        </span>

                        <strong>
                            {{ $movement->product->quantity }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- PERFORMED BY --}}

            <div class="stock-details-card">

                <div class="stock-details-card-header">

                    <div class="stock-card-title">

                        <div class="stock-card-icon purple">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>

                            <strong>
                                Performed By
                            </strong>

                            <span>
                                Movement creator
                            </span>

                        </div>

                    </div>

                </div>


                <div class="stock-sidebar-body">

                    @if($movement->user)

                    <div class="stock-user-large">

                        <div class="stock-user-large-avatar">

                            {{ strtoupper(substr($movement->user->name, 0, 1)) }}

                        </div>

                        <div>

                            <strong>
                                {{ $movement->user->name }}
                            </strong>

                            <span>
                                {{ $movement->user->email }}
                            </span>

                        </div>

                    </div>

                    @else

                    <div class="stock-system-user">

                        <div>
                            <i class="bi bi-cpu"></i>
                        </div>

                        <span>
                            System
                        </span>

                    </div>

                    @endif

                </div>

            </div>


            {{-- REFERENCE --}}

            <div class="stock-details-card">

                <div class="stock-details-card-header">

                    <div class="stock-card-title">

                        <div class="stock-card-icon green">
                            <i class="bi bi-link-45deg"></i>
                        </div>

                        <div>

                            <strong>
                                Reference
                            </strong>

                            <span>
                                Related transaction
                            </span>

                        </div>

                    </div>

                </div>


                <div class="stock-sidebar-body">

                    @if($movement->reference)

                    @if($movement->reference instanceof \App\Models\Order)

                    <div class="stock-reference-box">

                        <div class="stock-reference-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>

                            <span>
                                ORDER
                            </span>

                            <strong>
                                #{{ $movement->reference->order_number }}
                            </strong>

                        </div>

                    </div>


                    <a href="{{ route('admin.orders.show', $movement->reference) }}" class="stock-reference-btn">

                        <i class="bi bi-eye"></i>

                        View Order

                    </a>

                    @else

                    <div class="stock-reference-box">

                        <div class="stock-reference-icon">
                            <i class="bi bi-link"></i>
                        </div>

                        <div>

                            <span>
                                {{ class_basename($movement->reference_type) }}
                            </span>

                            <strong>
                                #{{ $movement->reference->id }}
                            </strong>

                        </div>

                    </div>

                    @endif

                    @else

                    <div class="stock-no-reference">

                        <i class="bi bi-dash-circle"></i>

                        <span>
                            No Reference
                        </span>

                    </div>

                    @endif

                </div>

            </div>


            {{-- NOTES --}}

            <div class="stock-details-card">

                <div class="stock-details-card-header">

                    <div class="stock-card-title">

                        <div class="stock-card-icon orange">
                            <i class="bi bi-sticky"></i>
                        </div>

                        <div>

                            <strong>
                                Notes
                            </strong>

                            <span>
                                Additional information
                            </span>

                        </div>

                    </div>

                </div>


                <div class="stock-sidebar-body">

                    @if($movement->notes)

                    <div class="stock-notes">
                        {{ $movement->notes }}
                    </div>

                    @else

                    <div class="stock-no-reference">

                        <i class="bi bi-chat-square-text"></i>

                        <span>
                            No notes available.
                        </span>

                    </div>

                    @endif

                </div>

            </div>


        </div>

    </div>

</div>

@endsection
