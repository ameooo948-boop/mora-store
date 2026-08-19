<?php

namespace App\Listeners;

use App\Events\ReviewCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewReviewNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    public function handle(ReviewCreated $event): void
    {
        $this->notificationService->newReview($event->review);
    }
}
