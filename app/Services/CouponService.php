<?php

namespace App\Services;

use App\DTOs\Coupon\CreateCouponData;
use App\DTOs\Coupon\UpdateCouponData;
use App\Enums\CouponType;
use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CouponService
{
    public function __construct(
        protected CouponRepositoryInterface $couponRepository,
    ) {}

    public function paginate(array $filters = [], int $perPage = 10)
    {
        return $this->couponRepository->paginate($filters, $perPage);
    }

    public function all(): Collection
    {
        return $this->couponRepository->all();
    }

    public function find(int $id): ?Coupon
    {
        return $this->couponRepository->find($id);
    }

    public function findByCode(string $code): ?Coupon
    {
        return $this->couponRepository->findByCode($code);
    }

    public function create(CreateCouponData $data): Coupon
    {
        return $this->couponRepository->create([
            'code' => strtoupper($data->code),
            'type' => $data->type,
            'value' => $data->value,
            'minimum_amount' => $data->minimumAmount,
            'maximum_discount' => $data->maximumDiscount,
            'usage_limit' => $data->usageLimit,
            'starts_at' => $data->startsAt,
            'expires_at' => $data->expiresAt,
            'status' => $data->status,
        ]);
    }

    public function update(
        Coupon $coupon,
        UpdateCouponData $data,
    ): bool {
        return $this->couponRepository->update(
            $coupon,
            [
                'code' => strtoupper($data->code),
                'type' => $data->type,
                'value' => $data->value,
                'minimum_amount' => $data->minimumAmount,
                'maximum_discount' => $data->maximumDiscount,
                'usage_limit' => $data->usageLimit,
                'starts_at' => $data->startsAt,
                'expires_at' => $data->expiresAt,
                'status' => $data->status,
            ]
        );
    }

    public function delete(Coupon $coupon): bool
    {
        return $this->couponRepository->delete($coupon);
    }

    public function validateCoupon(Coupon $coupon, float $subtotal): void
    {
        if (! $coupon->status) {
            throw ValidationException::withMessages([
                'coupon' => __('Coupon is inactive.'),
            ]);
        }

        if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
            throw ValidationException::withMessages([
                'coupon' => __('Coupon is not available yet.'),
            ]);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            throw ValidationException::withMessages([
                'coupon' => __('Coupon has expired.'),
            ]);
        }

        if (
            $coupon->usage_limit !== null &&
            $coupon->used_count >= $coupon->usage_limit
        ) {
            throw ValidationException::withMessages([
                'coupon' => __('Coupon usage limit has been reached.'),
            ]);
        }

        if (
            $coupon->minimum_amount !== null &&
            $subtotal < $coupon->minimum_amount
        ) {
            throw ValidationException::withMessages([
                'coupon' => __('Minimum order amount has not been reached.'),
            ]);
        }
    }

    public function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === CouponType::FIXED) {
            return min($coupon->value, $subtotal);
        }

        $discount = ($subtotal * $coupon->value) / 100;

        if (
            $coupon->maximum_discount !== null &&
            $discount > $coupon->maximum_discount
        ) {
            $discount = $coupon->maximum_discount;
        }

        return round($discount, 2);
    }

    public function applyCoupon(string $code, float $subtotal): array
    {
        $coupon = $this->findByCode($code);

        if (! $coupon) {
            throw ValidationException::withMessages([
                'coupon' => __('Coupon not found.'),
            ]);
        }

        $this->validateCoupon($coupon, $subtotal);

        $discount = $this->calculateDiscount($coupon, $subtotal);

        return [
            'coupon' => $coupon,
            'discount' => $discount,
            'total' => max(0, $subtotal - $discount),
        ];
    }

    public function incrementUsedCount(Coupon $coupon): void
    {
        $coupon->increment('used_count');
    }

    public function findByCodeForUpdate(string $code): ?Coupon
    {
        return $this->couponRepository
            ->findByCodeForUpdate($code);
    }
}
