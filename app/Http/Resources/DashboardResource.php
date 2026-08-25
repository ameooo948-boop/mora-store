<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\StockMovementResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'statistics' => $this->resource['statistics'],

            'revenue_chart' => $this->resource['revenueChart'],

            'orders_chart' => $this->resource['ordersChart'],

            'latest_orders' => OrderResource::collection(
                $this->resource['latestOrders']
            ),

            'latest_payments' => PaymentResource::collection(
                $this->resource['latestPayments']
            ),

            'top_selling_products' => ProductResource::collection(
                $this->resource['topSellingProducts']
            ),

            'low_stock_products' => ProductResource::collection(
                $this->resource['lowStockProducts']
            ),

            'recent_activity' => [
                'orders' => OrderResource::collection(
                    $this->resource['recentActivity']['orders']
                ),

                'payments' => PaymentResource::collection(
                    $this->resource['recentActivity']['payments']
                ),

                'reviews' => ReviewResource::collection(
                    $this->resource['recentActivity']['reviews']
                ),

                'stock' => StockMovementResource::collection(
                    $this->resource['recentActivity']['stock']
                ),
            ],
        ];
    }
}
