<aside class="sidebar">

    <div class="sidebar-header">
        <i class="bi bi-shop-window"></i>
        <span>{{ setting('site_name') }}</span>
    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('admin.dashboard.index') }}" class="{{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>Categories</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Brands</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Products</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i>
                <span>Orders</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                <span>Payments</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.stock-movements.index') }}" class="{{ request()->routeIs('admin.stock-movements.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i>
                <span>Stock Movements</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i>
                <span>Coupons</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <i class="bi bi-star"></i>
                <span>Reviews</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>

    </ul>

</aside>
