<?php

namespace App\Repositories\Eloquent;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\StockMovement;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class StockMovementRepository implements StockMovementRepositoryInterface
{
    public function create(array $data): StockMovement
    {
        return StockMovement::create($data);
    }

    public function delete(StockMovement $movement): bool
    {
        return $movement->delete();
    }

    public function getByProduct(Product $product): Collection
    {
        return $product
            ->stockMovements()
            ->with([
                'user',
                'reference',
            ])
            ->latest()
            ->get();
    }

    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?StockMovementType $type = null,
    ): LengthAwarePaginator {

        return StockMovement::query()

            ->with([
                'product',
                'user',
                'reference',
            ])

            ->when($search, function ($query) use ($search) {

                $query->whereHas('product', function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");
                });
            })

            ->when($type, function ($query) use ($type) {

                $query->where(
                    'type',
                    $type
                );
            })

            ->latest()

            ->paginate($perPage)

            ->withQueryString();
    }

    public function find(
        int $id,
    ): ?StockMovement {
        return StockMovement::with([
            'product',
            'user',
            'reference',
        ])->find($id);
    }

    public function statistics(): array
    {
        return [

            'total' => StockMovement::count(),

            'increase' => StockMovement::where(
                'type',
                StockMovementType::Increase
            )->count(),

            'decrease' => StockMovement::where(
                'type',
                StockMovementType::Decrease
            )->count(),

        ];
    }
}
