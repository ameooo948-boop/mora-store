<?php

namespace App\Repositories\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function create(array $data): Product;

    public function update(Product $product, array $data): bool;

    public function delete(Product $product): bool;

    public function paginateAdmin(
        ?string $search = null,
        ?int $category = null,
        ?int $brand = null,
        ?int $status = null,
    );

    public function paginateStore(
        ?string $search = null,
        ?int $category = null,
        ?int $brand = null,
        ?string $sort = null,
    );

    public function getStatistics(): array;

    public function latest(int $limit = 8);

    public function find(Product $product);

    public function related(
        Product $product,
        int $limit = 4
    );
}
