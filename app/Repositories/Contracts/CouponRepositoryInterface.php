<?php

namespace App\Repositories\Contracts;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

interface CouponRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10);

    public function all(): Collection;

    public function find(int $id): ?Coupon;

    public function findByCode(string $code): ?Coupon;

    public function create(array $data): Coupon;

    public function update(Coupon $coupon, array $data): bool;

    public function delete(Coupon $coupon): bool;
}
