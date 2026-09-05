<?php

namespace App\Services;

use App\DTOs\Address\CreateAddressData;
use App\DTOs\Address\UpdateAddressData;
use App\Models\Address;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AddressService
{
    public function __construct(
        private readonly AddressRepositoryInterface $addressRepository,
    ) {}

    public function paginate(User $user): LengthAwarePaginator { return $this->addressRepository->paginate($user); }
    public function all(User $user): Collection { return $this->addressRepository->all($user); }
    public function find(User $user, int $id): ?Address { return $this->addressRepository->find($user, $id); }

    public function create(CreateAddressData $data): Address
    {
        return DB::transaction(function () use ($data) {
            $user = User::query()->lockForUpdate()->findOrFail($data->user->id);

            if ($data->isDefault) {
                $this->addressRepository->clearDefault($user);
            }

            if (! $this->addressRepository->getDefault($user)) {
                $data = new CreateAddressData(
                    user: $data->user,
                    fullName: $data->fullName,
                    phone: $data->phone,
                    country: $data->country,
                    state: $data->state,
                    city: $data->city,
                    addressLine: $data->addressLine,
                    postalCode: $data->postalCode,
                    isDefault: true,
                );
            }

            return $this->addressRepository->create($data->toArray());
        });
    }

    public function update(Address $address, UpdateAddressData $data): bool
    {
        return DB::transaction(function () use ($address, $data) {
            $user = User::query()->lockForUpdate()->findOrFail($address->user_id);

            if ($data->isDefault) {
                $this->addressRepository->clearDefault($user);
            }

            $result = $this->addressRepository->update($address, $data->toArray());

            // Keep one default address when the current default is edited.
            if (! $this->addressRepository->getDefault($user)) {
                $this->addressRepository->setDefault($address->fresh());
            }

            return $result;
        });
    }

    public function delete(Address $address): bool
    {
        return DB::transaction(function () use ($address) {
            $user = User::query()->lockForUpdate()->findOrFail($address->user_id);
            $wasDefault = (bool) $address->is_default;
            $result = $this->addressRepository->delete($address);

            if ($result && $wasDefault) {
                $replacement = $user->addresses()->latest('id')->first();
                if ($replacement) {
                    $this->addressRepository->setDefault($replacement);
                }
            }

            return $result;
        });
    }

    public function setDefault(Address $address): bool
    {
        return DB::transaction(function () use ($address) {
            $user = User::query()->lockForUpdate()->findOrFail($address->user_id);
            $this->addressRepository->clearDefault($user);

            return $this->addressRepository->setDefault($address);
        });
    }

    public function getDefault(User $user): ?Address { return $this->addressRepository->getDefault($user); }
    public function getUserAddresses(User $user) { return $user->addresses()->latest('id')->get(); }
}
