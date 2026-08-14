<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Notifications\LowStockNotification;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewPaymentNotification;
use App\Notifications\NewReviewNotification;
use App\Notifications\OrderDeliveredNotification;
use App\Notifications\OrderProcessingNotification;
use App\Notifications\OrderShippedNotification;
use Illuminate\Notifications\Notification;

class NotificationService
{
    public function newOrder(
        Order $order,
    ): void {

        $this->notifyAdmins(

            new NewOrderNotification(
                $order
            )

        );
    }

    public function unreadCount(
        User $user,
    ): int {

        return $user->unreadNotifications()

            ->count();
    }

    public function latest(
        User $user,
        int $limit = 10,
    ) {
        return $user->notifications()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take($limit)
            ->get();
    }

    public function markAsRead(
        User $user,
        string $id,
    ): void {

        $notification = $user->notifications()

            ->findOrFail($id);

        $notification->markAsRead();
    }

    public function markAllAsRead(
        User $user,
    ): void {

        $user->unreadNotifications()

            ->update([

                'read_at' => now(),

            ]);
    }

    public function newPayment(
        Payment $payment,
    ): void {

        $this->notifyAdmins(

            new NewPaymentNotification(
                $payment
            )

        );
    }

    public function newReview(
        Review $review,
    ): void {

        $this->notifyAdmins(

            new NewReviewNotification(
                $review
            )

        );
    }

    public function lowStock(
        Product $product,
    ): void {

        $this->notifyAdmins(

            new LowStockNotification(
                $product
            )

        );
    }

    private function notifyAdmins(
        Notification $notification,
    ): void {

        User::role('admin')

            ->get()

            ->each(function ($admin) use ($notification) {

                $admin->notify(
                    $notification
                );
            });
    }

    public function orderStatusChanged(
        Order $order,
    ): void {

        match ($order->status) {

            OrderStatus::Shipped =>

            $order->user->notify(

                new OrderShippedNotification(
                    $order
                )

            ),

            OrderStatus::Delivered =>

            $order->user->notify(

                new OrderDeliveredNotification(
                    $order
                )

            ),

            OrderStatus::Processing =>

            $order->user->notify(

                new OrderProcessingNotification(
                    $order
                )

            ),

            default => null,
        };
    }

    public function paginate(
        User $user,
        int $perPage = 15,
    ) {
        return $user->notifications()

            ->latest()

            ->paginate($perPage)

            ->withQueryString();
    }
}
