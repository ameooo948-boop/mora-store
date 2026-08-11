<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Verify Email | {{ config('app.name') }}</title>

@vite([
    'resources/css/app.css',
    'resources/js/app.js',
])

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    rel="stylesheet"
>


<div class="login-wrapper">

    {{-- Left Side --}}

    <div class="login-showcase">

        <div class="showcase-content">

            <div class="brand-logo">

                @if($siteLogo)

                    <img
                        src="{{ asset('storage/' . $siteLogo) }}"
                        alt="{{ config('app.name') }}"
                    >

                @else

                    <i class="bi bi-bag-check-fill"></i>

                @endif

                <span>
                    {{ config('app.name') }}
                </span>

            </div>


            <div class="showcase-main">

                <span class="showcase-badge">

                    <i class="bi bi-envelope-check"></i>

                    Email Verification

                </span>


                <h1>

                    Almost

                    <span>there.</span>

                </h1>


                <p>

                    We've sent a verification link to your email
                    address. Verify your account to start shopping
                    with {{ config('app.name') }}.

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


                {{-- Icon --}}

                <div class="login-header">

                    <div class="login-icon">

                        <i class="bi bi-envelope-check"></i>

                    </div>


                    <h2>

                        Verify Your Email

                    </h2>


                    <p>

                        We've sent a verification link to

                    </p>


                    <strong class="d-block mt-2">

                        {{ auth()->user()->email }}

                    </strong>

                </div>


                {{-- Success Message --}}

                @if(session('success'))

                    <div class="alert alert-success">

                        <i class="bi bi-check-circle me-1"></i>

                        {{ session('success') }}

                    </div>

                @endif


                {{-- Information --}}

                <div class="alert alert-info">

                    <i class="bi bi-info-circle me-1"></i>

                    Please check your inbox and click the
                    verification link to activate your account.

                </div>


                {{-- Resend --}}

                <form
                    action="{{ route('verification.send') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="login-button"
                    >

                        <span>

                            Resend Verification Email

                        </span>


                        <i class="bi bi-send"></i>

                    </button>

                </form>


                {{-- Logout --}}

                <div class="register-section">

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-inline"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-link p-0 text-decoration-none"
                        >

                            <i class="bi bi-box-arrow-left me-1"></i>

                            Logout

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>