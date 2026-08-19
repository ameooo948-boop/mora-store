<?php

namespace App\Listeners;

use App\Events\PaymentCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewPaymentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    public function handle(PaymentCreated $event): void
    {
        $this->notificationService->newPayment($event->payment);
    }
}
