<?php

namespace App\Repositories\Contracts;

use App\Models\Brand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{

    public function create(array $data): Brand;

    public function update(Brand $brand, array $data): bool;

    public function delete(Brand $brand): bool;

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator;

    public function getStatistics(): array;

    public function getActive(): Collection;
}