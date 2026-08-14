@extends('admin.layouts.app')

@section('title', 'Brand Details')
@section('page-title', 'Brand Details')

@section('content')

<div class="brand-details-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="brand-details-hero">

        <div class="brand-details-hero-left">

            <a href="{{ route('admin.brands.index') }}" class="brand-back-btn" title="Back to Brands">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>

                <span class="brand-details-eyebrow">
                    BRAND MANAGEMENT
                </span>

                <h1>
                    {{ $brand->name }}
                </h1>

                <p>
                    View brand information, status and catalog activity.
                </p>

            </div>

        </div>


        <div class="brand-details-actions">

            <a href="{{ route('admin.brands.edit', $brand) }}" class="brand-edit-btn">

                <i class="bi bi-pencil-square"></i>

                Edit Brand

            </a>

            <a href="{{ route('admin.brands.index') }}" class="brand-back-link">

                <i class="bi bi-grid"></i>

                All Brands

            </a>

        </div>

    </div>



    {{-- =====================================================
         OVERVIEW
    ====================================================== --}}

    <div class="brand-overview-grid">


        {{-- =================================================
             LOGO CARD
        ================================================== --}}

        <div class="brand-logo-card">

            <div class="brand-logo-card-header">

                <div>

                    <span>
                        BRAND LOGO
                    </span>

                    <h3>
                        Identity
                    </h3>

                </div>

                @if($brand->status)

                <span class="brand-detail-status active">

                    <i class="bi bi-check-circle-fill"></i>

                    Active

                </span>

                @else

                <span class="brand-detail-status inactive">

                    <i class="bi bi-x-circle-fill"></i>

                    Inactive

                </span>

                @endif

            </div>


            <div class="brand-logo-stage">

                @if($brand->logo)

                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}">

                @else

                <div class="brand-no-logo">

                    <div class="brand-no-logo-icon">
                        <i class="bi bi-image"></i>
                    </div>

                    <strong>
                        No Logo
                    </strong>

                    <span>
                        This brand doesn't have a logo yet.
                    </span>

                </div>

                @endif

            </div>


            <div class="brand-logo-name">

                <span>
                    Brand
                </span>

                <strong>
                    {{ $brand->name }}
                </strong>

            </div>

        </div>



        {{-- =================================================
             INFORMATION
        ================================================== --}}

        <div class="brand-information-card">

            <div class="brand-card-header">

                <div class="brand-card-title">

                    <div class="brand-card-icon blue">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>

                        <h2>
                            Brand Information
                        </h2>

                        <span>
                            General information about this brand
                        </span>

                    </div>

                </div>

            </div>


            <div class="brand-info-grid">


                {{-- Name --}}

                <div class="brand-info-item">

                    <span class="brand-info-label">
                        <i class="bi bi-tag"></i>
                        Brand Name
                    </span>

                    <strong>
                        {{ $brand->name }}
                    </strong>

                </div>


                {{-- Products --}}

                <div class="brand-info-item">

                    <span class="brand-info-label">
                        <i class="bi bi-box-seam"></i>
                        Products
                    </span>

                    <div>

                        <span class="brand-products-count">

                            <i class="bi bi-box-seam-fill"></i>

                            {{ $brand->products_count }}

                            <small>
                                products
                            </small>

                        </span>

                    </div>

                </div>


                {{-- Status --}}

                <div class="brand-info-item">

                    <span class="brand-info-label">
                        <i class="bi bi-activity"></i>
                        Current Status
                    </span>

                    @if($brand->status)

                    <span class="brand-detail-status active">

                        <i class="bi bi-check-circle-fill"></i>

                        Active

                    </span>

                    @else

                    <span class="brand-detail-status inactive">

                        <i class="bi bi-x-circle-fill"></i>

                        Inactive

                    </span>

                    @endif

                </div>


                {{-- Sort Order --}}

                @if(isset($brand->sort_order))

                <div class="brand-info-item">

                    <span class="brand-info-label">
                        <i class="bi bi-sort-numeric-down"></i>
                        Sort Order
                    </span>

                    <strong>
                        #{{ $brand->sort_order }}
                    </strong>

                </div>

                @endif


                {{-- Created --}}

                <div class="brand-info-item">

                    <span class="brand-info-label">
                        <i class="bi bi-calendar-plus"></i>
                        Created
                    </span>

                    <strong>
                        {{ $brand->created_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $brand->created_at->format('h:i A') }}
                    </small>

                </div>


                {{-- Updated --}}

                <div class="brand-info-item">

                    <span class="brand-info-label">
                        <i class="bi bi-clock-history"></i>
                        Last Updated
                    </span>

                    <strong>
                        {{ $brand->updated_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $brand->updated_at->format('h:i A') }}
                    </small>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         DESCRIPTION
    ====================================================== --}}

    <div class="brand-description-card">

        <div class="brand-card-header">

            <div class="brand-card-title">

                <div class="brand-card-icon purple">
                    <i class="bi bi-text-paragraph"></i>
                </div>

                <div>

                    <h2>
                        Description
                    </h2>

                    <span>
                        Brand description and additional information
                    </span>

                </div>

            </div>

        </div>


        <div class="brand-description-body">

            @if($brand->description)

            <div class="brand-description-content">

                {!! nl2br(e($brand->description)) !!}

            </div>

            @else

            <div class="brand-empty-description">

                <div>
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <span>
                    No description available for this brand.
                </span>

            </div>

            @endif

        </div>

    </div>



    {{-- =====================================================
         QUICK SUMMARY
    ====================================================== --}}

    <div class="brand-summary-grid">


        <div class="brand-summary-card">

            <div class="brand-summary-icon blue">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span>
                    Products
                </span>

                <strong>
                    {{ $brand->products_count }}
                </strong>

            </div>

        </div>


        <div class="brand-summary-card">

            <div class="brand-summary-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div>

                <span>
                    Status
                </span>

                <strong>
                    {{ $brand->status ? 'Active' : 'Inactive' }}
                </strong>

            </div>

        </div>


        <div class="brand-summary-card">

            <div class="brand-summary-icon orange">
                <i class="bi bi-calendar3"></i>
            </div>

            <div>

                <span>
                    Created
                </span>

                <strong>
                    {{ $brand->created_at->format('d M Y') }}
                </strong>

            </div>

        </div>


        @if(isset($brand->sort_order))

        <div class="brand-summary-card">

            <div class="brand-summary-icon purple">
                <i class="bi bi-sort-numeric-down"></i>
            </div>

            <div>

                <span>
                    Sort Order
                </span>

                <strong>
                    #{{ $brand->sort_order }}
                </strong>

            </div>

        </div>

        @endif

    </div>

</div>

@endsection
