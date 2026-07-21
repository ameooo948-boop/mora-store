@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title mb-0">

            Product Details

        </h3>

        <div>

            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">

                <i class="bi bi-pencil-square"></i>

                Edit

            </a>

            <a href="{{ route('admin.products.index') }}" class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    <div class="card-body">

        <div class="row">

            {{-- Product Images --}}
            <div class="col-md-4">

                @if($product->images->isNotEmpty())

                <div class="border rounded p-2 text-center bg-white">

                    <img id="main-image" src="{{ Storage::url($product->images->first()->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="height:350px; width:100%; object-fit:contain;">

                </div>

                <div class="d-flex flex-wrap gap-2 mt-3">

                    @foreach($product->images as $image)

                    <img src="{{ Storage::url($image->image) }}" class="img-thumbnail product-thumbnail" style="width:70px; height:70px; object-fit:cover; cursor:pointer;" onclick="changeImage(this)">

                    @endforeach

                </div>

                @else

                <div class="border rounded d-flex align-items-center justify-content-center bg-light" style="height:350px;">

                    <span class="text-muted">

                        No Image Available

                    </span>

                </div>

                @endif

            </div>

            <div class="col-md-8">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">

                            Name

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->name }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">

                            SKU

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->sku }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">

                            Category

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->category->name }}

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-semibold">

                            Brand

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->brand->name }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-semibold">

                            Price

                        </label>

                        <div class="form-control bg-light">

                            {{ number_format($product->price, 2) }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-semibold">

                            Sale Price

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->sale_price ? number_format($product->sale_price, 2) : '-' }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-semibold">

                            Stock

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->quantity }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-semibold">

                            Status

                        </label>

                        <div>

                            @if($product->status)

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

                    <div class="col-md-4 mb-3">

                        <label class="fw-semibold">

                            Featured

                        </label>

                        <div>

                            @if($product->is_featured)

                            <span class="badge bg-primary">

                                Yes

                            </span>

                            @else

                            <span class="badge bg-secondary">

                                No

                            </span>

                            @endif

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-semibold">

                            Sort Order

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->sort_order }}

                        </div>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="fw-semibold">

                            Description

                        </label>

                        <div class="form-control bg-light" style="min-height:120px">

                            {!! nl2br(e($product->description)) !!}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="fw-semibold">

                            Created At

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->created_at->format('Y-m-d h:i A') }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="fw-semibold">

                            Updated At

                        </label>

                        <div class="form-control bg-light">

                            {{ $product->updated_at->format('Y-m-d h:i A') }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script>
    function changeImage(image) {
        document
            .getElementById('main-image')
            .src = image.src;
    }

</script>

@endpush

@endsection
