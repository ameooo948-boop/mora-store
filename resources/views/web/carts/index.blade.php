@extends('admin.layouts.app')

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

    {{-- Cart Table --}}
    <div class="card">

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

                            <img src="{{ $item->product->images->first()->image_url }}" width="50" height="50" class="rounded" style="object-fit:cover;">

                            @else

                            <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width:50px;height:50px;">

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

                           ${{ number_format($totals['total'], 2) }}

                        </td>

                        <td>

                            <form action="{{ route('cart.update',$item->product) }}" method="POST" class="d-flex gap-2">

                                @csrf
                                @method('PUT')

                                <input type="number" class="form-control" name="quantity" value="{{ $item->quantity }}" min="1">

                                <button class="btn btn-success">

                                    <i class="bi bi-check-lg"></i>

                                </button>

                            </form>

                        </td>

                        <td>

                            <strong>

                               ${{ number_format($totals['total'], 2) }}

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

        @if($cart->items->isNotEmpty())

        <div class="card-footer d-flex justify-content-between align-items-center">

            <form action="{{ route('cart.clear') }}" method="POST">

                @csrf
                @method('DELETE')

                <button class="btn btn-outline-danger">

                    Clear Cart

                </button>

            </form>

            <h4 class="mb-0">

                Total :

                <span class="text-success">

                    ${{
                        number_format(
                            $cart->items->sum(fn($item)=>$item->price * $item->quantity),
                            2
                        )
                    }}

                </span>

            </h4>

        </div>

        @endif

    </div>

</div>

@endsection
