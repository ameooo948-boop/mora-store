@extends('web.layouts.app')

@section('title', 'Shopping Cart')

@section('page-title', 'Shopping Cart')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Shopping Cart
            </h3>

            <p class="text-muted mb-0">
                Manage your shopping cart
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-2"></i>
            Continue Shopping
        </a>

    </div>

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Items
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $cart->items->count() }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Quantity
                    </small>

                    <h2 class="fw-bold text-primary mt-2">
                        {{ $cart->items->sum('quantity') }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Subtotal
                    </small>

                    <h2 class="fw-bold text-success mt-2">
                        ${{ number_format($totals['subtotal'], 2) }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        {{-- Cart Table --}}
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th width="170">Quantity</th>
                                <th>Total</th>
                                <th width="80"></th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($cart->items as $item)

                            <tr>

                                <td>
                                    {{ $item->id }}
                                </td>

                                <td>

                                    @if($item->product->images->isNotEmpty())

                                    <img src="{{ $item->product->images->first()->image_url }}" width="60" height="60" class="rounded" style="object-fit:cover;">

                                    @else

                                    <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width:60px;height:60px;">

                                        <i class="bi bi-image"></i>

                                    </div>

                                    @endif

                                </td>

                                <td>

                                    <strong>
                                        {{ $item->product->name }}
                                    </strong>

                                </td>

                                <td>

                                    ${{ number_format($item->price, 2) }}

                                </td>

                                <td>

                                    <form action="{{ route('cart.update', $item->product) }}" method="POST" class="d-flex gap-2">

                                        @csrf
                                        @method('PUT')

                                        <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="1">

                                        <button class="btn btn-success">

                                            <i class="bi bi-check-lg"></i>

                                        </button>

                                    </form>

                                </td>

                                <td>

                                    <strong>

                                        ${{ number_format($item->price * $item->quantity, 2) }}

                                    </strong>

                                </td>

                                <td>

                                    <div class="dropdown">

                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                            <i class="bi bi-three-dots-vertical"></i>

                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end">

                                            <li>

                                                <form action="{{ route('cart.destroy',$item->product) }}" method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="dropdown-item text-danger">

                                                        <i class="bi bi-trash me-2"></i>

                                                        Remove

                                                    </button>

                                                </form>

                                            </li>

                                        </ul>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="7">

                                    <div class="text-center py-5">

                                        <i class="bi bi-cart-x display-3 text-secondary"></i>

                                        <h5 class="mt-3">

                                            Your cart is empty

                                        </h5>

                                    </div>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Order Summary --}}
        @if($cart->items->isNotEmpty())

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 sticky-top" style="top:20px;">

                <div class="card-body">

                    <h4 class="fw-bold mb-4">

                        Order Summary

                    </h4>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Total Items

                        </span>

                        <strong>

                            {{ $cart->items->count() }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Quantity

                        </span>

                        <strong>

                            {{ $cart->items->sum('quantity') }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Subtotal

                        </span>

                        <strong>

                            ${{ number_format($totals['subtotal'],2) }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Shipping

                        </span>

                        <span class="text-success fw-semibold">

                            Free

                        </span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="mb-0">

                            Total

                        </h5>

                        <h4 class="text-success mb-0">

                            ${{ number_format($totals['total'],2) }}

                        </h4>

                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mb-3">

                        <i class="bi bi-credit-card me-2"></i>

                        Proceed to Checkout

                    </a>

                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary w-100 mb-3">

                        Continue Shopping

                    </a>

                    <form action="{{ route('cart.clear') }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger w-100">

                            <i class="bi bi-trash me-2"></i>

                            Clear Cart

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endif

    </div>

</div>

@endsection
