@extends('web.layouts.app')

@section('title', 'Home')

@section('content')

<div class="container py-5">

    <div class="mb-5">

        <h2 class="fw-bold">
            Latest Products
        </h2>

        <p class="text-muted">
            Discover our newest products.
        </p>

    </div>

    <div class="row g-4">

        @foreach($products as $product)

        <div class="col-lg-3 col-md-4 col-sm-6">

            @include('web.partials.product-card', [
            'product' => $product,
            ])

        </div>

        @endforeach

    </div>

</div>

@endsection
