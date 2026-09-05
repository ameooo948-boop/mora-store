<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPaymentNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Payment $payment,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [

            'title' => 'New Payment',

            'message' => 'A new payment has been created and is awaiting confirmation.',

            'payment_id' => $this->payment->id,

            'url' => route(
                'admin.payments.show',
                $this->payment
            ),

            'icon' => 'bi-credit-card',

        ];
    }
}
