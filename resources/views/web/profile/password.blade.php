@extends('web.layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="profile-page">
    <div class="container">
        <div class="profile-hero">
            <div class="profile-hero-main">
                <div class="profile-avatar-wrap">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="profile-avatar">
                </div>
                <div class="profile-identity">
                    <span class="profile-eyebrow"><i class="bi bi-shield-lock-fill"></i> ACCOUNT SECURITY</span>
                    <h1>Change Password</h1>
                    <p>Keep your account protected with a strong, unique password.</p>
                </div>
            </div>
        </div>

        <div class="profile-layout">
            <main>
                <section class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-heading">
                            <div class="profile-heading-icon blue"><i class="bi bi-lock-fill"></i></div>
                            <div>
                                <span>SECURITY</span>
                                <h2>Update your password</h2>
                            </div>
                        </div>
                    </div>

                    <div class="profile-card-body">
                        <div class="security-notice">
                            <div class="security-notice-icon"><i class="bi bi-info-circle-fill"></i></div>
                            <div>
                                <strong>Choose a password you do not reuse elsewhere.</strong>
                                <p>Use at least 8 characters and avoid easily guessed information.</p>
                            </div>
                        </div>

                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="profile-password-grid">
                                <div class="profile-field">
                                    <label for="current_password">Current Password</label>
                                    <div class="profile-input-wrap">
                                        <i class="bi bi-key"></i>
                                        <input type="password" id="current_password" name="current_password" autocomplete="current-password" required class="@error('current_password') is-invalid @enderror">
                                    </div>
                                    @error('current_password')<span class="profile-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="profile-field">
                                    <label for="password">New Password</label>
                                    <div class="profile-input-wrap">
                                        <i class="bi bi-lock"></i>
                                        <input type="password" id="password" name="password" autocomplete="new-password" required class="@error('password') is-invalid @enderror">
                                    </div>
                                    @error('password')<span class="profile-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="profile-field">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <div class="profile-input-wrap">
                                        <i class="bi bi-check2-circle"></i>
                                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>
@endsection
