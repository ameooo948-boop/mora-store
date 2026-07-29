<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Database\Eloquent\Collection;

interface OrderStatusHistoryRepositoryInterface
{
    public function create(array $data): OrderStatusHistory;

    public function getByOrder(Order $order): Collection;
}
