@extends('web.layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container py-5">

    <div class="row">

        <div class="col-lg-8">

            {{-- Personal Information --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Personal Information

                    </h5>

                </div>

                <div class="card-body">

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        <div class="text-center mb-4">

                            <img src="{{ $user->avatar_url }}" class="rounded-circle border" width="120" height="120" style="object-fit: cover;">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Avatar

                            </label>

                            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">

                            @error('avatar')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Name

                            </label>

                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">

                            @error('name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">

                            @error('email')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <button class="btn btn-primary">

                            Save Changes

                        </button>

                    </form>

                </div>

            </div>

            {{-- Change Password --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Change Password

                    </h5>

                </div>

                <div class="card-body">

                    <form action="{{ route('profile.password.update') }}" method="POST">

                        @csrf

                        @method('PUT')

                        <div class="mb-3">

                            <label class="form-label">

                                Current Password

                            </label>

                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">

                            @error('current_password')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                New Password

                            </label>

                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

                            @error('password')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Confirm Password

                            </label>

                            <input type="password" name="password_confirmation" class="form-control">

                        </div>

                        <button class="btn btn-dark">

                            Update Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            {{-- Statistics --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Account Statistics

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span>

                            Orders

                        </span>

                        <strong>

                            {{ $statistics['orders'] }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span>

                            Reviews

                        </span>

                        <strong>

                            {{ $statistics['reviews'] }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span>

                            Wishlist

                        </span>

                        <strong>

                            {{ $statistics['wishlist'] }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span>

                            Addresses

                        </span>

                        <strong>

                            {{ $statistics['addresses'] }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
