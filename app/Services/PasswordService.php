<?php

namespace App\Services;

use App\Events\PasswordResetRequested;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordService
{
    public function sendResetLink(array $credentials): array
    {
        $status = Password::sendResetLink(
            $credentials,
            function ($user, $token) {
                event(
                    new PasswordResetRequested(
                        $user,
                        $token
                    )
                );
            }
        );

        return [
            'success' => $status === Password::RESET_LINK_SENT,
            'message' => __($status),
        ];
    }

    public function resetPassword(array $data): array
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {

                $user->forceFill([
                    'password' => $password,
                ])->save();

                $user->setRememberToken(
                    Str::random(60)
                );
            }
        );

        return [
            'success' => $status === Password::PASSWORD_RESET,
            'message' => __($status),
        ];
    }
}