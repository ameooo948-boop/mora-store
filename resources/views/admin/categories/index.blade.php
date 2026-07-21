@extends('admin.layouts.app')

@section('title', 'Categories')

@section('page-title', 'Categories')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Categories

            </h3>

            <p class="text-muted mb-0">

                Manage all categories

            </p>

        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">

            <i class="bi bi-plus-lg me-2"></i>

            Add Category

        </a>

    </div>

    <div class="row mb-4">

        <div class="col">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <small class="text-muted">

                        Total Categories

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['total'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <small class="text-muted">

                        Active

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['active'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <small class="text-muted">

                        Inactive

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['inactive'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <small class="text-muted">

                        With Products

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $statistics['with_products'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <small class="text-muted">

                        Main Categories

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $statistics['main'] }}

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

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by category name...">

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
    <div class="card">

        <div class="table-responsive">

            <table class="table align-middle table-hover mb-0">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Parent</th>

                        <th>Status</th>

                        <th>Order</th>

                        <th>Created</th>

                        <th width="80"></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($categories as $category)

                    <tr>

                        <td>

                            <span class="badge bg-light text-dark">

                                #{{ $category->id }}

                            </span>

                        </td>

                        <td>

                            @if($category->image)

                            <img src="{{ $category->image_url }}" class="rounded border" width="60" height="60" style="object-fit:cover;" alt="{{ $category->name }}">

                            @else

                            <div class="border rounded d-flex align-items-center justify-content-center bg-light" style="width:60px;height:60px;">

                                <i class="bi bi-image text-secondary"></i>

                            </div>

                            @endif

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $category->name }}

                            </div>

                            @if($category->description)

                            <small class="text-muted">

                                {{ \Illuminate\Support\Str::limit($category->description, 50) }}

                            </small>

                            @endif

                        </td>

                        <td>

                            @if($category->parent)

                            <span class="badge bg-info">

                                {{ $category->parent->name }}

                            </span>

                            @else

                            <span class="badge bg-secondary">

                                Main Category

                            </span>

                            @endif

                        </td>

                        <td>

                            @if($category->status)

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

                            <span class="badge bg-dark">

                                {{ $category->sort_order }}

                            </span>

                        </td>

                        <td>

                            {{ $category->created_at->format('Y-m-d') }}

                        </td>

                        <td class="text-center">

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.categories.show', $category) }}" class="dropdown-item">

                                            <i class="bi bi-eye me-2"></i>

                                            View

                                        </a>

                                    </li>

                                    <li>

                                        <a href="{{ route('admin.categories.edit', $category) }}" class="dropdown-item">

                                            <i class="bi bi-pencil-square me-2"></i>

                                            Edit

                                        </a>

                                    </li>

                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form">

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

                        <td colspan="8">

                            <div class="text-center py-5">

                                <i class="bi bi-folder display-4 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Categories Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are no categories matching your search.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            @if($categories->hasPages())

            <div class="card-footer">

                {{ $categories->links() }}

            </div>

            @endif

        </div>

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
