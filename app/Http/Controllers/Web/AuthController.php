<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\RegisterRequest;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        $siteLogo = app()->make(SettingService::class)
            ->value('site_logo');

        return view('web.auth.register', compact('siteLogo'));
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        event(new Registered($request->user()));

        return redirect()->route('home');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->safe()->only([
            'email',
            'password',
        ]);

        if (! Auth::attempt($credentials)) {

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);

        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {

            Auth::logout();

            return redirect()
                ->route('verification.notice')
                ->with(
                    'success',
                    'Please verify your email address before continuing.'
                );
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginForm()
    {
        $siteLogo = app()->make(SettingService::class)
            ->value('site_logo');

        return view('web.auth.login', compact('siteLogo'));
    }
}
