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

        <div class="col-md-4 mb-4">

            <div class="card h-100">

                @if($product->images->isNotEmpty())

                <img src="{{ $product->images->first()->image_url }}" class="card-img-top product-image" alt="{{ $product->name }}">

                @else

                <div class="bg-light d-flex justify-content-center align-items-center product-image">
                    <i class="bi bi-image fs-1 text-secondary"></i>
                </div>

                @endif

                <div class="card-body">

                    <h5>

                        {{ $product->name }}

                    </h5>

                    <p>

                        {{ $product->formatted_price ?? number_format($product->price, 2) }}

                    </p>

                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST">

                        @csrf

                        <button class="btn btn-outline-danger w-100">

                            Remove

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info">

                Your wishlist is empty.

            </div>

        </div>

        @endforelse

    </div>

    {{ $wishlists->links() }}

</div>

@endsection
