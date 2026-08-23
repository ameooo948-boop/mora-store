@extends('web.layouts.app')

@section('title', $brand->name)

@section('content')

<div class="brand-show-page">

    <div class="container py-5">

        {{-- =====================================================
            BACK
        ====================================================== --}}

        <a href="{{ route('brands.index') }}" class="brand-show-back">
            <i class="bi bi-arrow-left"></i>
            All Brands
        </a>


        {{-- =====================================================
            BRAND HERO
        ====================================================== --}}

        <section class="brand-show-hero">

            <div class="brand-show-logo">

                @if($brand->logo_url)

                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}">

                @else

                <i class="bi bi-award"></i>

                @endif

            </div>


            <div class="brand-show-info">

                <span class="brand-show-eyebrow">
                    OFFICIAL BRAND
                </span>

                <h1>
                    {{ $brand->name }}
                </h1>

                @if($brand->description)

                <p>
                    {{ $brand->description }}
                </p>

                @endif

                <div class="brand-show-meta">

                    <span>
                        <i class="bi bi-box-seam"></i>

                        {{ $brand->products_count }}

                        {{ Str::plural('Product', $brand->products_count) }}
                    </span>

                    <span>
                        <i class="bi bi-patch-check-fill"></i>
                        Trusted Brand
                    </span>

                </div>

            </div>

        </section>


        {{-- =====================================================
            PRODUCTS HEADER
        ====================================================== --}}

        <div class="brand-products-header">

            <div>

                <span>
                    COLLECTION
                </span>

                <h2>
                    {{ $brand->name }} Products
                </h2>

            </div>

            <span class="brand-products-count">
                {{ $products->total() }}
                {{ Str::plural('Product', $products->total()) }}
            </span>

        </div>


        {{-- =====================================================
            PRODUCTS
        ====================================================== --}}

        @if($products->isNotEmpty())

        <div class="row g-4">

            @foreach($products as $product)

            <div class="col-6 col-md-4 col-xl-3">

                @include(
                'web.partials.product-card',
                ['product' => $product]
                )

            </div>

            @endforeach

        </div>


        {{-- Pagination --}}

        @if($products->hasPages())

        <div class="brand-products-pagination mt-5">

            {{ $products->links() }}

        </div>

        @endif

        @else

        <div class="brand-products-empty">

            <div class="brand-products-empty-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <h2>
                No Products Yet
            </h2>

            <p>
                There are currently no available products
                from {{ $brand->name }}.
            </p>

            <a href="{{ route('products.index') }}" class="btn btn-primary">
                Browse All Products
            </a>

        </div>

        @endif

    </div>

</div>

@endsection
