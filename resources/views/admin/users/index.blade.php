@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title">
                Users
            </h3>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">

                Add User

            </a>

        </div>

    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 mb-3">

            <div class="col-md-5">

                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">

            </div>

            <div class="col-md-4">

                <select name="role" class="form-select">

                    <option value="">

                        All Roles

                    </option>

                    @foreach ($roles as $role)

                    <option value="{{ $role->name }}" @selected(request('role')==$role->name)>

                        {{ ucfirst($role->name) }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3 d-flex gap-2">

                <button type="submit" class="btn btn-primary">

                    Filter

                </button>

                <a href="{{ route('admin.users.index') }}" class="btn btn-light">

                    Reset

                </a>

            </div>

        </form>

        <table class="table table-bordered table-hover">

            <thead>

                <tr>


                    <th>Name</th>

                    <th>Email</th>

                    <th>Role</th>

                    <th>Created At</th>

                    <th width="220">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>

                        <div class="d-flex align-items-center">

                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width:40px;height:40px;">

                                {{ strtoupper(substr($user->name,0,1)) }}

                            </div>

                            <div class="ms-2">

                                <strong>{{ $user->name }}</strong>

                            </div>

                        </div>

                    </td>

                    <td>

                        {{ $user->email }}

                    </td>

                    <td>

                        @foreach ($user->roles as $role)

                        @php
                        $badgeClass = match ($role->name) {
                        'admin' => 'bg-danger',
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

                    <td>

                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">

                            View

                        </a>

                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        No users found.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-3">

            {{ $users->links() }}

        </div>

    </div>

</div>

@endsection
