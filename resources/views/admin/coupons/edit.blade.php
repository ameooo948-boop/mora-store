@extends('admin.layouts.app')

@section('title', 'Edit Coupon')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Edit Coupon

            <span class="text-primary">
                ({{ $coupon->code }})
            </span>

        </h3>

    </div>

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            @include('admin.coupons._form')

        </div>

    </form>

</div>

@endsection
