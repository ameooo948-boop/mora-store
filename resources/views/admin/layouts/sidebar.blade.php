<aside class="sidebar">

    <div class="sidebar-header">

        <i class="bi bi-shop-window"></i>

        <span>E-Commerce</span>

    </div>

    <ul class="sidebar-menu">

        <li>

            <a href="#">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">

                <i class="bi bi-grid"></i>

                Categories

            </a>

        </li>

        <li>

            <a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">

                <i class="bi bi-cart3"></i>

                Brands

            </a>

        </li>

        <li>

            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">

                <i class="bi bi-box-seam"></i>

                Products

            </a>

        </li>

        <li>

            {{-- <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"> --}}

                <i class="bi bi-cart3"></i>

                Orders

            </a>

        </li>

        <li>

            <a href="#">

                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('users.products.*') ? 'active' : '' }}">

                Users

            </a>

        </li>

        <li>

            <a href="#">

                <i class="bi bi-ticket-perforated"></i>

                Coupons

            </a>

        </li>

        <li>

            <a href="#">

                <i class="bi bi-gear"></i>

                Settings

            </a>

        </li>

    </ul>

</aside>
