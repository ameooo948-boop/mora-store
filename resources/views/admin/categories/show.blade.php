@extends('admin.layouts.app')

@section('title', 'Category Details')

@section('page-title', 'Category Details')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Category Details

            </h4>

            <div>

                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit

                </a>

                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">

                    Back

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- Image --}}
                <div class="col-md-4">

                    @if($category->image)

                    <div class="border rounded p-3 bg-white text-center">

                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-fluid" style="max-height:300px;object-fit:contain;">

                    </div>

                    @else

                    <div class="border rounded bg-light d-flex justify-content-center align-items-center" style="height:300px;">

                        <div class="text-center">

                            <i class="bi bi-image display-4 text-secondary"></i>

                            <p class="text-muted mt-2">

                                No Image

                            </p>

                        </div>

                    </div>

                    @endif

                </div>

                {{-- Details --}}
                <div class="col-md-8">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Name

                            </label>

                            <div class="form-control bg-light">

                                {{ $category->name }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Parent Category

                            </label>

                            <div>

                                @if($category->parent)

                                <span class="badge bg-info fs-6">

                                    {{ $category->parent->name }}

                                </span>

                                @else

                                <span class="badge bg-secondary fs-6">

                                    Main Category

                                </span>

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Products

                            </label>

                            <div>

                                <span class="badge bg-primary fs-6">

                                    {{ $category->products_count }}

                                </span>

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Status

                            </label>

                            <div>

                                @if($category->status)

                                <span class="badge bg-success">

                                    Active

                                </span>

                                @else

                                <span class="badge bg-danger">

                                    Inactive

                                </span>

                                @endif

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Sort Order

                            </label>

                            <div class="form-control bg-light">

                                {{ $category->sort_order }}

                            </div>

                        </div>

                        <div class="col-12 mb-3">

                            <label class="fw-semibold">

                                Description

                            </label>

                            <div class="form-control bg-light" style="min-height:140px;">

                                {!! nl2br(e($category->description ?: 'No description available.')) !!}

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="fw-semibold">

                                Created At

                            </label>

                            <div class="form-control bg-light">

                                {{ $category->created_at->format('Y-m-d h:i A') }}

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="fw-semibold">

                                Updated At

                            </label>

                            <div class="form-control bg-light">

                                {{ $category->updated_at->format('Y-m-d h:i A') }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
