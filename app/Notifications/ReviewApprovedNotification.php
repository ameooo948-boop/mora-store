<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReviewApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Review $review,
    ) {}

    public function via(
        object $notifiable,
    ): array {

        return config(
            'notifications.channels',
            [
                'database',
            ]
        );
    }

    public function toArray(
        object $notifiable,
    ): array {

        return [

            'title' => 'Review Approved',

            'message' => 'Your review has been approved and is now visible to other customers.',

            'review_id' => $this->review->id,

            'product_id' => $this->review->product_id,

            'url' => route(
                'products.show',
                $this->review->product
            ),

            'icon' => 'bi-star-fill',

        ];
    }
}
