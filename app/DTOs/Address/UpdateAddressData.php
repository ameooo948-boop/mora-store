<?php

namespace App\DTOs\Address;

readonly class UpdateAddressData
{
    public function __construct(
        public string $fullName,
        public string $phone,
        public string $country,
        public string $state,
        public string $city,
        public string $addressLine,
        public ?string $postalCode = null,
        public bool $isDefault = false,
    ) {}

    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName,
            'phone' => $this->phone,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'address_line' => $this->addressLine,
            'postal_code' => $this->postalCode,
            'is_default' => $this->isDefault,
        ];
    }
}
