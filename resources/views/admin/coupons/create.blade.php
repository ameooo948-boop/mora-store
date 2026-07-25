@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Create Coupon
        </h3>

    </div>

    <form action="{{ route('admin.coupons.store') }}" method="POST">

        @csrf

        <div class="card-body">

            @include('admin.coupons._form')

        </div>

    </form>

</div>

@endsection
