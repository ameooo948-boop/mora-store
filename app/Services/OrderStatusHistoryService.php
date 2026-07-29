<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Repositories\Contracts\OrderStatusHistoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderStatusHistoryService
{
    public function __construct(
        protected OrderStatusHistoryRepositoryInterface $repository,
    ) {}

    public function create(
        Order $order,
        OrderStatus $oldStatus,
        OrderStatus $newStatus,
        ?string $notes = null,
    ): OrderStatusHistory {

        return $this->repository->create([

            'order_id' => $order->id,

            'user_id' => Auth::id(),

            'old_status' => $oldStatus,

            'new_status' => $newStatus,

            'notes' => $notes,

            'changed_at' => now(),

        ]);
    }

    public function getByOrder(Order $order): Collection
    {
        return $this->repository->getByOrder($order);
    }
}
