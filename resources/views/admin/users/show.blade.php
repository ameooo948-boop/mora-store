@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title mb-0">

            User Details

        </h3>

        <div>

            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">

                <i class="bi bi-pencil-square"></i>

                Edit

            </a>

            <a href="{{ route('admin.users.index') }}" class="btn btn-light">

                Back

            </a>

        </div>

    </div>

    <div class="card-body">

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

                    Role

                </label>

                <div>

                    @foreach ($user->roles as $role)

                    @php
                    $badgeClass = match ($role->name) {
                    'admin' => 'bg-danger',
                    'customer' => 'bg-primary',
                    default => 'bg-secondary',
                    };
                    @endphp

                    <span class="badge {{ $badgeClass }}">

                        {{ ucfirst($role->name) }}

                    </span>

                    @endforeach

                </div>

            </div>

            <div class="col-md-6 mb-4">

                <label class="form-label fw-semibold">

                    Created At

                </label>

                <div class="form-control bg-light">

                    {{ $user->created_at->format('Y-m-d h:i A') }}

                </div>

            </div>

            <div class="col-md-6 mb-4">

                <label class="form-label fw-semibold">

                    Updated At

                </label>

                <div class="form-control bg-light">

                    {{ $user->updated_at->format('Y-m-d h:i A') }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
