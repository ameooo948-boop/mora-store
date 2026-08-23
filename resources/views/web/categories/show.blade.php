@extends('web.layouts.app')

@section('title', $category->name)

@section('content')

<div class="category-show-page">

    <div class="container py-5">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">
                        Categories
                    </a>
                </li>

                @if($category->parent)

                <li class="breadcrumb-item">
                    <a href="{{ route('categories.show', $category->parent) }}">
                        {{ $category->parent->name }}
                    </a>
                </li>

                @endif

                <li class="breadcrumb-item active">
                    {{ $category->name }}
                </li>

            </ol>

        </nav>


        {{-- Category Header --}}
        <div class="category-show-header">

            <div class="row align-items-center g-4">

                <div class="col-md-7">

                    <span class="text-uppercase text-muted small fw-semibold">
                        Category
                    </span>

                    <h1 class="display-5 fw-bold mt-2">
                        {{ $category->name }}
                    </h1>

                    @if($category->description)

                    <p class="text-muted mt-3">
                        {{ $category->description }}
                    </p>

                    @endif

                </div>


                @if($category->image_url)

                <div class="col-md-5">

                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="category-show-image">

                </div>

                @endif

            </div>

        </div>


        {{-- Subcategories --}}
        @if($category->children->isNotEmpty())

        <section class="mt-5">

            <div class="section-heading mb-4">

                <div>
                    <span class="text-muted small">
                        Browse
                    </span>

                    <h2>
                        Shop by Subcategory
                    </h2>
                </div>

            </div>


            <div class="row g-3">

                @foreach($category->children as $child)

                <div class="col-6 col-md-4 col-lg-3">

                    <a href="{{ route('categories.show', $child) }}" class="subcategory-card">

                        @if($child->image_url)

                        <img src="{{ $child->image_url }}" alt="{{ $child->name }}" loading="lazy">

                        @else

                        <div class="subcategory-icon">
                            <i class="bi bi-box"></i>
                        </div>

                        @endif

                        <div>
                            <h5>
                                {{ $child->name }}
                            </h5>

                            <span>
                                Shop Now
                                <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>

                    </a>

                </div>

                @endforeach

            </div>

        </section>

        @endif


        {{-- Products --}}
        <section class="mt-5">

            <div class="section-heading mb-4">

                <div>
                    <span class="text-muted small">
                        Latest Products
                    </span>

                    <h2>
                        {{ $category->name }} Products
                    </h2>
                </div>

            </div>


            @if($products->isNotEmpty())

            <div class="row g-4">

                @foreach($products as $product)

                <div class="col-6 col-md-4 col-lg-3">

                    @include('web.partials.product-card', [
                    'product' => $product
                    ])

                </div>

                @endforeach

            </div>


            <div class="mt-5">

                {{ $products->links() }}

            </div>

            @else

            <div class="text-center py-5">

                <i class="bi bi-box-seam display-4 text-muted"></i>

                <h3 class="mt-3">
                    No Products Found
                </h3>

                <p class="text-muted">
                    There are currently no products in this category.
                </p>

                <a href="{{ route('products.index') }}" class="btn btn-dark mt-2">
                    Browse All Products
                </a>

            </div>

            @endif

        </section>

    </div>

</div>

@endsection
