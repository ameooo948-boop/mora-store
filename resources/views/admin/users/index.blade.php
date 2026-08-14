@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')

<div class="users-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="users-page-header">

        <div>

            <span class="users-eyebrow">
                USER MANAGEMENT
            </span>

            <h1>
                Users
            </h1>

            <p>
                Manage customers, vendors and administrators
            </p>

        </div>

        <a href="{{ route('admin.users.create') }}" class="users-add-btn">

            <i class="bi bi-plus-lg"></i>

            Add User

        </a>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="users-stats">

        <div class="users-stat-card">

            <div class="users-stat-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>

                <span>
                    Total Users
                </span>

                <strong>
                    {{ $statistics['total'] }}
                </strong>

            </div>

        </div>


        <div class="users-stat-card">

            <div class="users-stat-icon red">
                <i class="bi bi-shield-fill-check"></i>
            </div>

            <div>

                <span>
                    Admins
                </span>

                <strong>
                    {{ $statistics['admins'] }}
                </strong>

            </div>

        </div>


        <div class="users-stat-card">

            <div class="users-stat-icon orange">
                <i class="bi bi-shop"></i>
            </div>

            <div>

                <span>
                    Vendors
                </span>

                <strong>
                    {{ $statistics['vendor'] }}
                </strong>

            </div>

        </div>


        <div class="users-stat-card">

            <div class="users-stat-icon purple">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>

                <span>
                    Customers
                </span>

                <strong>
                    {{ $statistics['customers'] }}
                </strong>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="users-filter-card">

        <form method="GET" action="{{ route('admin.users.index') }}">

            <div class="users-filter-grid">

                <div class="users-search">

                    <label>
                        Search
                    </label>

                    <div class="users-input-icon">

                        <i class="bi bi-search"></i>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email...">

                    </div>

                </div>


                <div>

                    <label>
                        Role
                    </label>

                    <select name="role" class="users-select">

                        <option value="">
                            All Roles
                        </option>

                        @foreach($roles as $role)

                        <option value="{{ $role->name }}" @selected(request('role')==$role->name)
                            >
                            {{ ucfirst($role->name) }}
                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="users-filter-actions">

                    <button type="submit" class="users-filter-btn">

                        <i class="bi bi-funnel"></i>

                        Filter

                    </button>

                    <a href="{{ route('admin.users.index') }}" class="users-reset-btn">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         USERS TABLE
    ====================================================== --}}

    <div class="users-table-card">

        <div class="users-table-header">

            <div>

                <strong>
                    Users
                </strong>

                <span>
                    Showing {{ $users->total() }} users
                </span>

            </div>

            <div class="users-count">

                <i class="bi bi-people"></i>

                {{ $users->total() }}

            </div>

        </div>


        <div class="table-responsive">

            <table class="users-table">

                <thead>

                    <tr>

                        <th>
                            User
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Created
                        </th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                    <tr>

                        {{-- USER --}}

                        <td>

                            <div class="user-cell">

                                <div class="user-avatar">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>

                                <div>

                                    <strong>
                                        {{ $user->name }}
                                    </strong>

                                    <span>
                                        {{ $user->email }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- ROLE --}}

                        <td>

                            <div class="user-roles">

                                @foreach($user->roles as $role)

                                @php

                                $roleClass = match ($role->name) {

                                'admin' => 'admin',

                                'vendor' => 'vendor',

                                'customer' => 'customer',

                                default => 'default',

                                };

                                @endphp

                                <span class="user-role {{ $roleClass }}">

                                    @if($role->name === 'admin')

                                    <i class="bi bi-shield-fill-check"></i>

                                    @elseif($role->name === 'vendor')

                                    <i class="bi bi-shop"></i>

                                    @elseif($role->name === 'customer')

                                    <i class="bi bi-person"></i>

                                    @else

                                    <i class="bi bi-person-badge"></i>

                                    @endif

                                    {{ ucfirst($role->name) }}

                                </span>

                                @endforeach

                            </div>

                        </td>


                        {{-- CREATED --}}

                        <td>

                            <div class="user-date">

                                <i class="bi bi-calendar3"></i>

                                {{ $user->created_at->format('M d, Y') }}

                            </div>

                        </td>


                        {{-- ACTIONS --}}

                        <td>

                            <div class="user-actions">

                                <a href="{{ route('admin.users.show', $user) }}" class="user-action view" title="View User">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <a href="{{ route('admin.users.edit', $user) }}" class="user-action edit" title="Edit User">

                                    <i class="bi bi-pencil-square"></i>

                                </a>


                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="user-action delete" title="Delete User">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4">

                            <div class="users-empty">

                                <div class="users-empty-icon">

                                    <i class="bi bi-people"></i>

                                </div>

                                <strong>
                                    No Users Found
                                </strong>

                                <span>
                                    There are no users matching your search.
                                </span>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($users->hasPages())

        <div class="users-pagination">

            {{ $users->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
