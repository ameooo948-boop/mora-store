<?php

namespace App\Providers;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\OrderStatusHistoryRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\CartItemRepository;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\CouponRepository;
use App\Repositories\Eloquent\OrderItemRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\OrderStatusHistoryRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\ProductImageRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\StockMovementRepository;
use App\Repositories\Eloquent\WishlistRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            ProductImageRepositoryInterface::class,
            ProductImageRepository::class
        );

        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );

        $this->app->bind(
            CartItemRepositoryInterface::class,
            CartItemRepository::class
        );

        $this->app->bind(
            OrderItemRepositoryInterface::class,
            OrderItemRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
        );

        $this->app->bind(
            WishlistRepositoryInterface::class,
            WishlistRepository::class
        );

        $this->app->bind(
            CouponRepositoryInterface::class,
            CouponRepository::class
        );

        $this->app->bind(

            PaymentRepositoryInterface::class,

            PaymentRepository::class

        );

        $this->app->bind(
            OrderStatusHistoryRepositoryInterface::class,
            OrderStatusHistoryRepository::class
        );

        $this->app->bind(
            StockMovementRepositoryInterface::class,
            StockMovementRepository::class
        );

        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
