@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title">
                Coupons
            </h3>

            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">

                <i class="fas fa-plus"></i>
                Add Coupon

            </a>

        </div>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.coupons.index') }}" method="GET" class="row g-3 mb-4">

            <div class="col-md-4">

                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by code">

            </div>

            <div class="col-md-3">

                <select name="type" class="form-select">

                    <option value="">
                        All Types
                    </option>

                    @foreach(\App\Enums\CouponType::cases() as $type)

                    <option value="{{ $type->value }}" @selected(request('type')==$type->value)>

                        {{ ucfirst($type->value) }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <select name="status" class="form-select">

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

            <div class="col-md-2">

                <select name="sort_by" class="form-select">

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

            <div class="col-md-2">

                <select name="sort_direction" class="form-select">

                    <option value="asc" @selected(request('sort_direction')=='asc' )>

                        Ascending

                    </option>

                    <option value="desc" @selected(request('sort_direction','desc')=='desc' )>

                        Descending

                    </option>

                </select>

            </div>

            <div class="col-md-2 d-grid">

                <button class="btn btn-secondary">

                    Search

                </button>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Code</th>

                        <th>Type</th>

                        <th>Value</th>

                        <th>Minimum</th>

                        <th>Max Discount</th>

                        <th>Usage</th>

                        <th>Expires</th>

                        <th>Status</th>

                        <th width="180">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($coupons as $coupon)

                    <tr>

                        <td>
                            {{ $coupon->id }}
                        </td>

                        <td>

                            <strong>
                                {{ $coupon->code }}
                            </strong>

                        </td>

                        <td>

                            <span class="badge bg-info">

                                {{ ucfirst($coupon->type->value) }}

                            </span>

                        </td>

                        <td>

                            @if($coupon->type->value === 'percent')

                            {{ $coupon->value }} %

                            @else

                            ${{ number_format($coupon->value,2) }}

                            @endif

                        </td>

                        <td>

                            ${{ number_format($coupon->minimum_amount ?? 0,2) }}

                        </td>

                        <td>

                            @if($coupon->maximum_discount)

                            ${{ number_format($coupon->maximum_discount,2) }}

                            @else

                            —

                            @endif

                        </td>

                        <td>

                            @if($coupon->usage_limit)

                            {{ $coupon->used_count }}

                            /

                            {{ $coupon->usage_limit }}

                            @else

                            Unlimited

                            @endif

                        </td>

                        <td>

                            @if($coupon->expires_at)

                            {{ $coupon->expires_at->format('Y-m-d H:i') }}

                            @else

                            —

                            @endif

                        </td>

                        <td>

                            @if($coupon->status)

                            <span class="badge bg-success">

                                Active

                            </span>

                            @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="{{ route('admin.coupons.show',$coupon) }}" class="btn btn-sm btn-info">

                                    <i class="fas fa-eye">View</i>

                                </a>

                                <a href="{{ route('admin.coupons.edit',$coupon) }}" class="btn btn-sm btn-warning">

                                    <i class="fas fa-edit">Edit</i>

                                </a>

                                <form action="{{ route('admin.coupons.destroy',$coupon) }}" method="POST">

                                    @csrf

                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this coupon?')">

                                        <i class="fas fa-trash">Delete</i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10" class="text-center">

                            No coupons found.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $coupons->links() }}

        </div>

    </div>

</div>

@endsection
