<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
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
