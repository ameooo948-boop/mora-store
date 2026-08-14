<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view payments');
    }

    public function view(User $user, Payment $payment): bool
    {
        return $payment->order->user_id === $user->id
            || $user->can('view payments');
    }
}
