<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AddressRepository implements AddressRepositoryInterface
{
    public function paginate(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->addresses()
            ->latest()
            ->paginate($perPage);
    }

    public function all(User $user): Collection
    {
        return $user->addresses()
            ->latest()
            ->get();
    }

    public function find(User $user, int $id): ?Address
    {
        return $user->addresses()
            ->find($id);
    }

    public function create(array $data): Address
    {
        return Address::create($data);
    }

    public function update(Address $address, array $data): bool
    {
        return $address->update($data);
    }

    public function delete(Address $address): bool
    {
        return $address->delete();
    }

    public function getDefault(User $user): ?Address
    {
        return $user->defaultAddress()->first();
    }

    public function clearDefault(User $user): void
    {
        $user->addresses()->update([
            'is_default' => false,
        ]);
    }

    public function setDefault(Address $address): bool
    {
        return $address->update([
            'is_default' => true,
        ]);
    }
}
