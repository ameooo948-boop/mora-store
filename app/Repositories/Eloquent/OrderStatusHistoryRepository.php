<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Repositories\Contracts\OrderStatusHistoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderStatusHistoryRepository implements OrderStatusHistoryRepositoryInterface
{
    public function create(array $data): OrderStatusHistory
    {
        return OrderStatusHistory::create($data);
    }

    public function getByOrder(Order $order): Collection
    {
        return $order->statusHistories()->get();
    }
}
