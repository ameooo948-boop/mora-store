<?php

namespace App\Repositories\Eloquent;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\StockMovement;
use App\Models\User;
use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{

    public function statistics(): array
    {
        return [

            'revenue' => Payment::query()

                ->where(
                    'status',
                    PaymentStatus::Paid
                )

                ->sum('amount'),

            'orders' => Order::count(),

            'customers' => User::role('customer')->count(),

            'products' => Product::count(),

        ];
    }

    public function revenueChart(): array
    {
        $data = Payment::query()

            ->selectRaw('MONTH(created_at) as month')

            ->selectRaw('SUM(amount) as total')

            ->where(
                'status',
                PaymentStatus::Paid
            )

            ->whereYear(
                'created_at',
                now()->year
            )

            ->groupByRaw('MONTH(created_at)')

            ->pluck(
                'total',
                'month'
            )

            ->toArray();

        $months = [];

        for ($i = 1; $i <= 12; $i++) {

            $months[now()->startOfYear()->month($i)->format('M')] =
                $data[$i] ?? 0;
        }

        return $months;
    }

    public function ordersChart(): array
    {
        $data = Order::query()

            ->selectRaw('DATE(created_at) as date')

            ->selectRaw('COUNT(*) as total')

            ->where(
                'created_at',
                '>=',
                now()->subDays(29)->startOfDay()
            )

            ->groupByRaw('DATE(created_at)')

            ->pluck(
                'total',
                'date'
            )

            ->toArray();

        $days = [];

        for ($i = 29; $i >= 0; $i--) {

            $date = now()
                ->subDays($i)
                ->format('Y-m-d');

            $days[now()
                ->subDays($i)
                ->format('d M')] = $data[$date] ?? 0;
        }

        return $days;
    }
    public function latestOrders(
        int $limit = 5
    ) {
        return Order::query()

            ->with('user')

            ->latest()

            ->take($limit)

            ->get();
    }

    public function latestPayments(
        int $limit = 5
    ) {
        return Payment::query()

            ->with([
                'order.user',
            ])

            ->latest()

            ->take($limit)

            ->get();
    }

    public function topSellingProducts(
        int $limit = 5
    ) {
        return OrderItem::query()

            ->selectRaw('product_id')

            ->selectRaw('SUM(quantity) as sold')

            ->with('product')

            ->groupBy('product_id')

            ->orderByDesc('sold')

            ->take($limit)

            ->get();
    }

    public function lowStockProducts(
        int $limit = 5
    ) {
        return Product::query()

            ->where(
                'quantity',
                '<=',
                5
            )

            ->orderBy('quantity')

            ->take($limit)

            ->get();
    }

public function recentActivity(
    int $limit = 10,
)
{
    return [

        'orders' => Order::latest()
            ->take(3)
            ->get(),

        'payments' => Payment::latest()
            ->take(3)
            ->get(),

        'reviews' => Review::latest()
            ->take(3)
            ->get(),

        'stock' => StockMovement::latest()
            ->take(3)
            ->get(),

    ];
}
}
