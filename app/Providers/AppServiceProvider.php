<?php

namespace App\Providers;

use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\OrderStatusHistoryRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Eloquent\CartItemRepository;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\CouponRepository;
use App\Repositories\Eloquent\DashboardRepository;
use App\Repositories\Eloquent\OrderItemRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\OrderStatusHistoryRepository;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Eloquent\ProductImageRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\Eloquent\StockMovementRepository;
use App\Repositories\Eloquent\WishlistRepository;
use App\Services\SettingService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $bindings = [
            CategoryRepositoryInterface::class => CategoryRepository::class,
            BrandRepositoryInterface::class => BrandRepository::class,
            ProductRepositoryInterface::class => ProductRepository::class,
            ProductImageRepositoryInterface::class => ProductImageRepository::class,
            CartRepositoryInterface::class => CartRepository::class,
            CartItemRepositoryInterface::class => CartItemRepository::class,
            OrderItemRepositoryInterface::class => OrderItemRepository::class,
            OrderRepositoryInterface::class => OrderRepository::class,
            AddressRepositoryInterface::class => AddressRepository::class,
            WishlistRepositoryInterface::class => WishlistRepository::class,
            CouponRepositoryInterface::class => CouponRepository::class,
            PaymentRepositoryInterface::class => PaymentRepository::class,
            OrderStatusHistoryRepositoryInterface::class => OrderStatusHistoryRepository::class,
            StockMovementRepositoryInterface::class => StockMovementRepository::class,
            ReviewRepositoryInterface::class => ReviewRepository::class,
            DashboardRepositoryInterface::class => DashboardRepository::class,
            SettingRepositoryInterface::class => SettingRepository::class,
        ];

        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    public function boot(): void
    {
        View::composer('web.layouts.navbar', function ($view) {
            $view->with('siteLogo', app(SettingService::class)->value('site_logo'));
        });

        Paginator::useBootstrapFive();
    }
}
