@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Products

            </h2>

            <p class="text-muted mb-0">

                Browse all available products.

            </p>

        </div>

    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                <i class="bi bi-funnel me-2"></i>

                Filters

            </h5>

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-4">

                        <label class="form-label">

                            Search

                        </label>

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by product name or SKU">

                    </div>

                    <div class="col-lg-3">

                        <label class="form-label">

                            Category

                        </label>

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

                    <div class="col-lg-3">

                        <label class="form-label">

                            Brand

                        </label>

                        <select name="brand" class="form-select">

                            <option value="">

                                All Brands

                            </option>

                            @foreach($brands as $brand)

                            <option value="{{ $brand->id }}" @selected(request('brand')==$brand->id)>

                                {{ $brand->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <label class="form-label">

                            Sort

                        </label>

                        <select name="sort" class="form-select">

                            <option value="">

                                Newest

                            </option>

                            <option value="price_low" @selected(request('sort')=='price_low' )>

                                Price ↑

                            </option>

                            <option value="price_high" @selected(request('sort')=='price_high' )>

                                Price ↓

                            </option>

                            <option value="oldest" @selected(request('sort')=='oldest' )>

                                Oldest

                            </option>

                        </select>

                    </div>

                    <div class="col-12">

                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-search me-2"></i>

                                Apply Filters

                            </button>

                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-clockwise me-2"></i>

                                Reset

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="row g-4">

        @forelse($products as $product)

        <div class="col-xl-3 col-lg-4 col-md-6">

            @include('web.partials.product-card', [
            'product' => $product,
            ])

        </div>

        @empty

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-5">

                    <i class="bi bi-box-seam display-3 text-secondary"></i>

                    <h4 class="mt-3">

                        No Products Found

                    </h4>

                    <p class="text-muted">

                        Try changing your search or filters.

                    </p>

                    <a href="{{ route('products.index') }}" class="btn btn-primary">

                        View All Products

                    </a>

                </div>

            </div>

        </div>

        @endforelse

    </div>

    @if($products->hasPages())

    <div class="d-flex justify-content-center mt-5">

        {{ $products->links() }}

    </div>

    @endif

</div>

@endsection
