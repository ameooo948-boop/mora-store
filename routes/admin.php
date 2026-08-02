<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\StockMovementController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);

Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');

Route::resource('categories', CategoryController::class);
Route::resource('brands', BrandController::class);
Route::resource('products', ProductController::class);

Route::delete(
    'product-images/{productImage}',
    [ProductImageController::class, 'destroy']
)->name('product-images.destroy');

Route::get('/orders', [AdminOrderController::class, 'index'])
    ->name('orders.index');

Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
    ->name('orders.show');


Route::patch(
    'orders/{order}/status',
    [AdminOrderController::class, 'updateStatus']
)->name('orders.status');

Route::resource('coupons', CouponController::class);

Route::resource('payments', PaymentController::class)
    ->only([
        'index',
        'show',
    ]);

Route::resource('stock-movements', StockMovementController::class)
    ->only([
        'index',
        'show',
    ]);

Route::resource('reviews', ReviewController::class)
    ->only([
        'index',
        'show',
    ]);

Route::patch(
    'reviews/{review}/approve',
    [ReviewController::class, 'approve']
)->name('reviews.approve');

Route::patch(
    'reviews/{review}/reject',
    [ReviewController::class, 'reject']
)->name('reviews.reject');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');
