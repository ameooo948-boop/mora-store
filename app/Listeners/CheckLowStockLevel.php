<?php

namespace App\Listeners;

use App\Events\ProductLowStock;
use App\Events\StockMovementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckLowStockLevel implements ShouldQueue
{
    public function handle(StockMovementCreated $event): void
    {
        $product = $event->stockMovement->product;

        $threshold = config('inventory.low_stock_threshold');

        if ($product->quantity <= $threshold) {
            event(new ProductLowStock($product));
        }
    }
}