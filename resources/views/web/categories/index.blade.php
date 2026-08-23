@extends('web.layouts.app')

@section('title', 'Categories')

@section('content')

<div class="categories-page">

    <div class="container py-5">

        {{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <header class="categories-header text-center mb-5">

            <span class="text-uppercase text-muted small fw-semibold">
                Explore Our Store
            </span>

            <h1 class="display-5 fw-bold mt-2 mb-3">
                Shop by Category
            </h1>

            <p class="text-muted mx-auto mb-0" style="max-width: 650px;">
                Discover everything you need from electronics, devices,
                accessories and home appliances.
            </p>

        </header>


        {{-- =====================================================
            CATEGORIES GRID
        ====================================================== --}}

        <section class="categories-grid">

            <div class="row g-4">

                @forelse($categories as $category)

                <div class="col-12 col-sm-6 col-lg-4">

                    <article class="category-card h-100">

                        <a href="{{ route('categories.show', $category) }}" class="text-decoration-none d-block h-100">

                            {{-- =================================================
                                    CATEGORY IMAGE
                                ================================================== --}}

                            <div class="category-card-image">

                                @if($category->image_url)

                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy">

                                @else

                                <div class="category-placeholder" aria-label="{{ $category->name }}">
                                    <i class="bi bi-grid"></i>
                                </div>

                                @endif


                                {{-- Overlay --}}

                                <div class="category-card-overlay"></div>


                                {{-- Category Content --}}

                                <div class="category-card-content">

                                    <h2>
                                        {{ $category->name }}
                                    </h2>

                                    @if($category->description)

                                    <p>
                                        {{ Str::limit($category->description, 90) }}
                                    </p>

                                    @endif

                                    <span class="category-explore">

                                        Explore Category

                                        <i class="bi bi-arrow-right"></i>

                                    </span>

                                </div>

                            </div>


                            {{-- =================================================
                                    SUBCATEGORIES
                                ================================================== --}}

                            @if($category->children->isNotEmpty())

                            <div class="category-subcategories">

                                @foreach($category->children->take(4) as $child)

                                <span>
                                    {{ $child->name }}
                                </span>

                                @endforeach


                                @if($category->children->count() > 4)

                                <span class="more">
                                    +{{ $category->children->count() - 4 }}
                                    more
                                </span>

                                @endif

                            </div>

                            @endif

                        </a>

                    </article>

                </div>

                @empty

                {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}

                <div class="col-12">

                    <div class="text-center py-5">

                        <div class="mb-3">

                            <i class="bi bi-grid display-4 text-muted"></i>

                        </div>

                        <h2 class="h4 fw-bold">
                            No Categories Available
                        </h2>

                        <p class="text-muted mb-0">
                            There are no categories available right now.
                            Please check back later.
                        </p>

                    </div>

                </div>

                @endforelse

            </div>

        </section>

    </div>

</div>

@endsection
