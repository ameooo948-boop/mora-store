<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('brands', BrandController::class)->except('show');
Route::resource('products', ProductController::class)->except('show');

Route::delete(
    'product-images/{productImage}',
    [ProductImageController::class, 'destroy']
)->name('product-images.destroy');
