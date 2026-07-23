<footer class="footer">

    <div class="container">

        <div class="row align-items-center gy-3">

            <div class="col-md-6 text-center text-md-start">

                <h5 class="footer-logo mb-2">
                    <i class="bi bi-bag-fill me-2"></i>
                    E-Commerce
                </h5>

                <p class="mb-0 text-muted">
                    Shop smart with quality products and fast delivery.
                </p>

            </div>

            <div class="col-md-6 text-center text-md-end">

                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('cart.index') }}">Cart</a>
                <a href="{{ route('wishlist.index') }}">Wishlist</a>

            </div>

        </div>

        <hr>

        <div class="text-center footer-copy">

            © {{ date('Y') }} E-Commerce. All rights reserved.

        </div>

    </div>

</footer>
