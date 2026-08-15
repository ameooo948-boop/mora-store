<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    {{-- =====================================================
        META
    ====================================================== --}}

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{ setting('site_name') }} — Shop quality products with a simple, secure and modern shopping experience.">

    <meta name="theme-color" content="#0f172a">


    {{-- =====================================================
        TITLE
    ====================================================== --}}

    <title>
        @yield('title', setting('site_name'))
    </title>

    <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_favicon')) }}">

    {{-- =====================================================
        FAVICON
    ====================================================== --}}

    @if(!empty($siteLogo))

    <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteLogo) }}">

    @endif


    {{-- =====================================================
        FONTS
    ====================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    {{-- =====================================================
        BOOTSTRAP
    ====================================================== --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">


    {{-- =====================================================
        VITE
    ====================================================== --}}

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])


    {{-- =====================================================
        PAGE SPECIFIC HEAD
    ====================================================== --}}

    @stack('head')

    @stack('styles')

</head>


<body class="store-body">


    {{-- =====================================================
        NAVBAR
    ====================================================== --}}

    @include('web.layouts.navbar')


    {{-- =====================================================
        MAIN
    ====================================================== --}}

    <main class="store-main">


        {{-- =================================================
    FLASH MESSAGES
================================================== --}}

        <div class="store-alerts">

            @if(session('success'))

            <div class="store-alert store-alert-success" role="alert">

                <div class="store-alert-icon">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="store-alert-content">

                    <span class="store-alert-title">
                        Success
                    </span>

                    <span class="store-alert-message">
                        {{ session('success') }}
                    </span>

                </div>

                <button type="button" class="store-alert-close" aria-label="Close" onclick="this.closest('.store-alert').remove()">
                    <i class="bi bi-x"></i>
                </button>

            </div>

            @endif


            @if(session('error'))

            <div class="store-alert store-alert-error" role="alert">

                <div class="store-alert-icon">
                    <i class="bi bi-x-lg"></i>
                </div>

                <div class="store-alert-content">

                    <span class="store-alert-title">
                        Error
                    </span>

                    <span class="store-alert-message">
                        {{ session('error') }}
                    </span>

                </div>

                <button type="button" class="store-alert-close" aria-label="Close" onclick="this.closest('.store-alert').remove()">
                    <i class="bi bi-x"></i>
                </button>

            </div>

            @endif


            @if($errors->any())

            <div class="store-alert store-alert-error" role="alert">

                <div class="store-alert-icon">
                    <i class="bi bi-exclamation-lg"></i>
                </div>

                <div class="store-alert-content">

                    <span class="store-alert-title">
                        Please check your information
                    </span>

                    <ul class="store-alert-errors">

                        @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                        @endforeach

                    </ul>

                </div>

                <button type="button" class="store-alert-close" aria-label="Close" onclick="this.closest('.store-alert').remove()">
                    <i class="bi bi-x"></i>
                </button>

            </div>

            @endif

        </div>

        {{-- =================================================
            PAGE CONTENT
        ================================================== --}}

        <div class="store-content">

            @yield('content')

        </div>

    </main>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    @include('web.layouts.footer')


    {{-- =====================================================
        JAVASCRIPT
    ====================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- =====================================================
        PAGE SPECIFIC SCRIPTS
    ====================================================== --}}

    <script>
        setTimeout(() => {

            document
                .querySelectorAll('.store-alert')
                .forEach(alert => {

                    alert.style.transition = 'all .25s ease';

                    alert.style.opacity = '0';

                    alert.style.transform = 'translateX(25px)';

                    setTimeout(() => {

                        alert.remove();

                    }, 250);

                });

        }, 4500);

    </script>

    @stack('scripts')

</body>

</html>
