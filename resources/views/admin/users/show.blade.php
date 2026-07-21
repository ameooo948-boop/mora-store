@extends('admin.layouts.app')

@section('title', 'User Details')

@section('page-title', 'User Details')

@section('content')

<div class="container-fluid">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-1">

                    User Details

                </h5>

                <small class="text-muted">

                    View user information

                </small>

            </div>

            <div>

                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">

                    <i class="bi bi-pencil-square me-1"></i>

                    Edit

                </a>

                <a href="{{ route('admin.users.index') }}" class="btn btn-light">

                    <i class="bi bi-arrow-left me-1"></i>

                    Back

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="text-center mb-5">

                <div class="rounded-circle bg-primary text-white fw-bold d-inline-flex justify-content-center align-items-center" style="width:100px;height:100px;font-size:40px;">

                    {{ strtoupper(substr($user->name, 0, 1)) }}

                </div>

                <h4 class="mt-3 mb-1">

                    {{ $user->name }}

                </h4>

                <p class="text-muted mb-0">

                    {{ $user->email }}

                </p>

            </div>

            <div class="row">

                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">

                        Name

                    </label>

                    <div class="form-control bg-light">

                        {{ $user->name }}

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">

                        Email

                    </label>

                    <div class="form-control bg-light">

                        {{ $user->email }}

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">

                        Roles

                    </label>

                    <div>

                        @forelse($user->roles as $role)

                        @php

                        $badgeClass = match ($role->name) {

                        'admin' => 'bg-danger',

                        'vendor' => 'bg-warning text-dark',

                        'user' => 'bg-primary',

                        default => 'bg-secondary',

                        };

                        @endphp

                        <span class="badge {{ $badgeClass }} me-1">

                            {{ ucfirst($role->name) }}

                        </span>

                        @empty

                        <span class="badge bg-secondary">

                            No Role

                        </span>

                        @endforelse

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">

                        User ID

                    </label>

                    <div class="form-control bg-light">

                        #{{ $user->id }}

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">

                        Created At

                    </label>

                    <div class="form-control bg-light">

                        {{ $user->created_at->format('M d, Y h:i A') }}

                    </div>

                </div>

                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">

                        Updated At

                    </label>

                    <div class="form-control bg-light">

                        {{ $user->updated_at->format('M d, Y h:i A') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
