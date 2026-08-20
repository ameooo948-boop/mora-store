<?php

namespace App\Services;

use App\DTOs\User\CreateUserData;
use App\DTOs\User\UpdateUserData;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getPaginatedUsers(
        ?string $search = null,
        ?string $role = null
    ): LengthAwarePaginator {

        return User::query()
            ->with('roles')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })

            ->when($role, function ($query) use ($role) {

                $query->role($role);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function getStatistics(): array
    {
        return [

            'total' => User::count(),

            'admins' => User::role('admin')->count(),

            'vendor' => User::role('vendor')->count(),

            'customers' => User::role('customer')->count(),

        ];
    }

    public function create(CreateUserData $data): User
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        $user->assignRole($data->role);

        return $user;
    }

    public function update(
        User $user,
        UpdateUserData $data,
    ): User {
        $user->name = $data->name;
        $user->email = $data->email;

        if (! empty($data->password)) {
            $user->password = Hash::make($data->password);
        }

        $user->save();

        $user->syncRoles($data->role);

        return $user->fresh('roles');
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
