@extends('admin.layouts.app')

@section('title', 'Reviews')

@section('page-title', 'Reviews')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Reviews

            </h3>

            <p class="text-muted mb-0">

                Manage customer reviews

            </p>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Total Reviews

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['total'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Pending

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $statistics['pending'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Approved

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $statistics['approved'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Rejected

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['rejected'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-6">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by customer or product...">

                    </div>

                    <div class="col-md-3">

                        <select name="status" class="form-select">

                            <option value="">

                                All Statuses

                            </option>

                            @foreach($statuses as $status)

                            <option value="{{ $status->value }}" @selected(request('status')==$status->value)
                                >

                                {{ $status->label() }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                Reviews

            </h5>

            <small class="text-muted">

                Showing {{ $reviews->total() }} Reviews

            </small>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Customer</th>

                        <th>Product</th>

                        <th>Rating</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th width="80" class="text-center">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($reviews as $review)

                    <tr>

                        <td>

                            <span class="badge bg-light text-dark">

                                #{{ $review->id }}

                            </span>

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $review->user->name }}

                            </div>

                            <small class="text-muted">

                                {{ $review->user->email }}

                            </small>

                        </td>

                        <td>

                            {{ $review->product->name }}

                        </td>

                        <td>

                            @for($i = 1; $i <= 5; $i++) @if($i <=$review->rating)

                                <i class="bi bi-star-fill text-warning"></i>

                                @else

                                <i class="bi bi-star text-secondary"></i>

                                @endif

                                @endfor

                        </td>

                        <td>

                            <span class="badge bg-{{ $review->status->badge() }}">

                                {{ $review->status->label() }}

                            </span>

                        </td>

                        <td>

                            {{ $review->created_at->format('M d, Y') }}

                        </td>

                        <td class="text-center">

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.reviews.show', $review) }}" class="dropdown-item">

                                            <i class="bi bi-eye me-2"></i>

                                            View

                                        </a>

                                    </li>

                                    @if($review->status === \App\Enums\ReviewStatus::Pending)

                                    <li>

                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button class="dropdown-item text-success">

                                                <i class="bi bi-check-circle me-2"></i>

                                                Approve

                                            </button>

                                        </form>

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button class="dropdown-item text-danger">

                                                <i class="bi bi-x-circle me-2"></i>

                                                Reject

                                            </button>

                                        </form>

                                    </li>

                                    @endif

                                </ul>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7">

                            <div class="text-center py-5">

                                <i class="bi bi-chat-square-text display-4 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Reviews Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are no reviews matching your search.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($reviews->hasPages())

        <div class="card-footer">

            {{ $reviews->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
