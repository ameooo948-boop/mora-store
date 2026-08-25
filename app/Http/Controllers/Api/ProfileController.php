<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\UpdatePasswordRequest;
use App\Http\Requests\Web\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $service,
    ) {}

    public function edit(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user()),
            'statistics' => $this->service->statistics($request->user()),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $this->service->updateProfile(
            $request->user(),
            $request->validated()
        );

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => new UserResource($request->user()->fresh()),
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->service->updatePassword(
            $request->user(),
            $request->string('current_password'),
            $request->string('password')
        );

        return response()->json([
            'message' => 'Password updated successfully.',
        ]);
    }
}
