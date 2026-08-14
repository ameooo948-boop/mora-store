<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | {{ setting('site_name') }}</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="login-page">

    <div class="login-wrapper">

        {{-- =========================
        Left Side
    ========================== --}}

        <div class="login-showcase">

            <div class="showcase-content">

                <div class="brand">
                    <div class="brand-logo">

                        @if($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ setting('site_name') }}">
                        @else
                        <i class="bi bi-bag-check-fill"></i>
                        @endif

                    </div>

                    <span class="brand-name">
                        {{ setting('site_name') }}
                    </span>
                </div>

                <div class="showcase-main">

                    <span class="showcase-badge">
                        <i class="bi bi-stars"></i>
                        Welcome to our store
                    </span>

                    <h1>
                        Everything you need,
                        <span>all in one place.</span>
                    </h1>

                    <p>
                        Discover amazing products, enjoy a seamless
                        shopping experience, and manage your orders
                        easily from your account.
                    </p>

                    <div class="showcase-features">

                        <div class="showcase-feature">
                            <div class="feature-icon">
                                <i class="bi bi-truck"></i>
                            </div>

                            <div>
                                <strong>Fast Delivery</strong>
                                <small>Quick and reliable shipping</small>
                            </div>
                        </div>

                        <div class="showcase-feature">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <strong>Secure Shopping</strong>
                                <small>Your data is always protected</small>
                            </div>
                        </div>

                        <div class="showcase-feature">
                            <div class="feature-icon">
                                <i class="bi bi-headset"></i>
                            </div>

                            <div>
                                <strong>Great Support</strong>
                                <small>We're here whenever you need us</small>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="showcase-footer">

                    <span>
                        © {{ date('Y') }} {{ setting('site_name') }}
                    </span>

                    <span>
                        Shop smarter. Live better.
                    </span>

                </div>

            </div>

        </div>


        {{-- =========================
        Right Side
    ========================== --}}

        <div class="login-section">

            <div class="login-container">

                <div class="mobile-logo">

                    <div class="mobile-logo-icon">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>

                    <strong>
                        {{ setting('site_name') }}
                    </strong>

                </div>

                <div class="login-card">

                    {{-- Header --}}

                    <div class="login-header">

                        <div class="login-icon">

                            <i class="bi bi-person-fill"></i>

                        </div>

                        <h2>
                            Welcome Back
                        </h2>

                        <p>
                            Sign in to continue to your account
                        </p>

                    </div>


                    {{-- Form --}}

                    <form action="{{ route('login') }}" method="POST">

                        @csrf


                        {{-- Email --}}

                        <div class="login-field">

                            <label for="email">
                                Email Address
                            </label>

                            <div class="login-input">

                                <i class="bi bi-envelope"></i>

                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" autocomplete="email" required autofocus>

                            </div>

                            @error('email')

                            <small class="login-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </small>

                            @enderror

                        </div>


                        {{-- Password --}}

                        <div class="login-field">

                            <div class="d-flex justify-content-between">

                                <label for="password">
                                    Password
                                </label>

                                @if(Route::has('password.request'))

                                <a href="{{ route('password.request') }}" class="forgot-link">

                                    Forgot Password?

                                </a>

                                @endif

                            </div>

                            <div class="login-input">

                                <i class="bi bi-lock"></i>

                                <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

                                <button type="button" id="togglePassword" class="password-toggle" aria-label="Show password">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                            @error('password')

                            <small class="login-error">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </small>

                            @enderror

                        </div>


                        {{-- Remember --}}

                        <div class="login-options">

                            <label class="remember-me">

                                <input type="checkbox" name="remember" id="remember">

                                <span class="custom-checkbox"></span>

                                <span>
                                    Remember me
                                </span>

                            </label>

                        </div>


                        {{-- Login Button --}}

                        <button type="submit" class="login-button">

                            <span>
                                Sign In
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </form>


                    {{-- Register --}}

                    <div class="register-section">

                        <span>
                            Don't have an account?
                        </span>

                        <a href="{{ route('register') }}">
                            Create Account
                        </a>

                    </div>

                    <div class="register-section">

                        <a href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>

                    </div>

                </div>

                <div class="mobile-footer">
                    © {{ date('Y') }} {{ setting('site_name') }}
                </div>

            </div>

        </div>

    </div>


    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function() {

            const isPassword =
                passwordInput.type === 'password';

            passwordInput.type =
                isPassword ? 'text' : 'password';

            this.innerHTML = isPassword ?
                '<i class="bi bi-eye-slash"></i>' :
                '<i class="bi bi-eye"></i>';

            this.setAttribute(
                'aria-label'
                , isPassword ?
                'Hide password' :
                'Show password'
            );

        });

    </script>

</body>

</html>
