@extends('admin.layouts.app')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')

<div class="product-details-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="product-details-hero">

        <div class="product-details-hero-left">

            <a href="{{ route('admin.products.index') }}" class="product-details-back" title="Back to Products">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>

                <span class="product-details-eyebrow">
                    PRODUCT MANAGEMENT
                </span>

                <h1>
                    {{ $product->name }}
                </h1>

                <p>
                    Product details, inventory and catalog information.
                </p>

            </div>

        </div>


        <div class="product-details-actions">

            <a href="{{ route('admin.products.edit', $product) }}" class="product-details-edit">
                <i class="bi bi-pencil-square"></i>
                Edit Product
            </a>

            <a href="{{ route('admin.products.index') }}" class="product-details-all">
                <i class="bi bi-box-seam"></i>
                All Products
            </a>

        </div>

    </div>



    {{-- =====================================================
         MAIN OVERVIEW
    ====================================================== --}}

    <div class="product-details-grid">


        {{-- =================================================
             GALLERY
        ================================================== --}}

        <div class="product-gallery-card">

            <div class="product-gallery-header">

                <div>

                    <span>
                        PRODUCT GALLERY
                    </span>

                    <h3>
                        Images
                    </h3>

                </div>


                @if($product->images->count())

                <span class="product-image-count">

                    <i class="bi bi-images"></i>

                    {{ $product->images->count() }}

                </span>

                @endif

            </div>


            @if($product->images->isNotEmpty())

            <div class="product-main-image">

                <img id="main-image" src="{{ Storage::url($product->images->first()->image) }}" alt="{{ $product->name }}">

            </div>


            <div class="product-thumbnails">

                @foreach($product->images as $image)

                <button type="button" class="product-thumbnail {{ $loop->first ? 'active' : '' }}" onclick="changeProductImage(this)">

                    <img src="{{ Storage::url($image->image) }}" alt="{{ $product->name }}">

                </button>

                @endforeach

            </div>

            @else

            <div class="product-no-image">

                <div class="product-no-image-icon">
                    <i class="bi bi-image"></i>
                </div>

                <strong>
                    No Image Available
                </strong>

                <span>
                    This product doesn't have any images yet.
                </span>

            </div>

            @endif

        </div>



        {{-- =================================================
             PRODUCT INFORMATION
        ================================================== --}}

        <div class="product-information-card">

            <div class="product-details-card-header">

                <div class="product-details-card-title">

                    <div class="product-details-card-icon blue">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>

                        <h2>
                            Product Information
                        </h2>

                        <span>
                            General product information
                        </span>

                    </div>

                </div>

            </div>


            <div class="product-info-list">


                {{-- Name --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-tag"></i>
                        Product Name
                    </span>

                    <strong>
                        {{ $product->name }}
                    </strong>

                </div>


                {{-- SKU --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-upc-scan"></i>
                        SKU
                    </span>

                    <strong class="product-sku">
                        {{ $product->sku }}
                    </strong>

                </div>


                {{-- Category --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-grid"></i>
                        Category
                    </span>

                    <span class="product-category-pill">
                        <i class="bi bi-grid-fill"></i>
                        {{ $product->category->name }}
                    </span>

                </div>


                {{-- Brand --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-tags"></i>
                        Brand
                    </span>

                    <span class="product-brand-pill">
                        <i class="bi bi-tag-fill"></i>
                        {{ $product->brand->name }}
                    </span>

                </div>


                {{-- Status --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-activity"></i>
                        Status
                    </span>

                    @if($product->status)

                    <span class="product-detail-status active">
                        <i class="bi bi-check-circle-fill"></i>
                        Active
                    </span>

                    @else

                    <span class="product-detail-status inactive">
                        <i class="bi bi-x-circle-fill"></i>
                        Inactive
                    </span>

                    @endif

                </div>


                {{-- Featured --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-star"></i>
                        Featured
                    </span>

                    @if($product->is_featured)

                    <span class="product-featured yes">
                        <i class="bi bi-star-fill"></i>
                        Featured
                    </span>

                    @else

                    <span class="product-featured no">
                        <i class="bi bi-dash-circle"></i>
                        Standard
                    </span>

                    @endif

                </div>


                {{-- Sort --}}

                <div class="product-info-row">

                    <span>
                        <i class="bi bi-sort-numeric-down"></i>
                        Sort Order
                    </span>

                    <strong>
                        #{{ $product->sort_order }}
                    </strong>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         PRICE / STOCK
    ====================================================== --}}

    <div class="product-metrics">


        {{-- Price --}}

        <div class="product-metric-card price">

            <div class="product-metric-icon blue">
                <i class="bi bi-currency-dollar"></i>
            </div>

            <div>

                <span>
                    Regular Price
                </span>

                <strong>
                    {{ number_format($product->price, 2) }}
                </strong>

            </div>

        </div>


        {{-- Sale --}}

        <div class="product-metric-card sale">

            <div class="product-metric-icon red">
                <i class="bi bi-percent"></i>
            </div>

            <div>

                <span>
                    Sale Price
                </span>

                @if($product->sale_price)

                <strong>
                    {{ number_format($product->sale_price, 2) }}
                </strong>

                @else

                <strong class="muted">
                    No Sale
                </strong>

                @endif

            </div>

        </div>


        {{-- Stock --}}

        <div class="product-metric-card stock">

            <div class="product-metric-icon green">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span>
                    Current Stock
                </span>

                <strong>
                    {{ $product->quantity }}
                </strong>

            </div>

        </div>


        {{-- Images --}}

        <div class="product-metric-card images">

            <div class="product-metric-icon purple">
                <i class="bi bi-images"></i>
            </div>

            <div>

                <span>
                    Total Images
                </span>

                <strong>
                    {{ $product->images->count() }}
                </strong>

            </div>

        </div>

    </div>



    {{-- =====================================================
         DESCRIPTION
    ====================================================== --}}

    <div class="product-description-card">

        <div class="product-details-card-header">

            <div class="product-details-card-title">

                <div class="product-details-card-icon purple">
                    <i class="bi bi-text-paragraph"></i>
                </div>

                <div>

                    <h2>
                        Description
                    </h2>

                    <span>
                        Product description and additional information
                    </span>

                </div>

            </div>

        </div>


        <div class="product-description-body">

            @if($product->description)

            <div class="product-description-content">

                {!! nl2br(e($product->description)) !!}

            </div>

            @else

            <div class="product-empty-description">

                <div>
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <span>
                    No description available for this product.
                </span>

            </div>

            @endif

        </div>

    </div>



    {{-- =====================================================
         TIMELINE
    ====================================================== --}}

    <div class="product-timeline-card">

        <div class="product-details-card-header">

            <div class="product-details-card-title">

                <div class="product-details-card-icon green">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>

                    <h2>
                        Product Timeline
                    </h2>

                    <span>
                        Creation and latest update information
                    </span>

                </div>

            </div>

        </div>


        <div class="product-timeline">


            <div class="product-timeline-item">

                <div class="product-timeline-icon blue">
                    <i class="bi bi-plus-lg"></i>
                </div>

                <div>

                    <span>
                        Created
                    </span>

                    <strong>
                        {{ $product->created_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $product->created_at->format('h:i A') }}
                    </small>

                </div>

            </div>


            <div class="product-timeline-line"></div>


            <div class="product-timeline-item">

                <div class="product-timeline-icon green">
                    <i class="bi bi-arrow-clockwise"></i>
                </div>

                <div>

                    <span>
                        Last Updated
                    </span>

                    <strong>
                        {{ $product->updated_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $product->updated_at->format('h:i A') }}
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>



@push('scripts')

<script>
    function changeProductImage(button) {

        const mainImage = document.getElementById('main-image');

        if (!mainImage) return;

        const image = button.querySelector('img');

        if (!image) return;

        mainImage.style.opacity = '0';

        setTimeout(() => {

            mainImage.src = image.src;

            mainImage.style.opacity = '1';

        }, 120);


        document
            .querySelectorAll('.product-thumbnail')
            .forEach(item => {

                item.classList.remove('active');

            });

        button.classList.add('active');
    }

</script>

@endpush

@endsection
