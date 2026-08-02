<?php

use App\Services\SettingService;

if (! function_exists('setting')) {

    function setting(
        string $key,
        mixed $default = null,
    ): mixed {

        return app(SettingService::class)

            ->get(
                $key,
                $default
            );
    }
}

if (! function_exists('currency')) {

    function currency(
        float|int $amount,
    ): string {

        return number_format(
            $amount,
            2
        ) . ' ' . setting(
            'currency_symbol',
            'EGP'
        );
    }
}
