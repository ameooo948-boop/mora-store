<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\OrderItem;

interface OrderItemRepositoryInterface
{
    public function create(array $data): OrderItem;

    public function createMany(Order $order, array $items): void;
}