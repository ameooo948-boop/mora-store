<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\PasswordService;
use App\Services\SettingService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function __construct(
        protected PasswordService $passwordService,
        protected SettingService $settingService,
    ) {}

    public function forgotPassword()
    {
        $siteLogo = $this->settingService->value('site_logo');

        return view(
            'web.auth.forgot-password',
            compact('siteLogo')
        );
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = $this->passwordService->sendResetLink(
            $request->only('email')
        );

        return $status['success']
            ? back()->with('success', $status['message'])
            : back()->withErrors([
                'email' => $status['message'],
            ]);
    }


    public function resetPassword(string $token)
    {
        $siteLogo = $this->settingService->value('site_logo');

        return view(
            'web.auth.reset-password',
            compact('token', 'siteLogo')
        );
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $result = $this->passwordService->resetPassword(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            )
        );

        if ($result['success']) {
            return redirect()
                ->route('login')
                ->with('success', $result['message']);
        }

        return back()->withErrors([
            'email' => $result['message'],
        ]);
    }


    public function verificationNotice()
    {
        $siteLogo = $this->settingService->value('site_logo');

        return view(
            'web.auth.verify-email',
            compact('siteLogo')
        );
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Your email has been verified successfully.'
            );
    }

    public function sendVerificationNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with(
            'success',
            'A new verification link has been sent to your email.'
        );
    }
}
