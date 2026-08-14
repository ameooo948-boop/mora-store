@extends('admin.layouts.app')

@section('title', 'Category Details')
@section('page-title', 'Category Details')

@section('content')

<div class="category-details-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div class="category-details-hero">

        <div class="category-details-hero-left">

            <a href="{{ route('admin.categories.index') }}" class="category-back-btn" title="Back to Categories">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>

                <span class="category-details-eyebrow">
                    CATEGORY MANAGEMENT
                </span>

                <h1>
                    {{ $category->name }}
                </h1>

                <p>
                    View category information, hierarchy and catalog activity.
                </p>

            </div>

        </div>


        <div class="category-details-actions">

            <a href="{{ route('admin.categories.edit', $category) }}" class="category-edit-btn">

                <i class="bi bi-pencil-square"></i>

                Edit Category

            </a>

            <a href="{{ route('admin.categories.index') }}" class="category-back-link">

                <i class="bi bi-grid"></i>

                All Categories

            </a>

        </div>

    </div>



    {{-- =====================================================
         OVERVIEW
    ====================================================== --}}

    <div class="category-overview-grid">


        {{-- =================================================
             IMAGE CARD
        ================================================== --}}

        <div class="category-image-card">

            <div class="category-image-card-header">

                <div>

                    <span>
                        CATEGORY IMAGE
                    </span>

                    <h3>
                        Identity
                    </h3>

                </div>


                @if($category->status)

                <span class="category-detail-status active">

                    <i class="bi bi-check-circle-fill"></i>

                    Active

                </span>

                @else

                <span class="category-detail-status inactive">

                    <i class="bi bi-x-circle-fill"></i>

                    Inactive

                </span>

                @endif

            </div>


            <div class="category-image-stage">

                @if($category->image)

                <img src="{{ $category->image_url }}" alt="{{ $category->name }}">

                @else

                <div class="category-no-image">

                    <div class="category-no-image-icon">
                        <i class="bi bi-image"></i>
                    </div>

                    <strong>
                        No Image
                    </strong>

                    <span>
                        This category doesn't have an image yet.
                    </span>

                </div>

                @endif

            </div>


            <div class="category-image-name">

                <span>
                    Category
                </span>

                <strong>
                    {{ $category->name }}
                </strong>

            </div>

        </div>



        {{-- =================================================
             INFORMATION
        ================================================== --}}

        <div class="category-information-card">

            <div class="category-card-header">

                <div class="category-card-title">

                    <div class="category-card-icon blue">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>

                        <h2>
                            Category Information
                        </h2>

                        <span>
                            General information about this category
                        </span>

                    </div>

                </div>

            </div>


            <div class="category-info-grid">


                {{-- Name --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-tag"></i>

                        Category Name

                    </span>

                    <strong>
                        {{ $category->name }}
                    </strong>

                </div>


                {{-- Parent --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-diagram-3"></i>

                        Parent Category

                    </span>

                    @if($category->parent)

                    <span class="category-parent-status">

                        <i class="bi bi-diagram-3-fill"></i>

                        {{ $category->parent->name }}

                    </span>

                    @else

                    <span class="category-main-status">

                        <i class="bi bi-grid-fill"></i>

                        Main Category

                    </span>

                    @endif

                </div>


                {{-- Products --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-box-seam"></i>

                        Products

                    </span>

                    <span class="category-products-count">

                        <i class="bi bi-box-seam-fill"></i>

                        {{ $category->products_count }}

                        <small>
                            products
                        </small>

                    </span>

                </div>


                {{-- Status --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-activity"></i>

                        Current Status

                    </span>

                    @if($category->status)

                    <span class="category-detail-status active">

                        <i class="bi bi-check-circle-fill"></i>

                        Active

                    </span>

                    @else

                    <span class="category-detail-status inactive">

                        <i class="bi bi-x-circle-fill"></i>

                        Inactive

                    </span>

                    @endif

                </div>


                {{-- Sort Order --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-sort-numeric-down"></i>

                        Sort Order

                    </span>

                    <strong>
                        #{{ $category->sort_order }}
                    </strong>

                </div>


                {{-- Created --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-calendar-plus"></i>

                        Created

                    </span>

                    <strong>
                        {{ $category->created_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $category->created_at->format('h:i A') }}
                    </small>

                </div>


                {{-- Updated --}}

                <div class="category-info-item">

                    <span class="category-info-label">

                        <i class="bi bi-clock-history"></i>

                        Last Updated

                    </span>

                    <strong>
                        {{ $category->updated_at->format('d M Y') }}
                    </strong>

                    <small>
                        {{ $category->updated_at->format('h:i A') }}
                    </small>

                </div>


            </div>

        </div>

    </div>



    {{-- =====================================================
         DESCRIPTION
    ====================================================== --}}

    <div class="category-description-card">

        <div class="category-card-header">

            <div class="category-card-title">

                <div class="category-card-icon purple">
                    <i class="bi bi-text-paragraph"></i>
                </div>

                <div>

                    <h2>
                        Description
                    </h2>

                    <span>
                        Category description and additional information
                    </span>

                </div>

            </div>

        </div>


        <div class="category-description-body">

            @if($category->description)

            <div class="category-description-content">

                {!! nl2br(e($category->description)) !!}

            </div>

            @else

            <div class="category-empty-description">

                <div>
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <span>
                    No description available for this category.
                </span>

            </div>

            @endif

        </div>

    </div>



    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <div class="category-summary-grid">


        {{-- Products --}}

        <div class="category-summary-card">

            <div class="category-summary-icon blue">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span>
                    Products
                </span>

                <strong>
                    {{ $category->products_count }}
                </strong>

            </div>

        </div>


        {{-- Parent --}}

        <div class="category-summary-card">

            <div class="category-summary-icon purple">
                <i class="bi bi-diagram-3-fill"></i>
            </div>

            <div>

                <span>
                    Parent
                </span>

                <strong>

                    {{ $category->parent?->name ?? 'Main Category' }}

                </strong>

            </div>

        </div>


        {{-- Status --}}

        <div class="category-summary-card">

            <div class="category-summary-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div>

                <span>
                    Status
                </span>

                <strong>
                    {{ $category->status ? 'Active' : 'Inactive' }}
                </strong>

            </div>

        </div>


        {{-- Sort Order --}}

        <div class="category-summary-card">

            <div class="category-summary-icon orange">
                <i class="bi bi-sort-numeric-down"></i>
            </div>

            <div>

                <span>
                    Sort Order
                </span>

                <strong>
                    #{{ $category->sort_order }}
                </strong>

            </div>

        </div>

    </div>

</div>

@endsection
