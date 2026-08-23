@extends('web.layouts.app')

@section('title', 'Brands')

@section('content')

<div class="brands-page">

    <div class="container py-5">

        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <header class="brands-header text-center">

            <span class="brands-eyebrow">
                <i class="bi bi-patch-check-fill"></i>
                OUR BRANDS
            </span>

            <h1>
                Shop by Brand
            </h1>

            <p>
                Discover products from trusted brands and find
                the technology that's right for you.
            </p>

        </header>


        {{-- =====================================================
            BRANDS GRID
        ====================================================== --}}

        <section class="brands-grid">

            <div class="row g-4">

                @forelse($brands as $brand)

                <div class="col-6 col-md-4 col-lg-3">

                    <a href="{{ route('brands.show', $brand) }}" class="brand-card-link">

                        <article class="brand-card">

                            {{-- Logo --}}

                            <div class="brand-card-logo">

                                @if($brand->logo_url)

                                <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" loading="lazy">

                                @else

                                <div class="brand-card-placeholder">
                                    <i class="bi bi-award"></i>
                                </div>

                                @endif

                            </div>


                            {{-- Info --}}

                            <div class="brand-card-content">

                                <h2>
                                    {{ $brand->name }}
                                </h2>

                                @if($brand->description)

                                <p>
                                    {{ Str::limit($brand->description, 65) }}
                                </p>

                                @endif

                                <span class="brand-card-products">

                                    {{ $brand->products_count }}

                                    {{ Str::plural('Product', $brand->products_count) }}

                                    <i class="bi bi-arrow-right"></i>

                                </span>

                            </div>

                        </article>

                    </a>

                </div>

                @empty

                <div class="col-12">

                    <div class="brands-empty">

                        <div class="brands-empty-icon">
                            <i class="bi bi-award"></i>
                        </div>

                        <h2>
                            No Brands Available
                        </h2>

                        <p>
                            We're currently adding new brands.
                            Please check back soon.
                        </p>

                    </div>

                </div>

                @endforelse

            </div>

        </section>

    </div>

</div>

@endsection
