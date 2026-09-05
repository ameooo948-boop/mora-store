@extends('web.layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="profile-page">

    <div class="container">

        {{-- =====================================================
            PROFILE HERO
        ====================================================== --}}

        <div class="profile-hero">

            <div class="profile-hero-main">

                <div class="profile-avatar-wrap">

                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar">

                    <span class="profile-online-dot"></span>

                </div>


                <div class="profile-identity">

                    <span class="profile-eyebrow">
                        <i class="bi bi-person-check-fill"></i>
                        MY ACCOUNT
                    </span>

                    <h1>
                        {{ $user->name }}
                    </h1>

                    <p>
                        {{ $user->email }}
                    </p>

                </div>

            </div>


            <div class="profile-member">

                <i class="bi bi-shield-check"></i>

                <div>

                    <span>
                        Account
                    </span>

                    <strong>
                        Active
                    </strong>

                </div>

            </div>
                    <a href="{{ route('profile.password') }}" class="btn btn-outline-primary mt-3">
                        <i class="bi bi-shield-lock me-1"></i> Change Password
                    </a>

        </div>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}

        <div class="profile-layout">

            <main>


                {{-- =================================================
                    PERSONAL INFORMATION
                ================================================== --}}

                <section class="profile-card">

                    <div class="profile-card-header">

                        <div class="profile-heading">

                            <div class="profile-heading-icon blue">
                                <i class="bi bi-person-vcard"></i>
                            </div>

                            <div>

                                <span>
                                    ACCOUNT INFORMATION
                                </span>

                                <h2>
                                    Personal Information
                                </h2>

                            </div>

                        </div>

                    </div>


                    <div class="profile-card-body">

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')


                            {{-- Avatar Upload --}}

                            <div class="avatar-upload-section">

                                <div class="avatar-preview-wrap">

                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="avatar-preview">

                                    <label for="avatar" class="avatar-camera" title="Change avatar">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>

                                </div>


                                <div class="avatar-upload-info">

                                    <strong>
                                        Profile Picture
                                    </strong>

                                    <p>
                                        Upload a new avatar to personalize your account.
                                    </p>

                                    <label for="avatar" class="avatar-upload-btn">
                                        <i class="bi bi-upload"></i>
                                        Choose Image
                                    </label>

                                    <input type="file" id="avatar" name="avatar" class="avatar-file-input @error('avatar') is-invalid @enderror" accept="image/*">

                                    @error('avatar')

                                    <div class="profile-error">
                                        {{ $message }}
                                    </div>

                                    @enderror

                                </div>

                            </div>


                            <div class="profile-divider"></div>


                            {{-- Name / Email --}}

                            <div class="profile-form-grid">

                                <div class="profile-field">

                                    <label for="name">
                                        Full Name
                                    </label>

                                    <div class="profile-input-wrap">

                                        <i class="bi bi-person"></i>

                                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Your full name" class="@error('name') is-invalid @enderror">

                                    </div>

                                    @error('name')

                                    <span class="profile-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                <div class="profile-field">

                                    <label for="email">
                                        Email Address
                                    </label>

                                    <div class="profile-input-wrap">

                                        <i class="bi bi-envelope"></i>

                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="you@example.com" class="@error('email') is-invalid @enderror">

                                    </div>

                                    @error('email')

                                    <span class="profile-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>

                            </div>


                            <div class="profile-form-actions">

                                <button type="submit" class="profile-save-btn">
                                    <i class="bi bi-check2"></i>
                                    Save Changes
                                </button>

                            </div>

                        </form>

                    </div>

                </section>


                {{-- =================================================
                    PASSWORD
                ================================================== --}}

                <section class="profile-card password-card">

                    <div class="profile-card-header">

                        <div class="profile-heading">

                            <div class="profile-heading-icon dark">
                                <i class="bi bi-shield-lock"></i>
                            </div>

                            <div>

                                <span>
                                    ACCOUNT SECURITY
                                </span>

                                <h2>
                                    Change Password
                                </h2>

                            </div>

                        </div>

                    </div>


                    <div class="profile-card-body">

                        <div class="security-notice">

                            <div class="security-notice-icon">
                                <i class="bi bi-lock-fill"></i>
                            </div>

                            <div>

                                <strong>
                                    Keep your account secure
                                </strong>

                                <p>
                                    Use a strong password that you don't use anywhere else.
                                </p>

                            </div>

                        </div>


                        <form action="{{ route('profile.password.update') }}" method="POST">

                            @csrf
                            @method('PUT')


                            <div class="profile-password-grid">

                                <div class="profile-field">

                                    <label for="current_password">
                                        Current Password
                                    </label>

                                    <div class="profile-input-wrap">

                                        <i class="bi bi-key"></i>

                                        <input type="password" id="current_password" name="current_password" placeholder="Current password" class="@error('current_password') is-invalid @enderror">

                                        <button type="button" class="password-toggle" data-target="current_password">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                    </div>

                                    @error('current_password')

                                    <span class="profile-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                <div class="profile-field">

                                    <label for="password">
                                        New Password
                                    </label>

                                    <div class="profile-input-wrap">

                                        <i class="bi bi-lock"></i>

                                        <input type="password" id="password" name="password" placeholder="New password" class="@error('password') is-invalid @enderror">

                                        <button type="button" class="password-toggle" data-target="password">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                    </div>

                                    @error('password')

                                    <span class="profile-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                <div class="profile-field">

                                    <label for="password_confirmation">
                                        Confirm Password
                                    </label>

                                    <div class="profile-input-wrap">

                                        <i class="bi bi-lock-fill"></i>

                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">

                                        <button type="button" class="password-toggle" data-target="password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                    </div>

                                </div>

                            </div>


                            <div class="profile-form-actions">

                                <button type="submit" class="password-update-btn">
                                    <i class="bi bi-shield-check"></i>
                                    Update Password
                                </button>

                            </div>

                        </form>

                    </div>

                </section>

            </main>


            {{-- =====================================================
                SIDEBAR
            ====================================================== --}}

            <aside>

                <section class="account-stats-card">

                    <div class="stats-card-header">

                        <div>

                            <span>
                                YOUR ACTIVITY
                            </span>

                            <h2>
                                Account Overview
                            </h2>

                        </div>

                        <div class="stats-header-icon">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>

                    </div>


                    <div class="account-stats-list">


                        {{-- Orders --}}

                        <a href="{{ route('orders.index') }}" class="account-stat">

                            <div class="account-stat-icon blue">
                                <i class="bi bi-bag-check"></i>
                            </div>

                            <div class="account-stat-info">

                                <span>
                                    Orders
                                </span>

                                <strong>
                                    {{ $statistics['orders'] }}
                                </strong>

                            </div>

                            <i class="bi bi-chevron-right stat-arrow"></i>

                        </a>


                        {{-- Reviews --}}

                        <div class="account-stat">

                            <div class="account-stat-icon orange">
                                <i class="bi bi-star"></i>
                            </div>

                            <div class="account-stat-info">

                                <span>
                                    Reviews
                                </span>

                                <strong>
                                    {{ $statistics['reviews'] }}
                                </strong>

                            </div>

                        </div>


                        {{-- Wishlist --}}

                        <a href="{{ route('wishlist.index') }}" class="account-stat">

                            <div class="account-stat-icon red">
                                <i class="bi bi-heart"></i>
                            </div>

                            <div class="account-stat-info">

                                <span>
                                    Wishlist
                                </span>

                                <strong>
                                    {{ $statistics['wishlist'] }}
                                </strong>

                            </div>

                            <i class="bi bi-chevron-right stat-arrow"></i>

                        </a>


                        {{-- Addresses --}}

                        <a href="{{ route('addresses.index') }}" class="account-stat">

                            <div class="account-stat-icon green">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="account-stat-info">

                                <span>
                                    Addresses
                                </span>

                                <strong>
                                    {{ $statistics['addresses'] }}
                                </strong>

                            </div>

                            <i class="bi bi-chevron-right stat-arrow"></i>

                        </a>

                    </div>


                    <div class="stats-card-footer">

                        <i class="bi bi-info-circle"></i>

                        <span>
                            Your account activity at a glance.
                        </span>

                    </div>

                </section>


                {{-- Security Card --}}

                <div class="security-card">

                    <div class="security-card-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>

                        <strong>
                            Your account is protected
                        </strong>

                        <p>
                            Keep your information up to date and use a strong password.
                        </p>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</div>


{{-- =========================================================
    PASSWORD TOGGLE
========================================================= --}}

<script>
    document.querySelectorAll('.password-toggle').forEach(button => {

        button.addEventListener('click', function() {

            const input = document.getElementById(this.dataset.target);

            const icon = this.querySelector('i');

            if (!input) return;

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

            } else {

                input.type = 'password';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

            }

        });

    });


    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.querySelector('.avatar-preview');

    if (avatarInput && avatarPreview) {

        avatarInput.addEventListener('change', function() {

            const file = this.files ? . [0];

            if (!file) return;

            if (!file.type.startsWith('image/')) return;

            avatarPreview.src = URL.createObjectURL(file);

        });

    }

</script>

@endsection
