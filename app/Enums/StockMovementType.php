<?php

namespace App\Enums;

enum StockMovementType: string
{
    case Increase = 'increase';

    case Decrease = 'decrease';

    public function label(): string
    {
        return match ($this) {

            self::Increase => 'Increase',

            self::Decrease => 'Decrease',

        };
    }

    public function badge(): string
    {
        return match ($this) {

            self::Increase => 'success',

            self::Decrease => 'danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::Increase => 'bi-arrow-up-circle',

            self::Decrease => 'bi-arrow-down-circle',
        };
    }
}
