<div class="card h-100 shadow-sm border-0">

    <div class="position-relative">

        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="position-absolute top-0 end-0 m-2" style="z-index: 10;">

            @csrf

            <button type="submit" class="btn btn-light rounded-circle shadow-sm">

                <i class="bi {{ $product->is_in_wishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>

            </button>

        </form>

        <div class="position-absolute p-2">

            @if($product->has_discount)

            <span class="badge bg-danger">

                -{{ $product->discount_percentage }}%

            </span>

            @endif

        </div>

        <a href="{{ route('products.show', $product) }}">

            @if($product->images->isNotEmpty())

            <img src="{{ $product->images->first()->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height:250px;object-fit:cover;">

            @else

            <div class="bg-light d-flex justify-content-center align-items-center" style="height:250px;">

                <i class="bi bi-image fs-1"></i>

            </div>

            @endif

        </a>


    </div>

    <div class="card-body d-flex flex-column">

        <small class="text-muted">

            {{ $product->category->name }}

        </small>

        <h5>

            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">

                {{ $product->name }}

            </a>

        </h5>

        @if($product->has_discount)

        <div class="mb-2">

            <span class="text-muted text-decoration-line-through">

                {{ number_format($product->price, 2) }}

                EGP

            </span>

        </div>

        <h5 class="fw-bold text-danger">

            {{ number_format($product->final_price, 2) }}

            EGP

        </h5>

        @else

        <h5 class="fw-bold">

            {{ number_format($product->price, 2) }}

            EGP

        </h5>

        @endif

        @if($product->quantity == 0)

        <small class="text-danger">

            Out of Stock

        </small>

        @elseif($product->quantity <= 5) <small class="text-warning fw-semibold">

            Only {{ $product->quantity }} left

            </small>

            @else

            <small class="text-success">

                In Stock

            </small>

            @endif

            <div class="mt-auto d-grid">

                <form action="{{ route('cart.store', $product) }}" method="POST">

                    @csrf

                    <input type="hidden" name="quantity" value="1">

                    <button type="submit" class="btn btn-primary w-100">

                        <i class="bi bi-cart-plus me-2"></i>

                        Add To Cart

                    </button>

                </form>

            </div>

    </div>

</div>
