<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged as OrderStatusChangedEvent;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderStatusChangedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    public function handle(OrderStatusChangedEvent $event): void
    {
        $this->notificationService->orderStatusChanged($event->order);
    }
}
