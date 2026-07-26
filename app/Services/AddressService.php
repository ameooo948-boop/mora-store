<?php

namespace App\Services;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AddressService
{
    public function __construct(
        private readonly AddressRepositoryInterface $addressRepository,
    ) {}

    public function paginate(User $user): LengthAwarePaginator
    {
        return $this->addressRepository->paginate($user);
    }

    public function all(User $user): Collection
    {
        return $this->addressRepository->all($user);
    }

    public function find(User $user, int $id): ?Address
    {
        return $this->addressRepository->find($user, $id);
    }

    public function create(array $data): Address
    {
        return DB::transaction(function () use ($data) {
            $user = User::findOrFail($data['user_id']);

            if ($data['is_default'] ?? false) {
                $this->addressRepository
                    ->clearDefault($user);
            }

            if (!$this->addressRepository->getDefault($user)) {
                $data['is_default'] = true;
            }

            return $this->addressRepository
                ->create($data);
        });
    }

    public function update(Address $address, array $data): bool
    {
        return DB::transaction(function () use ($address, $data) {

            if ($data['is_default'] ?? false) {

                $this->addressRepository
                    ->clearDefault($address->user);
            }

            return $this->addressRepository
                ->update($address, $data);
        });
    }

    public function delete(Address $address): bool
    {
        return $this->addressRepository
            ->delete($address);
    }

    public function setDefault(Address $address): bool
    {
        return DB::transaction(function () use ($address) {

            $this->addressRepository
                ->clearDefault($address->user);

            return $this->addressRepository
                ->setDefault($address);
        });
    }

    public function getDefault(User $user): ?Address
    {
        return $this->addressRepository
            ->getDefault($user);
    }

    public function getUserAddresses(User $user)
    {
        return $user->addresses()->get();
    }
}
