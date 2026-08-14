@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')

<div class="categories-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="categories-hero">

        <div class="categories-hero-content">

            <div class="categories-hero-icon">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>

            <div>

                <span class="categories-eyebrow">
                    CATALOG MANAGEMENT
                </span>

                <h1>
                    Categories
                </h1>

                <p>
                    Organize and manage your product categories.
                </p>

            </div>

        </div>


        <a href="{{ route('admin.categories.create') }}" class="categories-add-btn">

            <i class="bi bi-plus-lg"></i>

            Add Category

        </a>

    </div>



    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="categories-stats">


        <div class="category-stat-card">

            <div class="category-stat-icon blue">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>

            <div>

                <span>
                    Total Categories
                </span>

                <strong>
                    {{ $statistics['total'] }}
                </strong>

            </div>

        </div>


        <div class="category-stat-card">

            <div class="category-stat-icon green">
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


        <div class="category-stat-card">

            <div class="category-stat-icon red">
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


        <div class="category-stat-card">

            <div class="category-stat-icon purple">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div>

                <span>
                    With Products
                </span>

                <strong>
                    {{ $statistics['with_products'] }}
                </strong>

            </div>

        </div>


        <div class="category-stat-card">

            <div class="category-stat-icon orange">
                <i class="bi bi-diagram-3-fill"></i>
            </div>

            <div>

                <span>
                    Main Categories
                </span>

                <strong>
                    {{ $statistics['main'] }}
                </strong>

            </div>

        </div>

    </div>



    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="categories-filter-card">

        <div class="categories-filter-header">

            <div class="categories-filter-title">

                <div class="categories-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>

                    <h2>
                        Search & Filter
                    </h2>

                    <span>
                        Find categories quickly
                    </span>

                </div>

            </div>


            @if(request()->hasAny(['search', 'status']) &&
            (request('search') !== null || request('status') !== null))

            <a href="{{ route('admin.categories.index') }}" class="categories-reset-btn">

                <i class="bi bi-arrow-counterclockwise"></i>

                Reset

            </a>

            @endif

        </div>


        <form method="GET">

            <div class="categories-filter-body">


                {{-- Search --}}

                <div class="categories-search">

                    <label for="category-search">
                        Search Categories
                    </label>

                    <div class="category-search-input">

                        <i class="bi bi-search"></i>

                        <input id="category-search" type="text" name="search" value="{{ request('search') }}" placeholder="Search by category name...">

                    </div>

                </div>


                {{-- Status --}}

                <div class="categories-status-filter">

                    <label for="category-status-filter">
                        Status
                    </label>

                    <div class="category-search-input">

                        <i class="bi bi-activity"></i>

                        <select id="category-status-filter" name="status">

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


                {{-- Submit --}}

                <button type="submit" class="categories-filter-btn">

                    <i class="bi bi-search"></i>

                    Apply Filters

                </button>

            </div>

        </form>

    </div>



    {{-- =====================================================
         CATEGORIES TABLE
    ====================================================== --}}

    <div class="categories-table-card">


        <div class="categories-table-header">

            <div>

                <span class="categories-table-eyebrow">
                    CATEGORY DIRECTORY
                </span>

                <h2>
                    All Categories
                </h2>

            </div>


            <div class="categories-count">

                <i class="bi bi-grid"></i>

                {{ $categories->total() }}

                <span>
                    categories
                </span>

            </div>

        </div>


        <div class="table-responsive">

            <table class="categories-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Parent
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Created
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($categories as $category)

                    <tr>


                        {{-- ID --}}

                        <td>

                            <span class="category-id">
                                #{{ $category->id }}
                            </span>

                        </td>


                        {{-- Category --}}

                        <td>

                            <div class="category-product-cell">

                                <div class="category-image">

                                    @if($category->image)

                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}">

                                    @else

                                    <div class="category-image-empty">
                                        <i class="bi bi-image"></i>
                                    </div>

                                    @endif

                                </div>


                                <div class="category-main-info">

                                    <strong>
                                        {{ $category->name }}
                                    </strong>

                                    @if($category->description)

                                    <span>
                                        {{ \Illuminate\Support\Str::limit($category->description, 55) }}
                                    </span>

                                    @else

                                    <span class="category-no-description">
                                        No description
                                    </span>

                                    @endif

                                </div>

                            </div>

                        </td>


                        {{-- Parent --}}

                        <td>

                            @if($category->parent)

                            <span class="category-parent-badge">

                                <i class="bi bi-diagram-3"></i>

                                {{ $category->parent->name }}

                            </span>

                            @else

                            <span class="category-main-badge">

                                <i class="bi bi-grid"></i>

                                Main Category

                            </span>

                            @endif

                        </td>


                        {{-- Products --}}

                        <td>

                            <span class="category-products-badge">

                                <i class="bi bi-box-seam"></i>

                                {{ $category->products_count ?? 0 }}

                            </span>

                        </td>


                        {{-- Status --}}

                        <td>

                            @if($category->status)

                            <span class="category-status active">

                                <i class="bi bi-check-circle-fill"></i>

                                Active

                            </span>

                            @else

                            <span class="category-status inactive">

                                <i class="bi bi-x-circle-fill"></i>

                                Inactive

                            </span>

                            @endif

                        </td>


                        {{-- Sort Order --}}

                        <td>

                            <span class="category-order">
                                #{{ $category->sort_order }}
                            </span>

                        </td>


                        {{-- Created --}}

                        <td>

                            <div class="category-date">

                                <strong>
                                    {{ $category->created_at->format('d M Y') }}
                                </strong>

                                <span>
                                    {{ $category->created_at->format('h:i A') }}
                                </span>

                            </div>

                        </td>


                        {{-- Actions --}}

                        <td>

                            <div class="category-actions">

                                <a href="{{ route('admin.categories.show', $category) }}" class="category-action-show" title="View Category">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.categories.edit', $category) }}" class="category-action-edit" title="Edit Category">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="m-0 delete-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="category-action-delete" title="Delete Category">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8">

                            <div class="categories-empty">

                                <div class="categories-empty-icon">

                                    <i class="bi bi-folder2-open"></i>

                                </div>

                                <h3>
                                    No Categories Found
                                </h3>

                                <p>
                                    There are no categories matching your current filters.
                                </p>

                                <a href="{{ route('admin.categories.create') }}" class="categories-empty-btn">

                                    <i class="bi bi-plus-lg"></i>

                                    Create Category

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}

        @if($categories->hasPages())

        <div class="categories-pagination">

            {{ $categories->links() }}

        </div>

        @endif

    </div>

</div>


{{-- =========================================================
     DELETE CONFIRMATION
========================================================= --}}

@push('scripts')

<script>
    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function(e) {

            e.preventDefault();

            Swal.fire({

                title: 'Delete Category?',

                text: "You won't be able to undo this action.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#dc3545',

                cancelButtonColor: '#64748b',

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel',

                reverseButtons: true,

                customClass: {

                    popup: 'premium-swal'

                }

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
