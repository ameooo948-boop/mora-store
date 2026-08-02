<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfileService
{
    public function updateProfile(
        User $user,
        array $data,
    ): bool {

        if (

            isset($data['avatar']) &&

            $data['avatar'] instanceof \Illuminate\Http\UploadedFile

        ) {

            if (

                $user->avatar &&

                Storage::disk('public')->exists(
                    $user->avatar
                )

            ) {

                Storage::disk('public')->delete(
                    $user->avatar
                );
            }

            $data['avatar'] = $data['avatar']->store(

                'avatars',

                'public'

            );
        } else {

            unset(
                $data['avatar']
            );
        }

        if (

            $user->email !== $data['email']

        ) {

            $data['email_verified_at'] = null;
        }

        return $user->update(

            $data

        );
    }

    public function updatePassword(
        User $user,
        string $currentPassword,
        string $newPassword,
    ): bool {

        if (
            ! Hash::check(
                $currentPassword,
                $user->password
            )
        ) {

            throw ValidationException::withMessages([

                'current_password' => 'Current password is incorrect.',

            ]);
        }

        return $user->update([

            'password' => Hash::make(
                $newPassword
            ),

        ]);
    }

    public function statistics(
        User $user,
    ): array {

        return [

            'orders' => $user->orders()->count(),

            'reviews' => $user->reviews()->count(),

            'addresses' => $user->addresses()->count(),

            'wishlist' => method_exists(
                $user,
                'wishlist'
            )
                ? $user->wishlist()->count()
                : 0,

        ];
    }
}
