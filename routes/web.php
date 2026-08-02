<?php

use App\Http\Controllers\Web\AddressController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\StripeWebhookController;
use App\Http\Controllers\Web\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home')->middleware('auth');


Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {

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

Route::middleware('auth')
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
