@extends('admin.layouts.app')

@section('title','Coupon Details')

@section('content')

<div class="row">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Coupon Details

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tbody>

                        <tr>

                            <th width="30%">

                                ID

                            </th>

                            <td>

                                {{ $coupon->id }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Code

                            </th>

                            <td>

                                <span class="badge bg-primary fs-6">

                                    {{ $coupon->code }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Type

                            </th>

                            <td>

                                {{ ucfirst($coupon->type->value) }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Value

                            </th>

                            <td>

                                @if($coupon->type->value == 'percent')

                                {{ $coupon->value }} %

                                @else

                                ${{ number_format($coupon->value,2) }}
                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Minimum Order

                            </th>

                            <td>

                                ${{ number_format($coupon->minimum_amount ?? 0,2) }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Maximum Discount

                            </th>

                            <td>

                                {{ $coupon->maximum_discount
                                    ? '$'.number_format($coupon->maximum_discount,2)
                                    : 'Unlimited'
                                }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Usage Limit

                            </th>

                            <td>

                                {{ $coupon->usage_limit ?? 'Unlimited' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Used Count

                            </th>

                            <td>

                                {{ $coupon->used_count }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Starts At

                            </th>

                            <td>

                                {{ $coupon->starts_at?->format('Y-m-d H:i') ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Expires At

                            </th>

                            <td>

                                {{ $coupon->expires_at?->format('Y-m-d H:i') ?? '-' }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Status

                            </th>

                            <td>

                                @if($coupon->is_active)

                                <span class="badge bg-success">

                                    Active

                                </span>

                                @else

                                <span class="badge bg-danger">

                                    Inactive

                                </span>

                                @endif

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Created At

                            </th>

                            <td>

                                {{ $coupon->created_at->format('Y-m-d H:i') }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Updated At

                            </th>

                            <td>

                                {{ $coupon->updated_at->format('Y-m-d H:i') }}

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">

            <div class="card-header">

                Statistics

            </div>

            <div class="card-body">

                <h5 class="mb-3">

                    Usage

                </h5>

                <div class="progress mb-3">

                    @php

                    $percent = $coupon->usage_limit
                    ? min(100, ($coupon->used_count / $coupon->usage_limit) * 100)
                    : 0;

                    @endphp

                    <div class="progress-bar" style="width: {{ $percent }}%">

                        {{ round($percent) }}%

                    </div>

                </div>

                <p>

                    <strong>Used:</strong>

                    {{ $coupon->used_count }}

                </p>

                <p>

                    <strong>Remaining:</strong>

                    {{ $coupon->usage_limit
                        ? max(0,$coupon->usage_limit-$coupon->used_count)
                        : '∞'
                    }}

                </p>

                <hr>

                <a href="{{ route('admin.coupons.edit',$coupon) }}" class="btn btn-warning w-100 mb-2">

                    Edit Coupon

                </a>

                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary w-100">

                    Back

                </a>

            </div>

        </div>

    </div>

</div>

@endsection
