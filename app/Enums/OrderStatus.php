<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';

    case Processing = 'processing';

    case Shipped = 'shipped';

    case Delivered = 'delivered';

    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {

            self::Pending => 'Pending',

            self::Processing => 'Processing',

            self::Shipped => 'Shipped',

            self::Delivered => 'Delivered',

            self::Cancelled => 'Cancelled',
        };
    }

    public function badge(): string
    {
        return match ($this) {

            self::Pending => 'bg-warning',

            self::Processing => 'bg-info',

            self::Shipped => 'bg-primary',

            self::Delivered => 'bg-success',

            self::Cancelled => 'bg-danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::Pending => 'bi-clock',

            self::Processing => 'bi-gear',

            self::Shipped => 'bi-truck',

            self::Delivered => 'bi-check-circle',

            self::Cancelled => 'bi-x-circle',
        };
    }

    public function transitions(): array
    {
        return match ($this) {

            self::Pending => [
                self::Processing,
                self::Cancelled,
            ],

            self::Processing => [
                self::Shipped,
                self::Cancelled,
            ],

            self::Shipped => [
                self::Delivered,
            ],

            self::Delivered => [],

            self::Cancelled => [],
        };
    }
}
