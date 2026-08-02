<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\UpdatePasswordRequest;
use App\Http\Requests\Web\Profile\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $service,
    ) {
    }

    public function edit(
        Request $request,
    ) {

        return view(
            'web.profile.edit',
            [

                'user' => $request->user(),

                'statistics' => $this->service
                    ->statistics(
                        $request->user()
                    ),

            ]
        );

    }

    public function update(
        UpdateProfileRequest $request,
    ) {

        $this->service->updateProfile(

            $request->user(),

            $request->validated()

        );

        return back()->with(

            'success',

            'Profile updated successfully.'

        );

    }

    public function password()
    {

        return view(
            'web.profile.password'
        );

    }

    public function updatePassword(
        UpdatePasswordRequest $request,
    ) {

        $this->service->updatePassword(

            $request->user(),

            $request->string(
                'current_password'
            ),

            $request->string(
                'password'
            )

        );

        return redirect()

            ->route('profile.edit')

            ->with(

                'success',

                'Password updated successfully.'

            );

    }
}