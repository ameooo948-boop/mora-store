<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\User\CreateUserData;
use App\DTOs\User\UpdateUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
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

        return response()->json([
            'users' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'total' => $users->total(),
            ],
            'roles' => RoleResource::collection(Role::orderBy('name')->get()),
            'statistics' => $this->userService->getStatistics(),
        ]);
    }

    public function roles()
    {
        return response()->json([
            'roles' => RoleResource::collection(Role::orderBy('name')->get()),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create(
            new CreateUserData(
                name: $request->string('name')->value(),
                email: $request->string('email')->value(),
                password: $request->string('password')->value(),
                role: $request->string('role')->value(),
            )
        );

        $user->load('roles');

        return response()->json([
            'message' => 'User created successfully.',
            'user' => new UserResource($user),
        ], 201);
    }

    public function show(User $user)
    {
        $user->load('roles');

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $user = $this->userService->update(
            $user,
            new UpdateUserData(
                name: $request->string('name')->value(),
                email: $request->string('email')->value(),
                password: $request->filled('password') ? $request->string('password')->value() : null,
                role: $request->string('role')->value(),
            )
        );

        $user->load('roles');

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => new UserResource($user),
        ]);
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}
