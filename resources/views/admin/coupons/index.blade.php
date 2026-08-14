@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page-title', 'Coupons')

@section('content')

<div class="coupons-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="coupons-hero">

        <div class="coupons-hero-content">

            <div class="coupons-hero-icon">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>

            <div>

                <span class="coupons-eyebrow">
                    PROMOTIONS & DISCOUNTS
                </span>

                <h1>
                    Coupons
                </h1>

                <p>
                    Create, manage and monitor your store discount coupons.
                </p>

            </div>

        </div>


        <a href="{{ route('admin.coupons.create') }}" class="coupons-add-btn">

            <i class="bi bi-plus-lg"></i>

            Add Coupon

        </a>

    </div>



    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="coupons-filter-card">

        <div class="coupons-filter-header">

            <div class="coupons-filter-title">

                <div class="coupons-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>

                    <h3>
                        Filter Coupons
                    </h3>

                    <span>
                        Search and sort your coupon collection
                    </span>

                </div>

            </div>


            @if(request()->hasAny([
            'search',
            'type',
            'status',
            'sort_by',
            'sort_direction'
            ]))

            <a href="{{ route('admin.coupons.index') }}" class="coupons-reset-btn">
                <i class="bi bi-arrow-counterclockwise"></i>
                Reset
            </a>

            @endif

        </div>


        <form action="{{ route('admin.coupons.index') }}" method="GET" class="coupons-filter-form">

            {{-- Search --}}

            <div class="coupon-filter-field search-field">

                <label>
                    Search
                </label>

                <div class="coupon-filter-input">

                    <i class="bi bi-search"></i>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by coupon code...">

                </div>

            </div>


            {{-- Type --}}

            <div class="coupon-filter-field">

                <label>
                    Type
                </label>

                <div class="coupon-filter-input">

                    <i class="bi bi-percent"></i>

                    <select name="type">

                        <option value="">
                            All Types
                        </option>

                        @foreach(\App\Enums\CouponType::cases() as $type)

                        <option value="{{ $type->value }}" @selected(request('type')==$type->value)
                            >
                            {{ ucfirst($type->value) }}
                        </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- Status --}}

            <div class="coupon-filter-field">

                <label>
                    Status
                </label>

                <div class="coupon-filter-input">

                    <i class="bi bi-activity"></i>

                    <select name="status">

                        <option value="">
                            All Status
                        </option>

                        <option value="1" @selected(request('status')==='1' )>
                            Active
                        </option>

                        <option value="0" @selected(request('status')==='0' )>
                            Inactive
                        </option>

                    </select>

                </div>

            </div>


            {{-- Sort By --}}

            <div class="coupon-filter-field">

                <label>
                    Sort By
                </label>

                <div class="coupon-filter-input">

                    <i class="bi bi-sort-down"></i>

                    <select name="sort_by">

                        <option value="created_at" @selected(request('sort_by')=='created_at' )>
                            Created Date
                        </option>

                        <option value="expires_at" @selected(request('sort_by')=='expires_at' )>
                            Expiry Date
                        </option>

                        <option value="code" @selected(request('sort_by')=='code' )>
                            Code
                        </option>

                        <option value="used_count" @selected(request('sort_by')=='used_count' )>
                            Usage
                        </option>

                        <option value="value" @selected(request('sort_by')=='value' )>
                            Discount
                        </option>

                    </select>

                </div>

            </div>


            {{-- Direction --}}

            <div class="coupon-filter-field">

                <label>
                    Direction
                </label>

                <div class="coupon-filter-input">

                    <i class="bi bi-arrow-down-up"></i>

                    <select name="sort_direction">

                        <option value="asc" @selected(request('sort_direction')=='asc' )>
                            Ascending
                        </option>

                        <option value="desc" @selected(request('sort_direction', 'desc' )=='desc' )>
                            Descending
                        </option>

                    </select>

                </div>

            </div>


            {{-- Apply --}}

            <button type="submit" class="coupons-filter-submit">

                <i class="bi bi-search"></i>

                Apply Filters

            </button>

        </form>

    </div>



    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="coupons-table-card">


        <div class="coupons-table-header">

            <div>

                <h3>
                    All Coupons
                </h3>

                <span>
                    Manage your discount codes and usage
                </span>

            </div>


            <div class="coupons-count">

                <i class="bi bi-ticket-perforated"></i>

                {{ $coupons->total() }}

                {{ Str::plural('Coupon', $coupons->total()) }}

            </div>

        </div>


        <div class="table-responsive">

            <table class="coupons-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Coupon
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Discount
                        </th>

                        <th>
                            Minimum
                        </th>

                        <th>
                            Max Discount
                        </th>

                        <th>
                            Usage
                        </th>

                        <th>
                            Expires
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="actions-column">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($coupons as $coupon)

                    <tr>

                        {{-- ID --}}

                        <td>

                            <span class="coupon-id">
                                #{{ $coupon->id }}
                            </span>

                        </td>


                        {{-- Code --}}

                        <td>

                            <div class="coupon-code-wrapper">

                                <div class="coupon-code-icon">
                                    <i class="bi bi-ticket-perforated-fill"></i>
                                </div>

                                <div>

                                    <strong>
                                        {{ $coupon->code }}
                                    </strong>

                                    <small>
                                        Coupon Code
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- Type --}}

                        <td>

                            @if($coupon->type->value === 'percent')

                            <span class="coupon-type percent">
                                <i class="bi bi-percent"></i>
                                Percentage
                            </span>

                            @else

                            <span class="coupon-type fixed">
                                <i class="bi bi-cash"></i>
                                Fixed
                            </span>

                            @endif

                        </td>


                        {{-- Value --}}

                        <td>

                            <strong class="coupon-discount">

                                @if($coupon->type->value === 'percent')

                                {{ $coupon->value }}%

                                @else

                                ${{ number_format($coupon->value, 2) }}

                                @endif

                            </strong>

                        </td>


                        {{-- Minimum --}}

                        <td>

                            <span class="coupon-money">

                                ${{ number_format(
                                        $coupon->minimum_amount ?? 0,
                                        2
                                    ) }}

                            </span>

                        </td>


                        {{-- Maximum --}}

                        <td>

                            @if($coupon->maximum_discount)

                            <span class="coupon-money">

                                ${{ number_format(
                                            $coupon->maximum_discount,
                                            2
                                        ) }}

                            </span>

                            @else

                            <span class="coupon-unlimited">
                                No Limit
                            </span>

                            @endif

                        </td>


                        {{-- Usage --}}

                        <td>

                            @if($coupon->usage_limit)

                            @php
                            $usagePercentage = min(
                            100,
                            ($coupon->used_count / $coupon->usage_limit) * 100
                            );
                            @endphp

                            <div class="coupon-usage">

                                <div class="coupon-usage-top">

                                    <strong>
                                        {{ $coupon->used_count }}
                                    </strong>

                                    <span>
                                        / {{ $coupon->usage_limit }}
                                    </span>

                                </div>

                                <div class="coupon-progress">

                                    <div class="coupon-progress-bar
                                                {{ $usagePercentage >= 90
                                                    ? 'danger'
                                                    : ($usagePercentage >= 60
                                                        ? 'warning'
                                                        : 'success') }}" style="width: {{ $usagePercentage }}%"></div>

                                </div>

                            </div>

                            @else

                            <span class="coupon-unlimited">

                                <i class="bi bi-infinity"></i>
                                Unlimited

                            </span>

                            @endif

                        </td>


                        {{-- Expiry --}}

                        <td>

                            @if($coupon->expires_at)

                            @if($coupon->expires_at->isPast())

                            <span class="coupon-expired">

                                <i class="bi bi-clock-history"></i>

                                Expired

                            </span>

                            <small class="coupon-date expired">
                                {{ $coupon->expires_at->format('d M Y') }}
                            </small>

                            @else

                            <span class="coupon-date">

                                <i class="bi bi-calendar-event"></i>

                                {{ $coupon->expires_at->format('d M Y') }}

                            </span>

                            <small class="coupon-time">
                                {{ $coupon->expires_at->format('h:i A') }}
                            </small>

                            @endif

                            @else

                            <span class="coupon-unlimited">
                                No Expiry
                            </span>

                            @endif

                        </td>


                        {{-- Status --}}

                        <td>

                            @if($coupon->status)

                            <span class="coupon-status active">

                                <i class="bi bi-check-circle-fill"></i>

                                Active

                            </span>

                            @else

                            <span class="coupon-status inactive">

                                <i class="bi bi-x-circle-fill"></i>

                                Inactive

                            </span>

                            @endif

                        </td>


                        {{-- Actions --}}

                        <td>

                            <div class="coupon-actions">


                                <a href="{{ route('admin.coupons.show', $coupon) }}" class="coupon-action view" title="View Coupon">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="coupon-action edit" title="Edit Coupon">

                                    <i class="bi bi-pencil-square"></i>

                                </a>


                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="m-0">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="coupon-action delete" title="Delete Coupon" onclick="return confirm('Delete this coupon?')">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10">

                            <div class="coupons-empty">

                                <div class="coupons-empty-icon">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>

                                <h3>
                                    No Coupons Found
                                </h3>

                                <p>
                                    There are no coupons matching your current filters.
                                </p>

                                <a href="{{ route('admin.coupons.create') }}" class="coupons-empty-btn">

                                    <i class="bi bi-plus-lg"></i>

                                    Create Coupon

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($coupons->hasPages())

        <div class="coupons-pagination">

            {{ $coupons->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
