<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Admin Dashboard')
    </title>

    @vite([
    'resources/css/admin.css',
    'resources/js/admin.js',
    ])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')

</head>


<body class="admin-body">

    <div class="admin-layout">

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')


        {{-- Right Side --}}
        <div class="admin-main">

            {{-- Navbar --}}
            @include('admin.layouts.navbar')


            {{-- Page --}}
            <main class="admin-content">

                {{-- Flash Messages --}}
                @if(session('success') || session('error'))

                <div class="admin-flash-container">

                    @if(session('success'))

                    <div class="admin-flash admin-flash-success" role="alert">

                        <div class="admin-flash-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div class="admin-flash-content">

                            <span class="admin-flash-title">
                                Success
                            </span>

                            <span class="admin-flash-message">
                                {{ session('success') }}
                            </span>

                        </div>

                        <button type="button" class="admin-flash-close" onclick="this.closest('.admin-flash').remove()">
                            <i class="bi bi-x"></i>
                        </button>

                    </div>

                    @endif


                    @if(session('error'))

                    <div class="admin-flash admin-flash-error" role="alert">

                        <div class="admin-flash-icon">
                            <i class="bi bi-x-lg"></i>
                        </div>

                        <div class="admin-flash-content">

                            <span class="admin-flash-title">
                                Error
                            </span>

                            <span class="admin-flash-message">
                                {{ session('error') }}
                            </span>

                        </div>

                        <button type="button" class="admin-flash-close" onclick="this.closest('.admin-flash').remove()">
                            <i class="bi bi-x"></i>
                        </button>

                    </div>

                    @endif

                </div>

                @endif

                @yield('content')

            </main>


            {{-- Footer --}}
            @include('admin.layouts.footer')

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        setTimeout(() => {

            document
                .querySelectorAll('.admin-flash')
                .forEach(alert => {

                    alert.style.transition = 'all .25s ease';

                    alert.style.opacity = '0';

                    alert.style.transform = 'translateX(20px)';

                    setTimeout(() => {
                        alert.remove();
                    }, 250);

                });

        }, 4000);

    </script>

    @stack('scripts')

</body>

</html>
