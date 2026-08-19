<?php

namespace App\Listeners;

use App\Events\PasswordResetRequested;
use App\Notifications\PasswordResetNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordResetEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PasswordResetRequested $event): void
    {
        $event->user->notify(
            new PasswordResetNotification($event->token)
        );
    }
}
