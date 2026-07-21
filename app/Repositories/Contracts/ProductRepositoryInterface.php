<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{

    public function create(array $data): Product;

    public function update(Product $product, array $data): bool;

    public function delete(Product $product): bool;

    public function paginate(
        ?string $search = null,
        ?int $category = null,
        ?int $status = null,
    ): LengthAwarePaginator;

    public function getStatistics(): array;

    public function latest(int $limit = 8);
}
