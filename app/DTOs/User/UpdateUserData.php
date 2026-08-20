<?php

namespace App\DTOs\User;

readonly class UpdateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password,
        public string $role,
    ) {}
}
