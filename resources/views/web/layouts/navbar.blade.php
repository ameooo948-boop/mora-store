<nav class="navbar navbar-expand-lg navbar-dark account-navbar">

    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
            <i class="bi bi-person-circle me-2"></i>
            My Account
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#accountNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse d-flex justify-content-between align-items-center">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="bi bi-bag-check me-1"></i>
                        Orders
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}" href="{{ route('wishlist.index') }}">
                        <i class="bi bi-heart me-1"></i>
                        Wishlist
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 me-1"></i>
                        Cart
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}" href="{{ route('addresses.index') }}">
                        <i class="bi bi-geo-alt me-1"></i>
                        Addresses
                    </a>
                </li>

            </ul>

            <div class="dropdown">

                <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">

                    {{ auth()->user()->name }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>
                            Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-lock me-2"></i>
                            Change Password
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>
