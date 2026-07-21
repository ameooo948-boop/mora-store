@extends('admin.layouts.app')

@section('title', 'Products')

@section('page-title', 'Products')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Products
            </h3>

            <p class="text-muted mb-0">
                Manage all products
            </p>

        </div>

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">

            <i class="bi bi-plus-lg me-2"></i>

            Add Product

        </a>

    </div>

    {{-- Statistics --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total Products
                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['total'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Active
                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['active'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Inactive
                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['inactive'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- Search --}}
    <div class="card mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-10">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by product name or SKU...">

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Table --}}
    <div class="card">

        <div class="table-responsive">

            <table class="table align-middle align-middle mb-0">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Category</th>

                        <th>Brand</th>

                        <th>SKU</th>

                        <th>Price</th>

                        <th>Qty</th>

                        <th>Status</th>

                        <th width="80"></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                    <tr>

                        <td>{{ $product->id }}</td>

                        <td>

                            @if($product->images->isNotEmpty())

                            <img src="{{ $product->images->first()->image_url }}" width="50" height="50" class="rounded" style="object-fit: cover;">

                            @else

                            <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width:50px;height:50px;">

                                <i class="bi bi-image text-secondary"></i>

                            </div>

                            @endif

                        </td>

                        <td>

                            <strong>

                                {{ $product->name }}

                            </strong>

                        </td>

                        <td>

                            {{ $product->category->name }}

                        </td>

                        <td>

                            {{ $product->brand->name }}

                        </td>

                        <td>

                            <span class="badge bg-secondary">

                                {{ $product->sku }}

                            </span>

                        </td>

                        <td>

                            @if($product->sale_price)

                            <div>

                                <span class="text-decoration-line-through text-muted">

                                    ${{ number_format($product->price,2) }}

                                </span>

                            </div>

                            <strong class="text-danger">

                                ${{ number_format($product->final_price,2) }}

                            </strong>

                            @else

                            <strong>

                                ${{ number_format($product->price,2) }}

                            </strong>

                            @endif

                        </td>

                        <td>

                            {{ $product->quantity }}

                        </td>

                        <td>

                            @if($product->status)

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

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.products.edit',$product) }}" class="dropdown-item">

                                            <i class="bi bi-pencil-square me-2"></i>

                                            Edit

                                        </a>

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.products.destroy',$product) }}" method="POST" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button class="dropdown-item text-danger">

                                                <i class="bi bi-trash me-2"></i>

                                                Delete

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10">

                            <div class="text-center py-5">

                                <i class="bi bi-box display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Products Found

                                </h5>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($products->hasPages())

        <div class="card-footer">

            {{ $products->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
