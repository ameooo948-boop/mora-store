@extends('admin.layouts.app')

@section('title', 'Users')

@section('page-title', 'Users')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Total Users

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $statistics['total'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Admins

                    </small>

                    <h2 class="fw-bold text-danger mt-2">

                        {{ $statistics['admins'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Vendors

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $statistics['vendor'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Customers

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $statistics['customers'] }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET" action="{{ route('admin.users.index') }}">

                <div class="row g-3">

                    <div class="col-md-5">

                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">

                    </div>

                    <div class="col-md-4">

                        <select name="role" class="form-select">

                            <option value="">

                                All Roles

                            </option>

                            @foreach($roles as $role)

                            <option value="{{ $role->name }}" @selected(request('role')==$role->name)>

                                {{ ucfirst($role->name) }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button class="btn btn-primary flex-fill">

                            <i class="bi bi-search me-2"></i>

                            Filter

                        </button>

                        <a href="{{ route('admin.users.index') }}" class="btn btn-light">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-1">

                    Users

                </h5>

                <small class="text-muted">

                    Showing {{ $users->total() }} Users

                </small>

            </div>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle me-2"></i>

                Add User

            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>User</th>

                        <th>Role</th>

                        <th>Created</th>

                        <th class="text-center" width="80">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>
                    @forelse($users as $user)

                    <tr>

                        <td>

                            <div class="d-flex align-items-center">

                                <div class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center" style="width:45px;height:45px;">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>

                                <div class="ms-3">

                                    <div class="fw-semibold">

                                        {{ $user->name }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $user->email }}

                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>

                            @foreach($user->roles as $role)

                            @php

                            $badgeClass = match ($role->name) {

                            'admin' => 'bg-danger',

                            'vendor' => 'bg-warning text-dark',

                            'customer' => 'bg-primary',

                            default => 'bg-secondary',

                            };

                            @endphp

                            <span class="badge {{ $badgeClass }} me-1">

                                {{ ucfirst($role->name) }}

                            </span>

                            @endforeach

                        </td>

                        <td>

                            {{ $user->created_at->format('Y-m-d') }}

                        </td>

                        <td class="text-center">

                            <div class="dropdown">

                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots-vertical"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <a href="{{ route('admin.users.show', $user) }}" class="dropdown-item">

                                            <i class="bi bi-eye me-2"></i>

                                            View

                                        </a>

                                    </li>

                                    <li>

                                        <a href="{{ route('admin.users.edit', $user) }}" class="dropdown-item">

                                            <i class="bi bi-pencil-square me-2"></i>

                                            Edit

                                        </a>

                                    </li>

                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>

                                    <li>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="dropdown-item text-danger">

                                                <i class="bi bi-trash me-2"></i>

                                                Delete

                                            </button>

                                        </form>

                                    </li>

                                </ul>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4">

                            <div class="text-center py-5">

                                <i class="bi bi-people display-4 text-secondary"></i>

                                <h5 class="mt-3">

                                    No Users Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are no users matching your search.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($users->hasPages())

        <div class="card-footer bg-white">

            {{ $users->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
