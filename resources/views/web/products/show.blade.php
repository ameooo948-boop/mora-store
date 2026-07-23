@extends('web.layouts.app')

@section('title', $product->name)

@section('content')

@php

$inWishlist = auth()->check()
? auth()->user()->wishlists()->where('product_id', $product->id)->exists()
: false;

@endphp

<div class="container py-5">

    <div class="row g-5">

        {{-- Images --}}
        <div class="col-lg-6">

            @php
            $mainImage = $product->images->first();
            @endphp

            @if($mainImage)

            <img id="mainImage" src="{{ $mainImage->image_url }}" class="img-fluid rounded shadow-sm w-100 border" alt="{{ $product->name }}" style="height:550px;object-fit:cover;">

            @if($product->images->count() > 1)

            <div class="row mt-3">

                @foreach($product->images as $image)

                <div class="col-3 mb-3">

                    <img src="{{ $image->image_url }}" class="img-fluid rounded border thumbnail-image" data-image="{{ $image->image_url }}" style="height:90px;object-fit:cover;cursor:pointer;">

                </div>

                @endforeach

            </div>

            @endif

            @else

            <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height:550px;">

                <i class="bi bi-image fs-1"></i>

            </div>

            @endif

        </div>

        {{-- Product Info --}}
        <div class="col-lg-6">

            <span class="badge bg-primary mb-3">

                {{ $product->category->name }}

            </span>

            <h1 class="fw-bold">

                {{ $product->name }}

            </h1>

            <div class="text-muted mb-3">

                Brand :

                <strong>

                    {{ $product->brand->name }}

                </strong>

            </div>

            <div class="text-muted mb-3">

                SKU :

                {{ $product->sku }}

            </div>

            <div class="mb-4">

                @if($product->quantity == 0)

                <span class="badge bg-danger">

                    Out Of Stock

                </span>

                @elseif($product->quantity <= 5) <span class="badge bg-warning text-dark">

                    Only {{ $product->quantity }} Left

                    </span>

                    @else

                    <span class="badge bg-success">

                        In Stock ({{ $product->quantity }})

                    </span>

                    @endif

            </div>

            @if($product->has_discount)

            <div class="mb-2">

                <span class="badge bg-danger">

                    -{{ $product->discount_percentage }}%

                </span>

            </div>

            <div class="mb-2">

                <span class="fs-5 text-muted text-decoration-line-through">

                    {{ number_format($product->price, 2) }}

                    EGP

                </span>

            </div>

            <h2 class="text-danger fw-bold mb-4">

                {{ number_format($product->final_price, 2) }}

                EGP

            </h2>

            @else

            <h2 class="text-success fw-bold mb-4">

                {{ number_format($product->price, 2) }}

                EGP

            </h2>

            @endif

            <hr>

            <p class="text-muted">

                {{ $product->description }}

            </p>

            <hr>

            <div class="mb-4">

                <label class="form-label">

                    Quantity

                </label>

            </div>

            <form id="addToCartForm" action="{{ route('cart.store', $product) }}" method="POST">

                @csrf

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Quantity
                    </label>

                    <div class="d-flex align-items-center gap-2">

                        <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">

                            -

                        </button>

                        <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->quantity }}" style="width:90px;" readonly>

                        <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">

                            +

                        </button>

                    </div>

                </div>

                <button id="addToCartButton" class="btn btn-primary" {{ $product->quantity == 0 ? 'disabled' : '' }}>

                    <i class="bi bi-cart-plus me-2"></i>

                    {{ $product->quantity == 0 ? 'Out Of Stock' : 'Add To Cart' }}

                </button>

            </form>

            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-form">
                @csrf

                <button type="submit" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">

                    <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>

                </button>
            </form>


        </div>


    </div>

    {{-- Description --}}
    <div class="mt-5">

        <div class="card shadow-sm">

            <div class="card-header">

                <h4 class="mb-0">

                    Description

                </h4>

            </div>

            <div class="card-body">

                {!! nl2br(e($product->description)) !!}

            </div>

        </div>

    </div>

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())

    <div class="mt-5">

        <h3 class="mb-4">

            Related Products

        </h3>

        <div class="row">

            @foreach($relatedProducts as $product)

            <div class="col-md-3 mb-4">

                @include('web.partials.product-card')

            </div>

            @endforeach

        </div>

    </div>

    @endif

</div>

@endsection
