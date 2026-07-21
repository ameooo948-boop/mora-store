<?php

namespace App\Repositories\Contracts;

use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepositoryInterface
{
    public function paginate(User $user, int $perPage = 10): LengthAwarePaginator;

    public function all(User $user): Collection;

    public function find(User $user, int $id): ?Address;

    public function create(array $data): Address;

    public function update(Address $address, array $data): bool;

    public function delete(Address $address): bool;

    public function getDefault(User $user): ?Address;

    public function clearDefault(User $user): void;

    public function setDefault(Address $address): bool;
}
