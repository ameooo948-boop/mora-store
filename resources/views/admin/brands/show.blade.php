@extends('admin.layouts.app')

@section('title', 'Brand Details')

@section('page-title', 'Brand Details')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Brand Details

            </h4>

            <div>

                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning">

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit

                </a>

                <a href="{{ route('admin.brands.index') }}" class="btn btn-light">

                    Back

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- Logo --}}
                <div class="col-md-4">

                    @if($brand->logo)

                    <div class="border rounded p-3 bg-white text-center">

                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="img-fluid" style="max-height:300px;object-fit:contain;">

                    </div>

                    @else

                    <div class="border rounded bg-light d-flex justify-content-center align-items-center" style="height:300px;">

                        <div class="text-center">

                            <i class="bi bi-image display-4 text-secondary"></i>

                            <p class="text-muted mt-2">

                                No Logo

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

                                {{ $brand->name }}

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Products

                            </label>

                            <div>

                                <span class="badge bg-primary fs-6">

                                    {{ $brand->products_count }}

                                </span>

                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Status

                            </label>

                            <div>

                                @if($brand->status)

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

                        @if(isset($brand->sort_order))

                        <div class="col-md-6 mb-3">

                            <label class="fw-semibold">

                                Sort Order

                            </label>

                            <div class="form-control bg-light">

                                {{ $brand->sort_order }}

                            </div>

                        </div>

                        @endif

                        <div class="col-12 mb-3">

                            <label class="fw-semibold">

                                Description

                            </label>

                            <div class="form-control bg-light" style="min-height:140px;">

                                {!! nl2br(e($brand->description ?: 'No description available.')) !!}

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="fw-semibold">

                                Created At

                            </label>

                            <div class="form-control bg-light">

                                {{ $brand->created_at->format('Y-m-d h:i A') }}

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="fw-semibold">

                                Updated At

                            </label>

                            <div class="form-control bg-light">

                                {{ $brand->updated_at->format('Y-m-d h:i A') }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
