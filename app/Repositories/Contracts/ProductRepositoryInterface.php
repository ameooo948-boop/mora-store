<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{

    public function create(array $data): Product;

    public function update(Product $product, array $data): bool;

    public function delete(Product $product): bool;

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator;

    public function getStatistics(): array;
}
