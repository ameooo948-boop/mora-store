<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Events\StockMovementCreated;
use App\Models\Product;
use App\Models\StockMovement;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockMovementService
{
    public function __construct(
        protected StockMovementRepositoryInterface $repository,
    ) {}

    public function create(
        Product $product,
        int $beforeQuantity,
        StockMovementType $type,
        int $quantity,
        ?Model $reference = null,
        ?string $notes = null,
    ) {
        if ($notes === null && $reference instanceof \App\Models\Order) {
            $notes = 'Order #' . $reference->order_number;
        }

        $movement = $this->repository->create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'reference_type' => $reference?->getMorphClass(),
            'reference_id' => $reference?->getKey(),
            'type' => $type,
            'quantity' => $quantity,
            'before_quantity' => $beforeQuantity,
            'after_quantity' => $product->quantity,
            'notes' => $notes,
        ]);

        event(new StockMovementCreated($movement));

        return $movement;
    }

    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?StockMovementType $type = null,
    ) {
        return $this->repository->paginate(
            $perPage,
            $search,
            $type
        );
    }

    public function find(
        int $id,
    ): ?StockMovement {
        return $this->repository->find($id);
    }

    public function statistics(): array
    {
        return $this->repository->statistics();
    }
}
