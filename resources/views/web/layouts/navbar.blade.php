<nav class="navbar navbar-expand-lg navbar-dark account-navbar">

    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
            <i class="bi bi-person-circle me-2"></i>
            {{ setting('site_name') }}
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

            <div class="d-flex align-items-center gap-3">

                <div class="dropdown">
                    <a class="btn btn-outline-light position-relative" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell fs-5"></i>

                        @if(auth()->user()->unreadNotifications->count())
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0" style="width:380px;border-radius:12px;overflow:hidden;">

                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom">
                            <strong>
                                Notifications
                                ({{ auth()->user()->unreadNotifications->count() }})
                            </strong>

                            @if(auth()->user()->unreadNotifications->count())
                            <form action="{{ route('notifications.read-all') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-link text-decoration-none p-0">
                                    Read All
                                </button>
                            </form>
                            @endif
                        </div>

                        {{-- Notifications --}}
                        <div style="max-height:400px;overflow-y:auto;">

                            @forelse(auth()->user()->notifications->take(10) as $notification)

                            <div class="border-bottom">

                                <div class="d-flex justify-content-between align-items-start px-3 py-3 {{ is_null($notification->read_at) ? 'bg-light' : '' }}">

                                    <a href="{{ $notification->data['url'] }}" class="text-decoration-none text-dark flex-grow-1">

                                        <div class="fw-semibold">
                                            {{ $notification->data['title'] }}
                                        </div>

                                        <small class="text-muted d-block">
                                            {{ $notification->data['message'] }}
                                        </small>

                                        <small class="text-secondary">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>

                                    </a>

                                    @if(is_null($notification->read_at))

                                    <form action="{{ route('notifications.read',$notification->id) }}" method="POST" class="ms-2">
                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-sm btn-outline-success" title="Mark as Read">

                                            <i class="bi bi-check-lg"></i>

                                        </button>
                                    </form>

                                    @else

                                    <i class="bi bi-check2-all text-success ms-2"></i>

                                    @endif

                                </div>

                            </div>

                            @empty

                            <div class="text-center text-muted py-5">
                                <i class="bi bi-bell-slash fs-1 d-block mb-2"></i>
                                No Notifications
                            </div>

                            @endforelse

                        </div>

                        {{-- Footer --}}
                        <div class="border-top text-center">
                            <a href="{{ route('notifications.index') }}" class="dropdown-item py-2 fw-semibold">
                                View All Notifications
                            </a>
                        </div>

                    </div>

                </div>

                {{-- User --}}
                <div class="dropdown">

                    <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;" alt="Avatar">

                        <span>{{ auth()->user()->name }}</span>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>
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
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</nav>
