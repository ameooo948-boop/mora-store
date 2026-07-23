<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')

</head>
<body>

    @include('web.layouts.navbar')

    <main class="py-0">

        @if(session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @yield('content')

    </main>

    @include('web.layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>

</html>
