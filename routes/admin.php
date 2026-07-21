<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);

Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('brands', BrandController::class)->except('show');
Route::resource('products', ProductController::class)->except('show');

Route::delete(
    'product-images/{productImage}',
    [ProductImageController::class, 'destroy']
)->name('product-images.destroy');
