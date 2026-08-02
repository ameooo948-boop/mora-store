@extends('web.layouts.app')

@section('title', 'My Wishlist')

@section('content')

<div class="container">

    <h2 class="mb-4">
        My Wishlist
    </h2>

    <div class="row">

        @forelse($wishlists as $wishlist)

        @php
        $product = $wishlist->product;
        @endphp

        <div class="col-md-4 col-lg-3 mb-4">

            <div class="card h-100 shadow-sm">

                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">

                    @if($product->images->isNotEmpty())

                    <img src="{{ $product->images->first()->image_url }}" class="card-img-top product-image" alt="{{ $product->name }}">

                    @else

                    <div class="bg-light d-flex justify-content-center align-items-center product-image">
                        <i class="bi bi-image fs-1 text-secondary"></i>
                    </div>

                    @endif

                    <div class="card-body">

                        <h5 class="card-title mb-2">
                            {{ $product->name }}
                        </h5>

                        <h6 class="text-primary fw-bold mb-0">
                            {{ $product->formatted_price ?? number_format($product->price, 2) }}
                        </h6>

                    </div>

                </a>

                <div class="card-footer bg-white border-0 pt-0">

                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST">

                        @csrf

                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-heartbreak me-2"></i>
                            Remove
                        </button>

                    </form>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info text-center">
                Your wishlist is empty.
            </div>

        </div>

        @endforelse

    </div>

    <div class="d-flex justify-content-center">
        {{ $wishlists->links() }}
    </div>

</div>

@endsection
