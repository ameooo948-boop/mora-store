<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Admin\AdminOrderController;
use App\Http\Controllers\Api\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\CouponController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\ProductImageController;
use App\Http\Controllers\Api\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\StockMovementController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\StripeWebhookController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('products', AdminProductController::class);
    Route::get('products-form-options', [AdminProductController::class, 'formOptions']);

    Route::apiResource('categories', AdminCategoryController::class);
    Route::get('categories-parents', [AdminCategoryController::class, 'parents']);

    Route::apiResource('brands', AdminBrandController::class);
    Route::apiResource('coupons', CouponController::class);
    Route::apiResource('users', UserController::class);
    Route::get('roles', [UserController::class, 'roles']);

    Route::apiResource('reviews', AdminReviewController::class)->only(['index', 'show']);
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve']);
    Route::post('reviews/{review}/reject', [AdminReviewController::class, 'reject']);

    Route::apiResource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus']);

    Route::apiResource('payments', AdminPaymentController::class)->only(['index', 'show']);
    Route::apiResource('stock-movements', StockMovementController::class)->only(['index', 'show']);

    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('settings', [SettingController::class, 'index']);
    Route::put('settings', [SettingController::class, 'update']);

    Route::delete('product-images/{productImage}', [ProductImageController::class, 'destroy']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('addresses', AddressController::class);
    Route::post('addresses/{address}/default', [AddressController::class, 'setDefault']);

    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/{product}', [CartController::class, 'store']);
    Route::patch('cart/{product}', [CartController::class, 'update']);
    Route::delete('cart/{product}', [CartController::class, 'destroy']);
    Route::delete('cart', [CartController::class, 'clear']);

    Route::get('checkout', ['App\\Http\\Controllers\\Api\\CheckoutController', 'index']);
    Route::post('checkout', ['App\\Http\\Controllers\\Api\\CheckoutController', 'store']);
    Route::post('checkout/coupon', ['App\\Http\\Controllers\\Api\\CheckoutController', 'applyCoupon']);
    Route::delete('checkout/coupon', ['App\\Http\\Controllers\\Api\\CheckoutController', 'removeCoupon']);

    Route::apiResource('orders', OrderController::class)->only(['index', 'show']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::patch('notifications/{id}/read', [NotificationController::class, 'read']);
    Route::patch('notifications/read-all', [NotificationController::class, 'readAll']);

    Route::get('profile', [ProfileController::class, 'edit']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('profile/password', [ProfileController::class, 'updatePassword']);

    Route::post('products/{product}/reviews', [ReviewController::class, 'store']);
    Route::put('reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/{product}', [WishlistController::class, 'toggle']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    Route::get('brands', [BrandController::class, 'index']);
    Route::get('brands/{brand}', [BrandController::class, 'show']);

    Route::get('home', [HomeController::class, 'index']);

    Route::get('payments/{payment}/success', [PaymentController::class, 'success']);
    Route::get('payments/{payment}/cancel', [PaymentController::class, 'cancel']);
});

Route::post('stripe/webhook', StripeWebhookController::class);
