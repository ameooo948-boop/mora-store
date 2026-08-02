<?php

namespace App\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function statistics(): array;

    public function revenueChart(): array;

    public function ordersChart(): array;

    public function latestOrders(int $limit = 5);

    public function latestPayments(int $limit = 5);

    public function topSellingProducts(int $limit = 5);

    public function lowStockProducts(int $limit = 5);

    public function recentActivity(
        int $limit = 10,
    );
}
