<?php

namespace App\Repositories\Contracts;

interface SettingRepositoryInterface
{
    public function all(): array;

    public function get(
        string $key,
        mixed $default = null,
    ): mixed;

    public function set(
        string $key,
        mixed $value,
        string $type = 'string',
    ): void;

    public function updateMany(
        array $settings,
    ): void;
}
