<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderItemRepositoryInterface;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function create(array $data): OrderItem
    {
        return OrderItem::create($data);
    }

    public function createMany(Order $order, array $items): void
    {
        $order->items()->createMany($items);
    }
}
