<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminsAboutNewOrder implements ShouldQueue
{
    public function __construct(
        private readonly NotificationService $notificationService,
    ) {}

    public function handle(OrderCreated $event): void
    {
        $this->notificationService->newOrder(
            $event->order
        );
    }
}
