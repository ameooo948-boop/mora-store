<?php

namespace App\Repositories\Eloquent;

use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CouponRepository implements CouponRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10)
    {
        return Coupon::query()

            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%");
            })

            ->when(isset($filters['status']) && $filters['status'] !== '', function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })

            ->when($filters['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            })

            ->orderBy(
                $filters['sort_by'] ?? 'created_at',
                $filters['sort_direction'] ?? 'desc'
            )

            ->paginate($perPage)

            ->withQueryString();
    }

    public function all(): Collection
    {
        return Coupon::latest()->get();
    }

    public function find(int $id): ?Coupon
    {
        return Coupon::find($id);
    }

    public function findByCode(string $code): ?Coupon
    {
        return Coupon::where('code', strtoupper($code))->first();
    }

    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    public function update(Coupon $coupon, array $data): bool
    {
        return $coupon->update($data);
    }

    public function delete(Coupon $coupon): bool
    {
        return $coupon->delete();
    }
}
