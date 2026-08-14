@extends('admin.layouts.app')

@section('title', 'Coupon Details')
@section('page-title', 'Coupon Details')

@section('content')

<div class="coupon-details-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="coupon-details-header">

        <div class="coupon-details-heading">

            <div class="coupon-details-icon">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>

            <div>

                <span>
                    COUPON MANAGEMENT
                </span>

                <h1>
                    Coupon Details
                </h1>

            </div>

        </div>


        <div class="coupon-details-actions">

            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="coupon-details-btn edit">
                <i class="bi bi-pencil-square"></i>
                Edit Coupon
            </a>

            <a href="{{ route('admin.coupons.index') }}" class="coupon-details-btn back">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>


    <div class="row g-3">


        {{-- =================================================
             MAIN INFORMATION
        ================================================== --}}

        <div class="col-xl-8">

            <div class="coupon-info-card">

                <div class="coupon-card-header">

                    <div>

                        <h3>
                            Coupon Information
                        </h3>

                        <span>
                            Complete information about this coupon
                        </span>

                    </div>


                    <div class="coupon-code-badge">

                        <i class="bi bi-ticket-perforated-fill"></i>

                        {{ $coupon->code }}

                    </div>

                </div>


                <div class="coupon-info-body">

                    <div class="row g-3">


                        {{-- ID --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon neutral">
                                    <i class="bi bi-hash"></i>
                                </div>

                                <div>

                                    <small>
                                        Coupon ID
                                    </small>

                                    <strong>
                                        #{{ $coupon->id }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Code --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon blue">
                                    <i class="bi bi-upc-scan"></i>
                                </div>

                                <div>

                                    <small>
                                        Coupon Code
                                    </small>

                                    <strong class="code-value">
                                        {{ $coupon->code }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Type --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon purple">
                                    <i class="bi bi-percent"></i>
                                </div>

                                <div>

                                    <small>
                                        Discount Type
                                    </small>

                                    <strong>
                                        {{ ucfirst($coupon->type->value) }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Value --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon green">
                                    <i class="bi bi-tag-fill"></i>
                                </div>

                                <div>

                                    <small>
                                        Discount Value
                                    </small>

                                    <strong class="discount-value">

                                        @if($coupon->type->value === 'percent')

                                        {{ $coupon->value }}%

                                        @else

                                        ${{ number_format($coupon->value, 2) }}

                                        @endif

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Minimum --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon orange">
                                    <i class="bi bi-cart-check"></i>
                                </div>

                                <div>

                                    <small>
                                        Minimum Order
                                    </small>

                                    <strong>
                                        ${{ number_format($coupon->minimum_amount ?? 0, 2) }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Maximum --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon yellow">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div>

                                    <small>
                                        Maximum Discount
                                    </small>

                                    <strong>

                                        @if($coupon->maximum_discount)

                                        ${{ number_format($coupon->maximum_discount, 2) }}

                                        @else

                                        Unlimited

                                        @endif

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Usage Limit --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon cyan">
                                    <i class="bi bi-bar-chart"></i>
                                </div>

                                <div>

                                    <small>
                                        Usage Limit
                                    </small>

                                    <strong>

                                        {{ $coupon->usage_limit ?? 'Unlimited' }}

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Used Count --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon red">
                                    <i class="bi bi-activity"></i>
                                </div>

                                <div>

                                    <small>
                                        Times Used
                                    </small>

                                    <strong>
                                        {{ $coupon->used_count }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Starts --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon teal">
                                    <i class="bi bi-calendar-event"></i>
                                </div>

                                <div>

                                    <small>
                                        Starts At
                                    </small>

                                    <strong>

                                        {{ $coupon->starts_at?->format('d M Y, h:i A') ?? 'No Start Date' }}

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Expires --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon pink">
                                    <i class="bi bi-calendar-x"></i>
                                </div>

                                <div>

                                    <small>
                                        Expires At
                                    </small>

                                    <strong>

                                        {{ $coupon->expires_at?->format('d M Y, h:i A') ?? 'No Expiry' }}

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Status --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon
                                    {{ $coupon->is_active ? 'green' : 'red' }}">

                                    <i class="bi
                                        {{ $coupon->is_active
                                            ? 'bi-check-circle-fill'
                                            : 'bi-x-circle-fill'
                                        }}"></i>

                                </div>

                                <div>

                                    <small>
                                        Current Status
                                    </small>

                                    @if($coupon->is_active)

                                    <span class="coupon-detail-status active">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Active
                                    </span>

                                    @else

                                    <span class="coupon-detail-status inactive">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Inactive
                                    </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Created --}}

                        <div class="col-md-6">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon neutral">
                                    <i class="bi bi-clock-history"></i>
                                </div>

                                <div>

                                    <small>
                                        Created At
                                    </small>

                                    <strong>
                                        {{ $coupon->created_at->format('d M Y, h:i A') }}
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- Updated --}}

                        <div class="col-12">

                            <div class="coupon-info-item">

                                <div class="coupon-info-item-icon neutral">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>

                                <div>

                                    <small>
                                        Last Updated
                                    </small>

                                    <strong>
                                        {{ $coupon->updated_at->format('d M Y, h:i A') }}
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             STATISTICS
        ================================================== --}}

        <div class="col-xl-4">

            <div class="coupon-statistics-card">

                <div class="coupon-card-header">

                    <div>

                        <h3>
                            Usage Statistics
                        </h3>

                        <span>
                            Track coupon performance
                        </span>

                    </div>

                    <div class="statistics-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                </div>


                <div class="coupon-statistics-body">

                    @php

                    $percent = $coupon->usage_limit
                    ? min(
                    100,
                    ($coupon->used_count / $coupon->usage_limit) * 100
                    )
                    : 0;

                    @endphp


                    <div class="usage-circle-wrapper">

                        <div class="usage-circle" style="--usage: {{ $percent }}%;">

                            <div class="usage-circle-inner">

                                <strong>
                                    {{ round($percent) }}%
                                </strong>

                                <span>
                                    Used
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="statistics-grid">


                        <div class="statistics-box">

                            <span>
                                Used
                            </span>

                            <strong>
                                {{ $coupon->used_count }}
                            </strong>

                        </div>


                        <div class="statistics-box">

                            <span>
                                Limit
                            </span>

                            <strong>
                                {{ $coupon->usage_limit ?? '∞' }}
                            </strong>

                        </div>


                        <div class="statistics-box">

                            <span>
                                Remaining
                            </span>

                            <strong>

                                {{ $coupon->usage_limit
                                    ? max(
                                        0,
                                        $coupon->usage_limit - $coupon->used_count
                                    )
                                    : '∞'
                                }}

                            </strong>

                        </div>


                        <div class="statistics-box">

                            <span>
                                Status
                            </span>

                            <strong class="{{ $coupon->is_active
                                    ? 'text-success'
                                    : 'text-danger'
                                }}">

                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}

                            </strong>

                        </div>

                    </div>


                    <div class="coupon-statistics-divider"></div>


                    <div class="coupon-statistics-actions">

                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="statistics-edit-btn">

                            <i class="bi bi-pencil-square"></i>

                            Edit Coupon

                        </a>

                        <a href="{{ route('admin.coupons.index') }}" class="statistics-back-btn">

                            <i class="bi bi-arrow-left"></i>

                            Back to Coupons

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
