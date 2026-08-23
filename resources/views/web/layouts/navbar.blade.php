<nav class="navbar navbar-expand-lg account-navbar">
    <div class="container-fluid px-4 px-xl-5">

        <a class="navbar-brand account-brand" href="{{ route('home') }}">
            <div class="brand-logo">
                @if($siteLogo)
                <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ setting('site_name') }}">
                @else
                <i class="bi bi-bag-check-fill"></i>
                @endif
            </div>
            <span class="brand-name">{{ setting('site_name') }}</span>
        </a>

        <button class="navbar-toggler account-navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#accountNavbar" aria-controls="accountNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse account-navbar-collapse" id="accountNavbar">
            <div class="account-navbar-content">

                <ul class="account-nav-list">

                    <li>
                        <a href="{{ route('products.index') }}" class="account-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-box-seam"></i></span>
                            <span>Products</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('categories.index') }}" class="account-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-grid"></i></span>
                            <span>Categories</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('brands.index') }}" class="account-nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-tags"></i></span>
                            <span>Brands</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('orders.index') }}" class="account-nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-bag-check"></i></span>
                            <span>Orders</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('wishlist.index') }}" class="account-nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-heart"></i></span>
                            <span>Wishlist</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}" class="account-nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-cart3"></i></span>
                            <span>Cart</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('addresses.index') }}" class="account-nav-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}">
                            <span class="account-nav-icon"><i class="bi bi-geo-alt"></i></span>
                            <span>Addresses</span>
                        </a>
                    </li>

                </ul>

                <div class="account-nav-actions">

                    <div class="dropdown">
                        <button type="button" class="account-icon-btn" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                            <i class="bi bi-bell"></i>
                            @if(auth()->user()->unreadNotifications->count())
                            <span class="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </button>

                        <div class="dropdown-menu dropdown-menu-end account-notification-menu">

                            <div class="notification-menu-header">
                                <div>
                                    <span>ACCOUNT</span>
                                    <h3>Notifications</h3>
                                </div>

                                @if(auth()->user()->unreadNotifications->count())
                                <form action="{{ route('notifications.read-all') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="notification-read-all">
                                        <i class="bi bi-check2-all"></i>
                                        Read All
                                    </button>
                                </form>
                                @endif
                            </div>

                            <div class="notification-menu-list">
                                @forelse(auth()->user()->notifications->take(10) as $notification)
                                <div class="notification-menu-item {{ is_null($notification->read_at) ? 'unread' : '' }}">
                                    @if(is_null($notification->read_at))
                                    <span class="notification-live-dot"></span>
                                    @endif

                                    <div class="notification-menu-icon">
                                        <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }}"></i>
                                    </div>

                                    <div class="notification-menu-content">
                                        <a href="{{ $notification->data['url'] ?? route('notifications.index') }}" class="notification-menu-title">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </a>
                                        <p>{{ $notification->data['message'] ?? '' }}</p>
                                        <span class="notification-menu-time">
                                            <i class="bi bi-clock"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if(is_null($notification->read_at))
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="notification-mark-read" title="Mark as read">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                    @else
                                    <i class="bi bi-check2-all notification-read-icon"></i>
                                    @endif
                                </div>
                                @empty
                                <div class="notification-empty">
                                    <i class="bi bi-bell-slash"></i>
                                    <strong>No Notifications</strong>
                                    <span>You're all caught up.</span>
                                </div>
                                @endforelse
                            </div>

                            <a href="{{ route('notifications.index') }}" class="notification-menu-footer">
                                View All Notifications
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button type="button" class="account-user-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="account-user-avatar">
                            <span class="account-user-name">{{ auth()->user()->name }}</span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end account-user-menu">
                            @if(auth()->user()->hasRole('admin'))
                            <li>
                                <a href="{{ route('admin.dashboard.index') }}" class="dropdown-item">
                                    <i class="bi bi-speedometer2"></i>
                                    Admin Dashboard
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @endif

                            <li>
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="bi bi-person"></i>
                                    Profile
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
