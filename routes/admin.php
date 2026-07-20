<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('brands', BrandController::class)->except('show');
