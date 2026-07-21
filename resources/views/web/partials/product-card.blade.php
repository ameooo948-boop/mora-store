<div class="card h-100 shadow-sm border-0">

    <div class="position-relative">

        @if($product->images->isNotEmpty())

        <img src="{{ $product->images->first()->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height:250px; object-fit:cover;">

        @else

        <div class="bg-light d-flex justify-content-center align-items-center" style="height:250px;">

            <i class="bi bi-image fs-1 text-secondary"></i>

        </div>

        @endif

    </div>

    <div class="card-body d-flex flex-column">

        <small class="text-muted">

            {{ $product->category->name }}

        </small>

        <h5 class="mt-2">

            {{ $product->name }}

        </h5>

        <div class="mb-3">

            <strong class="text-primary fs-5">

                ${{ number_format($product->price, 2) }}

            </strong>

        </div>

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
