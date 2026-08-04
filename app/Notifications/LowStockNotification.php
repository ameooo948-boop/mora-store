<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Product $product,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [

            'title' => 'Low Stock',

            'message' => "{$this->product->name} is running out of stock.",

            'product_id' => $this->product->id,

            'url' => route(
                'admin.products.edit',
                $this->product
            ),

            'icon' => 'bi-exclamation-triangle',

        ];
    }
}
