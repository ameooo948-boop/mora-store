<?php

use App\Events\PasswordResetRequested;
use App\Http\Controllers\Web\AddressController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\StripeWebhookController;
use App\Http\Controllers\Web\WishlistController;
use App\Services\SettingService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index'])
    ->name('home')->middleware('auth', 'verified');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/carts', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/carts/{product}', [CartController::class, 'store'])
        ->name('cart.store');

    Route::put('/carts/{product}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/carts/{product}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::delete('/carts', [CartController::class, 'clear'])
        ->name('cart.clear');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::resource(
        'addresses',
        AddressController::class
    )->except('show');

    Route::patch(
        'addresses/{address}/default',
        [AddressController::class, 'setDefault']
    )->name('addresses.default');

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])
        ->name('checkout.coupon.store');

    Route::delete('/checkout/coupon', [CheckoutController::class, 'removeCoupon'])
        ->name('checkout.coupon.destroy');

    Route::get(
        'wishlist',
        [WishlistController::class, 'index']
    )->name('wishlist.index');

    Route::post(
        'wishlist/{product}',
        [WishlistController::class, 'toggle']
    )->name('wishlist.toggle');

    Route::get(
        '/products',
        [ProductController::class, 'index']
    )->name('products.index');

    Route::get(
        '/products/{product}',
        [ProductController::class, 'show']
    )->name('products.show');

    Route::post(
        'products/{product}/reviews',
        [ReviewController::class, 'store']
    )->name('reviews.store');

    Route::put(
        'reviews/{review}',
        [ReviewController::class, 'update']
    )->name('reviews.update');

    Route::delete(
        'reviews/{review}',
        [ReviewController::class, 'destroy']
    )->name('reviews.destroy');

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::put(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::get(
        '/profile/password',
        [ProfileController::class, 'password']
    )->name('profile.password');

    Route::put(
        '/profile/password',
        [ProfileController::class, 'updatePassword']
    )->name('profile.password.update');
});

Route::middleware(['auth', 'verified'])
    ->prefix('payments')
    ->name('payments.')
    ->group(function () {

        Route::get(
            '/{payment}/success',
            [PaymentController::class, 'success']
        )->name('success');

        Route::get(
            '/{payment}/cancel',
            [PaymentController::class, 'cancel']
        )->name('cancel');
    });

Route::post(
    '/stripe/webhook',
    StripeWebhookController::class
)->name('stripe.webhook');

Route::prefix('notifications')
    ->middleware(['auth', 'verified'])

    ->name('notifications.')

    ->group(function () {

        Route::get(
            '/',
            [NotificationController::class, 'index']
        )->name('index');

        Route::patch(
            '/{notification}',
            [NotificationController::class, 'read']
        )->name('read');

        Route::patch(
            '/',
            [NotificationController::class, 'readAll']
        )->name('read-all');
    });

Route::get('/forgot-password', function () {
    $siteLogo = app()->make(SettingService::class)
        ->value('site_logo');

    return view('web.auth.forgot-password', compact('siteLogo'));
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {

    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email'),
        function ($user, $token) {
            event(new PasswordResetRequested($user, $token));
        }
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {

    $siteLogo = app()->make(SettingService::class)
        ->value('site_logo');

    return view('web.auth.reset-password', compact(
        'token',
        'siteLogo'
    ));
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $status = Password::reset(
        $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ),
        function ($user, $password) {

            $user->forceFill([
                'password' => $password,
            ])->save();

            $user->setRememberToken(
                Str::random(60)
            );
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()
            ->route('login')
            ->with('success', __($status))
        : back()
            ->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::get('/email/verify', function () {

    $siteLogo = app()->make(SettingService::class)
        ->value('site_logo');

    return view(
        'web.auth.verify-email',
        compact('siteLogo')
    );

})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    return redirect()
        ->route('home')
        ->with('success', 'Your email has been verified successfully.');

})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'A new verification link has been sent to your email.');

})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
