<nav class="admin-topbar">

    {{-- =========================
         PAGE TITLE
    ========================== --}}

    <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Open sidebar" aria-controls="adminSidebar" aria-expanded="false">
        <i class="bi bi-list"></i>
    </button>

    <div class="admin-topbar-title">

        <div class="admin-page-icon">
            <i class="bi bi-grid-1x2-fill"></i>
        </div>

        <div>

            <span>
                ADMIN PANEL
            </span>

            <h4>
                @yield('page-title', 'Dashboard')
            </h4>

        </div>

    </div>


    {{-- =========================
         RIGHT SIDE
    ========================== --}}

    <div class="admin-topbar-actions">


        {{-- Current User --}}

        <div class="admin-current-user">

            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="admin-current-avatar">

            <div class="admin-current-user-info">

                <strong>
                    {{ auth()->user()->name }}
                </strong>

                <span>
                    Administrator
                </span>

            </div>

        </div>


        {{-- Divider --}}

        <div class="admin-topbar-divider"></div>


        {{-- Logout --}}

        <form method="POST" action="{{ route('logout') }}" class="m-0">

            @csrf

            <button type="submit" class="admin-logout-btn" title="Logout">

                <i class="bi bi-box-arrow-right"></i>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</nav>
