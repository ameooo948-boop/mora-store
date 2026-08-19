<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create Account | {{ setting('site_name') }}</title>

<link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_favicon')) }}">


@vite([
'resources/css/app.css',
'resources/js/app.js',
])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">


<div class="login-wrapper">

    {{-- Left Side --}}

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

                    <i class="bi bi-person-plus"></i>

                    Create Account

                </span>


                <h1>

                    Start your

                    <span>shopping journey.</span>

                </h1>


                <p>

                    Create your account and discover a smarter,

                    easier way to shop with {{ setting('site_name') }}.

                </p>

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


    {{-- Right Side --}}

    <div class="login-section">

        <div class="login-container">


            {{-- Mobile Logo --}}

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

                        <i class="bi bi-person-plus"></i>

                    </div>


                    <h2>

                        Create Account

                    </h2>


                    <p>

                        Sign up to get started

                    </p>

                </div>


                {{-- Errors --}}

                @if($errors->any())

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-triangle me-1"></i>

                    Please check the information below.

                </div>

                @endif


                <form action="{{ route('register') }}" method="POST">

                    @csrf


                    {{-- Name --}}

                    <div class="login-field">

                        <label for="name">

                            Full Name

                        </label>


                        <div class="login-input">

                            <i class="bi bi-person"></i>


                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required autofocus autocomplete="name">

                        </div>


                        @error('name')

                        <small class="login-error">

                            <i class="bi bi-exclamation-circle"></i>

                            {{ $message }}

                        </small>

                        @enderror

                    </div>


                    {{-- Email --}}

                    <div class="login-field">

                        <label for="email">

                            Email Address

                        </label>


                        <div class="login-input">

                            <i class="bi bi-envelope"></i>


                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email">

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

                        <label for="password">

                            Password

                        </label>


                        <div class="login-input">

                            <i class="bi bi-lock"></i>


                            <input type="password" id="password" name="password" placeholder="Create a password" required autocomplete="new-password">


                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)">

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


                    {{-- Confirm Password --}}

                    <div class="login-field">

                        <label for="password_confirmation">

                            Confirm Password

                        </label>


                        <div class="login-input">

                            <i class="bi bi-shield-lock"></i>


                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">


                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>


                        @error('password_confirmation')

                        <small class="login-error">

                            <i class="bi bi-exclamation-circle"></i>

                            {{ $message }}

                        </small>

                        @enderror

                    </div>


                    {{-- Register Button --}}

                    <button type="submit" class="login-button">

                        <span>

                            Create Account

                        </span>


                        <i class="bi bi-arrow-right"></i>

                    </button>

                </form>


                {{-- Login Link --}}

                <div class="register-section">

                    <span>

                        Already have an account?

                    </span>


                    <a href="{{ route('login') }}">

                        Sign in

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);

        const icon = button.querySelector('i');


        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('bi-eye');

            icon.classList.add('bi-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('bi-eye-slash');

            icon.classList.add('bi-eye');

        }

    }

</script>
