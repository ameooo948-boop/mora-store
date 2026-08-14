@extends('web.layouts.app')

@section('title', 'Products')

@section('content')

<div class="products-page">

    <div class="container">

        {{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <div class="products-header">

            <div>

                <span class="products-eyebrow">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    OUR COLLECTION
                </span>

                <h1>
                    Explore Products
                </h1>

                <p>
                    Discover products you'll love, all in one place.
                </p>

            </div>


            @if($products->total())

            <div class="products-count">

                <strong>
                    {{ $products->total() }}
                </strong>

                <span>
                    {{ Str::plural('Product', $products->total()) }}
                </span>

            </div>

            @endif

        </div>


        {{-- =====================================================
            FILTER PANEL
        ====================================================== --}}

        <section class="products-filter">

            <div class="filter-top">

                <div class="filter-title">

                    <div class="filter-icon">
                        <i class="bi bi-sliders2"></i>
                    </div>

                    <div>

                        <span>
                            REFINE RESULTS
                        </span>

                        <h2>
                            Find what you're looking for
                        </h2>

                    </div>

                </div>


                @if(request()->hasAny(['search', 'category', 'brand', 'sort']))

                <a href="{{ route('products.index') }}" class="filter-clear">
                    <i class="bi bi-x-circle"></i>
                    Clear All
                </a>

                @endif

            </div>


            <form method="GET" action="{{ route('products.index') }}" class="products-filter-form">

                {{-- Search --}}

                <div class="filter-field search-field">

                    <label for="product-search">
                        Search Products
                    </label>

                    <div class="filter-input">

                        <i class="bi bi-search"></i>

                        <input type="text" id="product-search" name="search" value="{{ request('search') }}" placeholder="Search by product name..." autocomplete="off">

                    </div>

                </div>


                {{-- Category --}}

                <div class="filter-field">

                    <label for="product-category">
                        Category
                    </label>

                    <div class="filter-select">

                        <i class="bi bi-grid"></i>

                        <select id="product-category" name="category">

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

                <div class="filter-field">

                    <label for="product-brand">
                        Brand
                    </label>

                    <div class="filter-select">

                        <i class="bi bi-tags"></i>

                        <select id="product-brand" name="brand">

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


                {{-- Sort --}}

                <div class="filter-field">

                    <label for="product-sort">
                        Sort By
                    </label>

                    <div class="filter-select">

                        <i class="bi bi-sort-down"></i>

                        <select id="product-sort" name="sort">

                            <option value="">
                                Newest
                            </option>

                            <option value="price_low" @selected(request('sort')=='price_low' )>
                                Price: Low to High
                            </option>

                            <option value="price_high" @selected(request('sort')=='price_high' )>
                                Price: High to Low
                            </option>

                            <option value="oldest" @selected(request('sort')=='oldest' )>
                                Oldest
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Actions --}}

                <div class="filter-actions">

                    <button type="submit" class="filter-apply-btn">
                        <i class="bi bi-search"></i>
                        Apply Filters
                    </button>

                </div>

            </form>


            {{-- Active Filters --}}

            @if(request()->hasAny(['search', 'category', 'brand', 'sort']))

            <div class="active-filters">

                <span class="active-label">
                    Active:
                </span>


                @if(request('search'))

                <span class="active-filter">

                    <i class="bi bi-search"></i>

                    "{{ request('search') }}"

                </span>

                @endif


                @if(request('category'))

                @php
                $selectedCategory = $categories->firstWhere('id', request('category'));
                @endphp

                @if($selectedCategory)

                <span class="active-filter">

                    <i class="bi bi-grid"></i>

                    {{ $selectedCategory->name }}

                </span>

                @endif

                @endif


                @if(request('brand'))

                @php
                $selectedBrand = $brands->firstWhere('id', request('brand'));
                @endphp

                @if($selectedBrand)

                <span class="active-filter">

                    <i class="bi bi-tag"></i>

                    {{ $selectedBrand->name }}

                </span>

                @endif

                @endif


                @if(request('sort'))

                <span class="active-filter">

                    <i class="bi bi-sort-down"></i>

                    @switch(request('sort'))

                    @case('price_low')
                    Price: Low to High
                    @break

                    @case('price_high')
                    Price: High to Low
                    @break

                    @case('oldest')
                    Oldest
                    @break

                    @endswitch

                </span>

                @endif

            </div>

            @endif

        </section>


        {{-- =====================================================
            RESULTS BAR
        ====================================================== --}}

        @if($products->count())

        <div class="products-results-bar">

            <div>

                <span>
                    Showing
                </span>

                <strong>
                    {{ $products->firstItem() }}–{{ $products->lastItem() }}
                </strong>

                <span>
                    of
                </span>

                <strong>
                    {{ $products->total() }}
                </strong>

                <span>
                    products
                </span>

            </div>

        </div>

        @endif


        {{-- =====================================================
            PRODUCTS GRID
        ====================================================== --}}

        <div class="products-grid">

            @forelse($products as $product)

            <div class="product-grid-item">

                @include('web.partials.product-card', [
                'product' => $product,
                ])

            </div>

            @empty

            {{-- =================================================
                    EMPTY STATE
                ================================================== --}}

            <div class="products-empty">

                <div class="products-empty-icon">

                    <i class="bi bi-search"></i>

                </div>

                <span class="products-eyebrow">
                    NOTHING FOUND
                </span>

                <h2>
                    No products found
                </h2>

                <p>
                    We couldn't find anything matching your search.
                    Try changing your filters or explore the full collection.
                </p>

                <a href="{{ route('products.index') }}" class="products-empty-btn">
                    <i class="bi bi-grid"></i>

                    View All Products

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

            @endforelse

        </div>


        {{-- =====================================================
            PAGINATION
        ====================================================== --}}

        @if($products->hasPages())

        <div class="products-pagination">

            {{ $products->withQueryString()->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
