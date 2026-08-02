<?php

namespace App\Services;

use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected DashboardRepositoryInterface $repository,
    ) {}

    public function dashboard(): array
    {
        return [

            'statistics' => $this->repository->statistics(),

            'revenueChart' => $this->repository->revenueChart(),

            'ordersChart' => $this->repository->ordersChart(),

            'latestOrders' => $this->repository->latestOrders(),

            'latestPayments' => $this->repository->latestPayments(),

            'topSellingProducts' => $this->repository->topSellingProducts(),

            'lowStockProducts' => $this->repository->lowStockProducts(),

            'recentActivity' => $this->repository->recentActivity(),

        ];
    }
}
