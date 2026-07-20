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

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">Total Brands</small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['total'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">Active</small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['active'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">Inactive</small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['inactive'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- Search Card --}}
    <div class="card mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-10">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search brand...">

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Search

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

                        <th>Logo</th>

                        <th>Name</th>

                        <th>Status</th>

                        <th>Order</th>

                        <th>Created</th>

                        <th width="80"></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($brands as $brand)

                    <tr>

                        <td>

                            {{ $brand->id }}

                        </td>

                        <td>

                            @if($brand->logo)

                            <img src="{{ $brand->logo_url }}" class="rounded-circle" width="45" height="45" class="rounded" style="object-fit:cover">

                            @else

                            <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width:50px;height:50px;">

                                <i class="bi bi-image text-secondary"></i>

                            </div>

                            @endif

                        </td>

                        <td>

                            <strong>

                                {{ $brand->name }}

                            </strong>

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

                            {{ $brand->sort_order }}

                        </td>

                        <td>

                            {{ $brand->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a class="dropdown-item" href="{{ route('admin.brands.edit',$brand) }}">

                                            <i class="bi bi-pencil-square me-2"></i>

                                            Edit

                                        </a>

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.brands.destroy',$brand) }}" method="POST" class="delete-form">

                                            @csrf

                                            @method('DELETE')

                                            <button class="dropdown-item text-danger">

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

                                <i class="bi bi-folder display-3 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Brands Found

                                </h5>

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
