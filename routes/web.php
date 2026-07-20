<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard')->middleware('auth');


Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
