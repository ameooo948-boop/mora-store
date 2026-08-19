<?php

namespace App\Listeners;

use App\Events\ProductLowStock;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLowStockNotification implements ShouldQueue
{
    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    public function handle(ProductLowStock $event): void
    {
        $this->notificationService->lowStock($event->product);
    }
}
