<nav class="navbar-custom">

    <div>

        <h4 class="mb-0">

            @yield('page-title')

        </h4>

    </div>

    <div class="d-flex align-items-center gap-3">

        <span class="fw-semibold">

            {{ auth()->user()->name }}

        </span>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button class="btn btn-outline-danger">

                <i class="bi bi-box-arrow-right"></i>

            </button>

        </form>

    </div>

</nav>