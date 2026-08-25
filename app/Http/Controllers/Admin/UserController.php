<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\User\CreateUserData;
use App\DTOs\User\UpdateUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request)
    {
        $users = $this->userService->getPaginatedUsers(
            $request->search,
            $request->role
        );

        $roles = Role::orderBy('name')->get();

        $statistics = $this->userService->getStatistics();

        return view(
            'admin.users.index',
            compact('users', 'roles', 'statistics')
        );
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view(
            'admin.users.create',
            compact('roles')
        );
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create(
            new CreateUserData(
                name: $request->string('name')->value(),
                email: $request->string('email')->value(),
                password: $request->string('password')->value(),
                role: $request->string('role')->value(),
            )
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $this->userService->update(
            $user,
            new UpdateUserData(
                name: $request->string('name')->value(),
                email: $request->string('email')->value(),
                password: $request->filled('password')
                    ? $request->string('password')->value()
                    : null,
                role: $request->string('role')->value(),
            )
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
