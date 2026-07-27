<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';

    case Paid = 'paid';

    case Failed = 'failed';

    case Refunded = 'refunded';

    public function isPending(): bool
    {
        return $this === self::Pending;
    }

    public function isPaid(): bool
    {
        return $this === self::Paid;
    }

    public function isFailed(): bool
    {
        return $this === self::Failed;
    }

    public function isRefunded(): bool
    {
        return $this === self::Refunded;
    }

    public function badge(): string
    {
        return match ($this) {

            self::Pending => 'warning',

            self::Paid => 'success',

            self::Failed => 'danger',

            self::Refunded => 'info',
        };
    }

    public function label(): string
    {
        return match ($this) {

            self::Pending => 'Pending',

            self::Paid => 'Paid',

            self::Failed => 'Failed',

            self::Refunded => 'Refunded',
        };
    }
}
