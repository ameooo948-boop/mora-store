@extends('admin.layouts.app')

@section('title', 'Stock Movement Details')

@section('page-title', 'Stock Movement Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Stock Movement #{{ $movement->id }}

            </h3>

            <small class="text-muted">

                {{ $movement->created_at->format('M d, Y h:i A') }}

            </small>

        </div>

        <span class="badge bg-{{ $movement->type->badge() }} fs-6">

            <i class="bi {{ $movement->type->icon() }} me-1"></i>

            {{ $movement->type->label() }}

        </span>

    </div>

    <div class="row">

        <div class="col-lg-8">

            {{-- Movement Information --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Movement Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Quantity

                        </span>

                        @if($movement->type === \App\Enums\StockMovementType::Decrease)

                        <strong class="text-danger">

                            -{{ $movement->quantity }}

                        </strong>

                        @else

                        <strong class="text-success">

                            +{{ $movement->quantity }}

                        </strong>

                        @endif

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Before Quantity

                        </span>

                        <strong>

                            {{ $movement->before_quantity }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            After Quantity

                        </span>

                        <strong>

                            {{ $movement->after_quantity }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Type

                        </span>

                        <span class="badge bg-{{ $movement->type->badge() }}">

                            {{ $movement->type->label() }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            {{-- Product --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Product

                </div>

                <div class="card-body">

                    <strong>

                        {{ $movement->product->name }}

                    </strong>

                    @if(!empty($movement->product->sku))

                    <br>

                    <small class="text-muted">

                        SKU: {{ $movement->product->sku }}

                    </small>

                    @endif

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span>

                            Current Stock

                        </span>

                        <strong>

                            {{ $movement->product->quantity }}

                        </strong>

                    </div>

                </div>

            </div>

            {{-- Performed By --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Performed By

                </div>

                <div class="card-body">

                    @if($movement->user)

                    <strong>

                        {{ $movement->user->name }}

                    </strong>

                    <br>

                    {{ $movement->user->email }}

                    @else

                    <span class="text-muted">

                        System

                    </span>

                    @endif

                </div>

            </div>

            {{-- Reference --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Reference

                </div>

                <div class="card-body">

                    @if($movement->reference)

                    @if($movement->reference instanceof \App\Models\Order)

                    <div class="mb-3">

                        <strong>

                            Order

                        </strong>

                        <br>

                        #{{ $movement->reference->order_number }}

                    </div>

                    <a href="{{ route('admin.orders.show', $movement->reference) }}" class="btn btn-primary w-100">

                        <i class="bi bi-box me-2"></i>

                        View Order

                    </a>

                    @else

                    <strong>

                        {{ class_basename($movement->reference_type) }}

                    </strong>

                    <br>

                    #{{ $movement->reference->id }}

                    @endif

                    @else

                    <span class="text-muted">

                        No Reference

                    </span>

                    @endif

                </div>

            </div>

            {{-- Notes --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Notes

                </div>

                <div class="card-body">

                    @if($movement->notes)

                    {{ $movement->notes }}

                    @else

                    <span class="text-muted">

                        No notes available.

                    </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
