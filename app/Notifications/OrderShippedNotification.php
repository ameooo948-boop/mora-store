<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification
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

            'title' => 'Order Shipped',

            'message' => 'Your order has been shipped.',

            'order_id' => $this->order->id,

            'order_number' => $this->order->order_number,

            'url' => route(
                'orders.show',
                $this->order
            ),

            'icon' => 'bi-truck',

        ];
    }
}
