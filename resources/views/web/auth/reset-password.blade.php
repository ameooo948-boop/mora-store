<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password | {{ config('app.name') }}</title>

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

                    <i class="bi bi-shield-check"></i>

                    Account Security

                </span>


                <h1>

                    Create a

                    <span>new password.</span>

                </h1>


                <p>

                    Choose a strong password to keep your

                    {{ config('app.name') }} account secure.

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


            {{-- Mobile Logo --}}

            <div class="mobile-logo">

                <div class="mobile-logo-icon">

                    <i class="bi bi-bag-check-fill"></i>

                </div>


                <strong>

                    {{ config('app.name') }}

                </strong>

            </div>


            <div class="login-card">


                {{-- Header --}}

                <div class="login-header">

                    <div class="login-icon">

                        <i class="bi bi-lock"></i>

                    </div>


                    <h2>

                        Reset Password?

                    </h2>


                    <p>

                        Enter your new password below

                    </p>

                </div>


                {{-- General Error --}}

                @if($errors->any())

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-triangle me-1"></i>

                    Please check the information below.

                </div>

                @endif


                <form action="{{ route('password.update') }}" method="POST">

                    @csrf


                    {{-- Token --}}

                    <input type="hidden" name="token" value="{{ $token }}">


                    {{-- Email --}}

                    <div class="login-field">

                        <label for="email">

                            Email Address

                        </label>


                        <div class="login-input">

                            <i class="bi bi-envelope"></i>


                            <input type="email" id="email" name="email" value="{{ old('email', request('email')) }}" placeholder="Enter your email" required autofocus>

                        </div>


                        @error('email')

                        <small class="login-error">

                            <i class="bi bi-exclamation-circle"></i>

                            {{ $message }}

                        </small>

                        @enderror

                    </div>


                    {{-- New Password --}}

                    <div class="login-field">

                        <label for="password">

                            New Password

                        </label>


                        <div class="login-input">

                            <i class="bi bi-lock"></i>


                            <input type="password" id="password" name="password" placeholder="Enter your new password" required autocomplete="new-password">


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


                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your new password" required autocomplete="new-password">


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


                    {{-- Reset Button --}}

                    <button type="submit" class="login-button">

                        <span>

                            Reset Password

                        </span>


                        <i class="bi bi-check2-circle"></i>

                    </button>

                </form>


                {{-- Back to Login --}}

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
