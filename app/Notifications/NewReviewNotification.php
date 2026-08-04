<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Review $review,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [

            'title' => 'New Review',

            'message' => 'A new review is waiting for approval.',

            'review_id' => $this->review->id,

            'url' => route(
                'admin.reviews.show',
                $this->review
            ),

            'icon' => 'bi-star',

        ];
    }
}
