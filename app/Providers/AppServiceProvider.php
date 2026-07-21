<?php

namespace App\Providers;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\CartItemRepository;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\OrderItemRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ProductImageRepository;
use App\Repositories\Eloquent\ProductRepository;
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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
