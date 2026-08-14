@extends('admin.layouts.app')

@section('title', 'Brands')
@section('page-title', 'Brands')

@section('content')

<div class="brands-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="brands-hero">

        <div class="brands-hero-content">

            <div class="brands-hero-icon">
                <i class="bi bi-tags-fill"></i>
            </div>

            <div>

                <span class="brands-eyebrow">
                    CATALOG MANAGEMENT
                </span>

                <h1>
                    Brands
                </h1>

                <p>
                    Manage your store brands and keep your catalog organized.
                </p>

            </div>

        </div>


        <a href="{{ route('admin.brands.create') }}" class="brands-add-btn">

            <i class="bi bi-plus-lg"></i>

            <span>
                Add Brand
            </span>

        </a>

    </div>



    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="brands-stat-grid">


        {{-- Total --}}

        <div class="brands-stat-card">

            <div class="brands-stat-icon blue">
                <i class="bi bi-tags-fill"></i>
            </div>

            <div class="brands-stat-info">

                <span>
                    Total Brands
                </span>

                <strong>
                    {{ $statistics['total'] }}
                </strong>

            </div>

            <div class="brands-stat-decoration"></div>

        </div>


        {{-- Active --}}

        <div class="brands-stat-card">

            <div class="brands-stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="brands-stat-info">

                <span>
                    Active
                </span>

                <strong>
                    {{ $statistics['active'] }}
                </strong>

            </div>

            <div class="brands-stat-decoration"></div>

        </div>


        {{-- Inactive --}}

        <div class="brands-stat-card">

            <div class="brands-stat-icon red">
                <i class="bi bi-pause-circle-fill"></i>
            </div>

            <div class="brands-stat-info">

                <span>
                    Inactive
                </span>

                <strong>
                    {{ $statistics['inactive'] }}
                </strong>

            </div>

            <div class="brands-stat-decoration"></div>

        </div>


        {{-- Products --}}

        <div class="brands-stat-card">

            <div class="brands-stat-icon purple">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <div class="brands-stat-info">

                <span>
                    With Products
                </span>

                <strong>
                    {{ $statistics['with_products'] }}
                </strong>

            </div>

            <div class="brands-stat-decoration"></div>

        </div>

    </div>



    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="brands-filter-card">

        <div class="brands-filter-header">

            <div class="brands-filter-title">

                <div class="brands-filter-icon">
                    <i class="bi bi-funnel-fill"></i>
                </div>

                <div>

                    <h3>
                        Find Brands
                    </h3>

                    <span>
                        Search and filter your catalog
                    </span>

                </div>

            </div>

            @if(request('search') || request('status') !== null)

            <a href="{{ route('admin.brands.index') }}" class="brands-clear-btn">
                <i class="bi bi-x-lg"></i>
                Clear filters
            </a>

            @endif

        </div>


        <form method="GET">

            <div class="brands-filter-body">


                {{-- Search --}}

                <div class="brands-search">

                    <label>
                        Search
                    </label>

                    <div class="brands-input-wrap">

                        <i class="bi bi-search"></i>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by brand name...">

                    </div>

                </div>


                {{-- Status --}}

                <div class="brands-status-filter">

                    <label>
                        Status
                    </label>

                    <select name="status" class="brands-select">

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


                {{-- Submit --}}

                <button type="submit" class="brands-filter-btn">

                    <i class="bi bi-search"></i>

                    <span>
                        Apply Filters
                    </span>

                </button>

            </div>

        </form>

    </div>



    {{-- =====================================================
         BRANDS TABLE
    ====================================================== --}}

    <div class="brands-table-card">


        {{-- Header --}}

        <div class="brands-table-header">

            <div>

                <div class="brands-table-title">

                    <div class="brands-table-title-icon">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </div>

                    <div>

                        <h2>
                            All Brands
                        </h2>

                        <span>
                            {{ $brands->total() }} total brands
                        </span>

                    </div>

                </div>

            </div>


            <div class="brands-result-count">

                <i class="bi bi-database"></i>

                Showing
                <strong>
                    {{ $brands->count() }}
                </strong>
                results

            </div>

        </div>



        {{-- Table --}}

        <div class="table-responsive">

            <table class="brands-table">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Brand
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Status
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

                    @forelse($brands as $brand)

                    <tr>


                        {{-- ID --}}

                        <td>

                            <span class="brand-id">
                                #{{ $brand->id }}
                            </span>

                        </td>



                        {{-- Brand --}}

                        <td>

                            <div class="brand-cell">


                                @if($brand->logo)

                                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="brand-logo">

                                @else

                                <div class="brand-logo-placeholder">

                                    <i class="bi bi-image"></i>

                                </div>

                                @endif


                                <div class="brand-details">

                                    <strong>
                                        {{ $brand->name }}
                                    </strong>

                                    @if($brand->description)

                                    <span>
                                        {{ Str::limit($brand->description, 55) }}
                                    </span>

                                    @else

                                    <span class="no-description">
                                        No description
                                    </span>

                                    @endif

                                </div>

                            </div>

                        </td>



                        {{-- Products --}}

                        <td>

                            @if($brand->products_count)

                            <span class="products-count">

                                <i class="bi bi-box-seam"></i>

                                {{ $brand->products_count }}

                            </span>

                            @else

                            <span class="products-count empty">

                                <i class="bi bi-box"></i>

                                0

                            </span>

                            @endif

                        </td>



                        {{-- Status --}}

                        <td>

                            @if($brand->status)

                            <span class="brand-status active">

                                <i class="bi bi-check-circle-fill"></i>

                                Active

                            </span>

                            @else

                            <span class="brand-status inactive">

                                <i class="bi bi-x-circle-fill"></i>

                                Inactive

                            </span>

                            @endif

                        </td>



                        {{-- Date --}}

                        <td>

                            <div class="brand-date">

                                <strong>
                                    {{ $brand->created_at->format('d M Y') }}
                                </strong>

                                <span>
                                    {{ $brand->created_at->format('H:i') }}
                                </span>

                            </div>

                        </td>



                        {{-- Actions --}}

                        <td>

                            <div class="brand-actions">

                                <a href="{{ route('admin.brands.show', $brand) }}" class="brand-action view" title="View Brand">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a href="{{ route('admin.brands.edit', $brand) }}" class="brand-action edit" title="Edit Brand">

                                    <i class="bi bi-pencil-square"></i>

                                </a>


                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="delete-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="brand-action delete" title="Delete Brand">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6">

                            <div class="brands-empty">

                                <div class="brands-empty-icon">
                                    <i class="bi bi-tags"></i>
                                </div>

                                <h3>
                                    No Brands Found
                                </h3>

                                <p>
                                    There are no brands matching your current filters.
                                </p>

                                <a href="{{ route('admin.brands.create') }}" class="brands-empty-btn">

                                    <i class="bi bi-plus-lg"></i>

                                    Add Your First Brand

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>



        {{-- Pagination --}}

        @if($brands->hasPages())

        <div class="brands-pagination">

            <div>

                Showing
                <strong>
                    {{ $brands->firstItem() }}
                </strong>

                –
                <strong>
                    {{ $brands->lastItem() }}
                </strong>

                of
                <strong>
                    {{ $brands->total() }}
                </strong>

            </div>

            <div>
                {{ $brands->links() }}
            </div>

        </div>

        @endif

    </div>

</div>

@endsection



@push('scripts')

<script>
    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function(e) {

            e.preventDefault();

            Swal.fire({

                title: 'Delete Brand?',

                text: "This action cannot be undone.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#dc2626',

                cancelButtonColor: '#64748b',

                confirmButtonText: '<i class="bi bi-trash3 me-1"></i> Delete Brand',

                cancelButtonText: 'Cancel',

                reverseButtons: true,

                buttonsStyling: true,

                customClass: {

                    popup: 'premium-swal',

                    confirmButton: 'premium-swal-confirm',

                    cancelButton: 'premium-swal-cancel'

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
