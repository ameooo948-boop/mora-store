<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password | {{ config('app.name') }}</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body class="login-page">

    <div class="login-wrapper">

        {{-- Left Side --}}

        <div class="login-showcase">

            <div class="showcase-content">

                <div class="brand-logo">

                    @if($siteLogo)

                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ config('app.name') }}">

                    @else

                    <i class="bi bi-bag-check-fill"></i>

                    @endif

                    <span>
                        {{ config('app.name') }}
                    </span>

                </div>

                <div class="showcase-main">

                    <span class="showcase-badge">
                        <i class="bi bi-shield-lock"></i>
                        Account Security
                    </span>

                    <h1>
                        Don't worry,
                        <span>we've got you.</span>
                    </h1>

                    <p>
                        Enter your email address and we'll send you
                        a secure link to reset your password.
                    </p>

                </div>

                <div class="showcase-footer">

                    <span>
                        © {{ date('Y') }} {{ config('app.name') }}
                    </span>

                    <span>
                        Shop smarter. Live better.
                    </span>

                </div>

            </div>

        </div>


        {{-- Right Side --}}

        <div class="login-section">

            <div class="login-container">

                <div class="mobile-logo">

                    <div class="mobile-logo-icon">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>

                    <strong>
                        {{ config('app.name') }}
                    </strong>

                </div>

                <div class="login-card">

                    <div class="login-header">

                        <div class="login-icon">

                            <i class="bi bi-key"></i>

                        </div>

                        <h2>
                            Forgot Password?
                        </h2>

                        <p>
                            Enter your email to receive a reset link
                        </p>

                    </div>


                    @if(session('success'))

                    <div class="alert alert-success">

                        <i class="bi bi-check-circle me-1"></i>

                        {{ session('success') }}

                    </div>

                    @endif


                    <form action="{{ route('password.email') }}" method="POST">

                        @csrf

                        <div class="login-field">

                            <label for="email">
                                Email Address
                            </label>

                            <div class="login-input">

                                <i class="bi bi-envelope"></i>

                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>

                            </div>

                            @error('email')

                            <small class="login-error">

                                <i class="bi bi-exclamation-circle"></i>

                                {{ $message }}

                            </small>

                            @enderror

                        </div>


                        <button type="submit" class="login-button">

                            <span>
                                Send Reset Link
                            </span>

                            <i class="bi bi-send"></i>

                        </button>

                    </form>


                    <div class="register-section">

                        <a href="{{ route('login') }}">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back to Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
