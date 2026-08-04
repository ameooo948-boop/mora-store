<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderProcessingNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Order $order,
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

            'title' => 'Order Processing',

            'message' => 'Your order is being processed.',

            'order_id' => $this->order->id,

            'order_number' => $this->order->order_number,

            'url' => route(
                'orders.show',
                $this->order
            ),

            'icon' => 'bi-gear-fill',

        ];
    }
}
