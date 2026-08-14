@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')

<div class="products-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="products-hero">

        <div class="products-hero-content">

            <div class="products-hero-icon">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span class="products-eyebrow">
                    CATALOG MANAGEMENT
                </span>

                <h1>
                    Products
                </h1>

                <p>
                    Manage your products, inventory and catalog information.
                </p>

            </div>

        </div>


        <a href="{{ route('admin.products.create') }}" class="products-add-btn">

            <i class="bi bi-plus-lg"></i>

            Add Product

        </a>

    </div>



    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="products-stats">


        <div class="product-stat-card">

            <div class="product-stat-icon blue">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span>
                    Total Products
                </span>

                <strong>
                    {{ $statistics['total'] }}
                </strong>

            </div>

        </div>


        <div class="product-stat-card">

            <div class="product-stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div>

                <span>
                    Active
                </span>

                <strong>
                    {{ $statistics['active'] }}
                </strong>

            </div>

        </div>


        <div class="product-stat-card">

            <div class="product-stat-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div>

                <span>
                    Inactive
                </span>

                <strong>
                    {{ $statistics['inactive'] }}
                </strong>

            </div>

        </div>


        <div class="product-stat-card">

            <div class="product-stat-icon orange">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div>

                <span>
                    Out Of Stock
                </span>

                <strong>
                    {{ $statistics['out_of_stock'] }}
                </strong>

            </div>

        </div>

    </div>



    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="products-filter-card">

        <div class="products-filter-header">

            <div class="products-filter-title">

                <div class="products-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>

                    <h2>
                        Search & Filter
                    </h2>

                    <span>
                        Find products quickly
                    </span>

                </div>

            </div>


            @if(request()->hasAny(['search', 'category', 'brand', 'status']))

            <a href="{{ route('admin.products.index') }}" class="products-reset-btn">

                <i class="bi bi-arrow-counterclockwise"></i>

                Reset

            </a>

            @endif

        </div>


        <form method="GET">

            <div class="products-filter-body">


                {{-- Search --}}

                <div>

                    <label>
                        Search
                    </label>

                    <div class="product-input">

                        <i class="bi bi-search"></i>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or SKU...">

                    </div>

                </div>


                {{-- Category --}}

                <div>

                    <label>
                        Category
                    </label>

                    <div class="product-input">

                        <i class="bi bi-grid"></i>

                        <select name="category">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                            <option value="{{ $category->id }}" @selected(request('category')==$category->id)
                                >
                                {{ $category->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Brand --}}

                <div>

                    <label>
                        Brand
                    </label>

                    <div class="product-input">

                        <i class="bi bi-tags"></i>

                        <select name="brand">

                            <option value="">
                                All Brands
                            </option>

                            @foreach($brands as $brand)

                            <option value="{{ $brand->id }}" @selected(request('brand')==$brand->id)
                                >
                                {{ $brand->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Status --}}

                <div>

                    <label>
                        Status
                    </label>

                    <div class="product-input">

                        <i class="bi bi-activity"></i>

                        <select name="status">

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

                </div>


                {{-- Filter --}}

                <button type="submit" class="products-filter-btn">

                    <i class="bi bi-search"></i>

                    Filter

                </button>

            </div>

        </form>

    </div>



    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="products-table-card">


        <div class="products-table-header">

            <div>

                <span class="products-table-eyebrow">
                    PRODUCT DIRECTORY
                </span>

                <h2>
                    All Products
                </h2>

            </div>


            <div class="products-count">

                <i class="bi bi-box-seam"></i>

                {{ $products->total() }}

                <span>
                    products
                </span>

            </div>

        </div>


        <div class="table-responsive">

            <table class="products-table">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Brand
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Stock
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($products as $product)

                    <tr>


                        {{-- ID --}}

                        <td>

                            <span class="product-id">
                                #{{ $product->id }}
                            </span>

                        </td>


                        {{-- Product --}}

                        <td>

                            <div class="product-main-cell">

                                <div class="product-image">

                                    @if($product->images->isNotEmpty())

                                    <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}">

                                    @else

                                    <div class="product-image-empty">
                                        <i class="bi bi-image"></i>
                                    </div>

                                    @endif

                                </div>


                                <div class="product-main-info">

                                    <strong>
                                        {{ $product->name }}
                                    </strong>

                                    <span>
                                        SKU: {{ $product->sku }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- Category --}}

                        <td>

                            <span class="product-category-badge">

                                <i class="bi bi-grid"></i>

                                {{ $product->category->name }}

                            </span>

                        </td>


                        {{-- Brand --}}

                        <td>

                            <span class="product-brand-badge">

                                <i class="bi bi-tags"></i>

                                {{ $product->brand->name }}

                            </span>

                        </td>


                        {{-- Price --}}

                        <td>

                            @if($product->sale_price)

                            <div class="product-old-price">

                                ${{ number_format($product->price, 2) }}

                            </div>

                            <div class="product-final-price">

                                ${{ number_format($product->final_price, 2) }}

                            </div>

                            @else

                            <span class="product-price">

                                ${{ number_format($product->price, 2) }}

                            </span>

                            @endif

                        </td>


                        {{-- Stock --}}

                        <td>

                            @if($product->quantity > 20)

                            <span class="product-stock high">

                                <i class="bi bi-box-seam"></i>

                                {{ $product->quantity }}

                            </span>

                            @elseif($product->quantity > 0)

                            <span class="product-stock low">

                                <i class="bi bi-exclamation-circle"></i>

                                {{ $product->quantity }}

                            </span>

                            @else

                            <span class="product-stock out">

                                <i class="bi bi-x-circle"></i>

                                Out

                            </span>

                            @endif

                        </td>


                        {{-- Status --}}

                        <td>

                            @if($product->status)

                            <span class="product-status active">

                                <i class="bi bi-check-circle-fill"></i>

                                Active

                            </span>

                            @else

                            <span class="product-status inactive">

                                <i class="bi bi-x-circle-fill"></i>

                                Inactive

                            </span>

                            @endif

                        </td>


                        {{-- Actions --}}

                        <td class="text-center">

                            <div class="product-actions">

                                {{-- Show --}}

                                <a href="{{ route('admin.products.show', $product) }}" class="product-action product-action-show" title="View Product">

                                    <i class="bi bi-eye"></i>

                                </a>


                                {{-- Edit --}}

                                <a href="{{ route('admin.products.edit', $product) }}" class="product-action product-action-edit" title="Edit Product">

                                    <i class="bi bi-pencil-square"></i>

                                </a>


                                {{-- Delete --}}

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form m-0">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="product-action product-action-delete" title="Delete Product">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8">

                            <div class="products-empty">

                                <div class="products-empty-icon">

                                    <i class="bi bi-box-seam"></i>

                                </div>

                                <h3>
                                    No Products Found
                                </h3>

                                <p>
                                    There are no products matching your current filters.
                                </p>

                                <a href="{{ route('admin.products.create') }}" class="products-empty-btn">

                                    <i class="bi bi-plus-lg"></i>

                                    Add Product

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}

        @if($products->hasPages())

        <div class="products-pagination">

            {{ $products->links() }}

        </div>

        @endif

    </div>

</div>


@push('scripts')

<script>
    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function(e) {

            e.preventDefault();

            Swal.fire({

                title: 'Delete Product?',

                text: "You won't be able to undo this action.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#dc3545',

                cancelButtonColor: '#64748b',

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel',

                reverseButtons: true

            }).then((result) => {

                if (result.isConfirmed) {

                    form.submit();

                }

            });

        });

    });

</script>

@endpush

@endsection
