@extends('admin.layouts.app')

@section('title', 'Brands')

@section('page-title', 'Brands')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Brands

            </h3>

            <p class="text-muted mb-0">

                Manage all brands

            </p>

        </div>

        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">

            <i class="bi bi-plus-lg me-2"></i>

            Add Brand

        </a>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Total Brands

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['total'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Active

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['active'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Inactive

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['inactive'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        With Products

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $statistics['with_products'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- Search Card --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-8">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by brand name...">

                    </div>

                    <div class="col-md-2">

                        <select name="status" class="form-select">

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

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                Brands

            </h5>

            <small class="text-muted">

                Showing {{ $brands->total() }} Brands

            </small>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Logo</th>

                        <th>Brand</th>

                        <th>Products</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th class="text-center" width="80">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($brands as $brand)

                    <tr>

                        <td>

                            <span class="badge bg-light text-dark">

                                #{{ $brand->id }}

                            </span>

                        </td>

                        <td>

                            @if($brand->logo)

                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="rounded border" width="60" height="60" style="object-fit:cover;">

                            @else

                            <div class="border rounded d-flex align-items-center justify-content-center bg-light" style="width:60px;height:60px;">

                                <i class="bi bi-image text-secondary"></i>

                            </div>

                            @endif

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $brand->name }}

                            </div>

                            @if($brand->description)

                            <small class="text-muted">

                                {{ Str::limit($brand->description, 50) }}

                            </small>

                            @endif

                        </td>

                        <td>

                            @if($brand->products_count)

                            <span class="badge bg-primary">

                                {{ $brand->products_count }}

                            </span>

                            @else

                            <span class="badge bg-secondary">

                                0

                            </span>

                            @endif

                        </td>

                        <td>

                            @if($brand->status)

                            <span class="badge bg-success">

                                Active

                            </span>

                            @else

                            <span class="badge bg-danger">

                                Inactive

                            </span>

                            @endif

                        </td>

                        <td>

                            {{ $brand->created_at->format('Y-m-d') }}

                        </td>

                        <td class="text-center">

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.brands.show', $brand) }}" class="dropdown-item">

                                            <i class="bi bi-eye me-2"></i>

                                            View

                                        </a>

                                    </li>

                                    <li>

                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="dropdown-item">

                                            <i class="bi bi-pencil-square me-2"></i>

                                            Edit

                                        </a>

                                    </li>

                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="dropdown-item text-danger">

                                                <i class="bi bi-trash me-2"></i>

                                                Delete

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7">

                            <div class="text-center py-5">

                                <i class="bi bi-tags display-4 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Brands Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are no brands matching your search.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($brands->hasPages())

        <div class="card-footer">

            {{ $brands->links() }}

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

                title: 'Delete Brand?',

                text: "You won't be able to undo this action.",

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#dc3545',

                cancelButtonColor: '#6c757d',

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel'

            }).then((result) => {

                if (result.isConfirmed) {

                    form.submit();

                }

            });

        });

    });

</script>

@endpush

</div>

</div>

@endsection
