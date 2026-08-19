<aside class="admin-sidebar" id="adminSidebar">

    {{-- =========================
         BRAND
    ========================== --}}
    <div class="admin-sidebar-brand">

        <a href="{{ route('admin.dashboard.index') }}" class="admin-brand">

            <div class="admin-brand-icon">
                <i class="bi bi-shop-window"></i>
            </div>

            <div class="admin-brand-text">

                <strong>
                    {{ setting('site_name') }}
                </strong>

                <span>
                    Administration
                </span>

            </div>

        </a>

    </div>


    {{-- =========================
         NAVIGATION
    ========================== --}}
    <div class="admin-sidebar-body">

        <div class="admin-menu-label">
            MAIN MENU
        </div>


        <ul class="admin-sidebar-menu">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard.index') }}" class="{{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Dashboard
                    </span>

                    @if(request()->routeIs('admin.dashboard.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>

        </ul>


        <div class="admin-menu-label">
            CATALOG
        </div>


        <ul class="admin-sidebar-menu">

            {{-- Categories --}}
            <li>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-grid-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Categories
                    </span>

                    @if(request()->routeIs('admin.categories.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>


            {{-- Brands --}}
            <li>
                <a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-tags-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Brands
                    </span>

                    @if(request()->routeIs('admin.brands.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>

            {{-- =========================
                BACK TO STORE
            ========================== --}}
            <li>

                <a href="{{ route('home') }}" class="admin-store-link">

                    <span class="admin-menu-icon">
                        <i class="bi bi-shop"></i>
                    </span>

                    <span class="admin-menu-text">
                        View Store
                    </span>

                    <i class="bi bi-arrow-up-right ms-auto"></i>

                </a>

            </li>


            {{-- Products --}}
            <li>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Products
                    </span>

                    @if(request()->routeIs('admin.products.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>


            {{-- Stock --}}
            <li>
                <a href="{{ route('admin.stock-movements.index') }}" class="{{ request()->routeIs('admin.stock-movements.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-arrow-left-right"></i>
                    </span>

                    <span class="admin-menu-text">
                        Stock Movements
                    </span>

                    @if(request()->routeIs('admin.stock-movements.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>

        </ul>


        <div class="admin-menu-label">
            SALES
        </div>


        <ul class="admin-sidebar-menu">

            {{-- Orders --}}
            <li>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-bag-check-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Orders
                    </span>

                    @if(request()->routeIs('admin.orders.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>


            {{-- Payments --}}
            <li>
                <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-credit-card-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Payments
                    </span>

                    @if(request()->routeIs('admin.payments.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>


            {{-- Coupons --}}
            <li>
                <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-ticket-perforated-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Coupons
                    </span>

                    @if(request()->routeIs('admin.coupons.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>

        </ul>


        <div class="admin-menu-label">
            MANAGEMENT
        </div>


        <ul class="admin-sidebar-menu">

            {{-- Users --}}
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-people-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Users
                    </span>

                    @if(request()->routeIs('admin.users.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>


            {{-- Reviews --}}
            <li>
                <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-star-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Reviews
                    </span>

                    @if(request()->routeIs('admin.reviews.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>

        </ul>


        <div class="admin-menu-label">
            SYSTEM
        </div>


        <ul class="admin-sidebar-menu">

            {{-- Settings --}}
            <li>
                <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">

                    <span class="admin-menu-icon">
                        <i class="bi bi-gear-fill"></i>
                    </span>

                    <span class="admin-menu-text">
                        Settings
                    </span>

                    @if(request()->routeIs('admin.settings.*'))
                    <span class="admin-active-dot"></span>
                    @endif

                </a>
            </li>

        </ul>

    </div>


    {{-- =========================
         FOOTER
    ========================== --}}
    <div class="admin-sidebar-footer">

        <div class="admin-panel-status">

            <span class="admin-status-dot"></span>

            <div>
                <strong>
                    System Online
                </strong>

                <small>
                    All systems operational
                </small>
            </div>

        </div>

    </div>

</aside>
