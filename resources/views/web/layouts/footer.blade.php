<footer class="store-footer">

    <div class="container">

        {{-- =====================================================
            MAIN FOOTER
        ====================================================== --}}

        <div class="store-footer-main">

            {{-- Brand --}}

            <div class="store-footer-brand">

                <a href="{{ route('home') }}" class="store-footer-logo">

                    <span class="store-footer-logo-icon">

                        @if(!empty($siteLogo))

                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ setting('site_name') }}">

                        @else

                        <i class="bi bi-bag-check-fill"></i>

                        @endif

                    </span>

                    <span>
                        {{ setting('site_name') }}
                    </span>

                </a>


                <p>
                    Shop smarter with quality products,
                    trusted service, and a better shopping experience.
                </p>


                <div class="store-footer-trust">

                    <span>
                        <i class="bi bi-shield-check"></i>
                        Secure Shopping
                    </span>

                    <span>
                        <i class="bi bi-truck"></i>
                        Fast Delivery
                    </span>

                </div>

            </div>


            {{-- Quick Links --}}

            <div class="store-footer-column">

                <h3>
                    Quick Links
                </h3>

                <ul>

                    <li>
                        <a href="{{ route('home') }}">
                            <i class="bi bi-chevron-right"></i>
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('products.index') }}">
                            <i class="bi bi-chevron-right"></i>
                            Products
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}">
                            <i class="bi bi-chevron-right"></i>
                            Shopping Cart
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('wishlist.index') }}">
                            <i class="bi bi-chevron-right"></i>
                            Wishlist
                        </a>
                    </li>

                </ul>

            </div>


            {{-- Account --}}

            <div class="store-footer-column">

                <h3>
                    My Account
                </h3>

                <ul>

                    @auth

                    <li>
                        <a href="{{ route('profile.edit') }}">
                            <i class="bi bi-chevron-right"></i>
                            My Profile
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('orders.index') }}">
                            <i class="bi bi-chevron-right"></i>
                            My Orders
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('addresses.index') }}">
                            <i class="bi bi-chevron-right"></i>
                            Addresses
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('notifications.index') }}">
                            <i class="bi bi-chevron-right"></i>
                            Notifications
                        </a>
                    </li>

                    @else

                    <li>
                        <a href="{{ route('login') }}">
                            <i class="bi bi-chevron-right"></i>
                            Login
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('register') }}">
                            <i class="bi bi-chevron-right"></i>
                            Create Account
                        </a>
                    </li>

                    @endauth

                </ul>

            </div>


            {{-- Contact / Support --}}

            <div class="store-footer-column">

                <h3>
                    Need Help?
                </h3>

                <p class="store-footer-help">
                    We're here to make your shopping experience simple and easy.
                </p>


                <div class="store-footer-contact">

                    <div>

                        <span class="store-footer-contact-icon">
                            <i class="bi bi-headset"></i>
                        </span>

                        <span>
                            Customer Support
                        </span>

                    </div>

                    <div>

                        <span class="store-footer-contact-icon">
                            <i class="bi bi-clock"></i>
                        </span>

                        <span>
                            Available whenever you need us
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            BOTTOM
        ====================================================== --}}

        <div class="store-footer-bottom">

            <div>

                © {{ date('Y') }}

                <strong>
                    {{ setting('site_name') }}
                </strong>

                . All rights reserved.

            </div>


            <div class="store-footer-bottom-links">

                <span>
                    <i class="bi bi-shield-check"></i>
                    Secure & Trusted
                </span>

                <span>
                    <i class="bi bi-heart-fill"></i>
                    Made for shoppers
                </span>

            </div>

        </div>

    </div>

</footer>
