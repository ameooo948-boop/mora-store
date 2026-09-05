<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Console\Command;

class ExpireUnpaidOrders extends Command
{
    protected $signature = 'orders:expire-unpaid';

    protected $description = 'Cancel expired unpaid Stripe orders and release their inventory.';

    public function handle(OrderService $orderService): int
    {
        $cutoff = now()->subMinutes(
            config('app.stripe_checkout_timeout_minutes')
        );

        $orderIds = Order::query()
            ->where('status', OrderStatus::Pending)
            ->whereHas('payment', function ($query) use ($cutoff) {
                $query->where('payment_method', PaymentMethod::Stripe)
                    ->where('status', PaymentStatus::Pending)
                    ->where('created_at', '<=', $cutoff);
            })
            ->pluck('id');

        $expired = 0;

        foreach ($orderIds as $orderId) {
            $expired += $orderService->expireUnpaidOrder($orderId) ? 1 : 0;
        }

        $this->info("Expired {$expired} unpaid order(s).");

        return self::SUCCESS;
    }
}
