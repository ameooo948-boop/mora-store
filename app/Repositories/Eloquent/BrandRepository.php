<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository implements BrandRepositoryInterface
{

    public function create(array $data): Brand
    {
        return Brand::create($data);
    }

    public function update(Brand $brand, array $data): bool
    {
        return $brand->update($data);
    }

    public function delete(Brand $brand): bool
    {
        return $brand->delete();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        return Brand::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('sort_order', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getStatistics(): array
    {
        return [
            'total' => Brand::count(),
            'active' => Brand::where('status', true)->count(),
            'inactive' => Brand::where('status', false)->count(),
        ];
    }

    public function getActive(): Collection
    {
        return Brand::where('status', true)->orderBy('sort_order')->get();
    }
}
