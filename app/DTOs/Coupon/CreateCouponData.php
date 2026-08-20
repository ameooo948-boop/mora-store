<?php

namespace App\DTOs\Coupon;

use App\Enums\CouponType;
use Carbon\Carbon;

readonly class CreateCouponData
{
    public function __construct(
        public string $code,
        public CouponType $type,
        public float $value,
        public ?float $minimumAmount,
        public ?float $maximumDiscount,
        public ?int $usageLimit,
        public ?Carbon $startsAt,
        public ?Carbon $expiresAt,
        public bool $status,
    ) {}
}
