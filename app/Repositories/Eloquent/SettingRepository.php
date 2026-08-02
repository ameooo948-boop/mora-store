<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function all(): array
    {
        return Setting::query()

            ->pluck(
                'value',
                'key'
            )

            ->toArray();
    }

    public function get(
        string $key,
        mixed $default = null,
    ): mixed {

        return Setting::query()

            ->where(
                'key',
                $key
            )

            ->value('value')

            ?? $default;
    }

    public function set(
        string $key,
        mixed $value,
        string $type = 'string',
    ): void {

        Setting::updateOrCreate(

            [

                'key' => $key,

            ],

            [

                'value' => $value,

                'type' => $type,

            ]

        );
    }

    public function updateMany(
        array $settings,
    ): void {

        foreach ($settings as $key => $value) {

            $this->set(
                $key,
                $value
            );
        }
    }
}
