<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\AddressController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home')->middleware('auth');


Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

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
});

Route::middleware('auth')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');
});

Route::middleware('auth')->group(function () {

    Route::resource(
        'addresses',
        AddressController::class
    )->except('show');

    Route::patch(
        'addresses/{address}/default',
        [AddressController::class, 'setDefault']
    )->name('addresses.default');
});

Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
});
