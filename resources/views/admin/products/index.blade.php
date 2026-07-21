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

        <div class="col-md-3">

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

        <div class="col-md-3">

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

        <div class="col-md-3">

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

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Out Of Stock

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $statistics['out_of_stock'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <strong>

                Showing

                {{ $products->total() }}

                Products

            </strong>

        </div>

    </div>

    {{-- Search & Filters --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-4">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or SKU...">

                    </div>

                    <div class="col-md-3">

                        <select name="category" class="form-select">

                            <option value="">

                                All Categories

                            </option>

                            @foreach($categories as $category)

                            <option value="{{ $category->id }}" @selected(request('category')==$category->id)>

                                {{ $category->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <select name="status" class="form-select">

                            <option value="">

                                All Status

                            </option>

                            <option value="1" @selected(request('status')==='1' )>

                                Active

                            </option>

                            <option value="0" @selected(request('status')==='0' )>

                                Inactive

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-center" width="80">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                    <tr>

                        <td>

                            <span class="badge bg-light text-dark">

                                #{{ $product->id }}

                            </span>

                        </td>

                        <td>

                            <div class="d-flex align-items-center">

                                @if($product->images->isNotEmpty())

                                <img src="{{ $product->images->first()->image_url }}" class="rounded border me-3" width="60" height="60" style="object-fit:cover;" alt="{{ $product->name }}">

                                @else

                                <div class="border rounded d-flex align-items-center justify-content-center me-3 bg-light" style="width:60px;height:60px;">

                                    <i class="bi bi-image text-secondary"></i>

                                </div>

                                @endif

                                <div>

                                    <div class="fw-semibold">

                                        {{ $product->name }}

                                    </div>

                                    <small class="text-muted">

                                        SKU: {{ $product->sku }}

                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>

                            <span class="badge bg-info">

                                {{ $product->category->name }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-dark">

                                {{ $product->brand->name }}

                            </span>

                        </td>

                        <td>

                            @if($product->sale_price)

                            <div class="small text-decoration-line-through text-muted">

                                ${{ number_format($product->price, 2) }}

                            </div>

                            <div class="fw-bold text-danger">

                                ${{ number_format($product->final_price, 2) }}

                            </div>

                            @else

                            <span class="fw-bold">

                                ${{ number_format($product->price, 2) }}

                            </span>

                            @endif

                        </td>

                        <td>

                            @if($product->quantity > 20)

                            <span class="badge bg-success">

                                {{ $product->quantity }}

                            </span>

                            @elseif($product->quantity > 0)

                            <span class="badge bg-warning text-dark">

                                {{ $product->quantity }}

                            </span>

                            @else

                            <span class="badge bg-danger">

                                Out

                            </span>

                            @endif

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

                        <td class="text-center">

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.products.show', $product) }}" class="dropdown-item">

                                            <i class="bi bi-eye me-2"></i>

                                            View

                                        </a>

                                    </li>

                                    <li>

                                        <a href="{{ route('admin.products.edit', $product) }}" class="dropdown-item">

                                            <i class="bi bi-pencil-square me-2"></i>

                                            Edit

                                        </a>

                                    </li>

                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="dropdown-item text-danger">

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

                        <td colspan="8">

                            <div class="text-center py-5">

                                <i class="bi bi-box display-4 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Products Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are no products matching your search.

                                </p>

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
