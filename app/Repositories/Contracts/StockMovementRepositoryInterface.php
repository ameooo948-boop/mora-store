<?php

namespace App\Repositories\Contracts;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StockMovementRepositoryInterface
{
    public function create(array $data): StockMovement;

    public function delete(StockMovement $movement): bool;

    public function getByProduct(Product $product);

    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?StockMovementType $type = null,
    ): LengthAwarePaginator;

    public function find(
        int $id,
    ): ?StockMovement;

    public function statistics(): array;
}
