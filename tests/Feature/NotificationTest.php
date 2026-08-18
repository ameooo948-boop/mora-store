<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Events\OrderCreated;
use App\Listeners\NotifyAdminsAboutNewOrder;
use App\Models\Order;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
    }

    public function test_new_order_notification_is_sent_to_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->create();

        $admin->assignRole('admin');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

            'status' => OrderStatus::Pending,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        app(NotificationService::class)
            ->newOrder($order);

        Notification::assertSentTo(
            $admin,
            \App\Notifications\NewOrderNotification::class
        );

        Notification::assertNotSentTo(
            $user,
            \App\Notifications\NewOrderNotification::class
        );
    }

    public function test_new_order_listener_is_queued(): void
    {
        $listener = new NotifyAdminsAboutNewOrder(
            app(\App\Services\NotificationService::class)
        );

        $this->assertInstanceOf(
            ShouldQueue::class,
            $listener
        );
    }

    public function test_order_created_event_dispatches_after_commit(): void
    {
        $order = new Order();

        $event = new OrderCreated($order);

        $this->assertInstanceOf(
            ShouldDispatchAfterCommit::class,
            $event
        );
    }

    public function test_new_payment_notification_is_sent_to_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->create();

        $admin->assignRole('admin');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

            'status' => OrderStatus::Pending,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $payment = \App\Models\Payment::create([
            'order_id' => $order->id,
            'amount' => 100,
            'payment_method' => \App\Enums\PaymentMethod::CashOnDelivery,
            'status' => \App\Enums\PaymentStatus::Paid,
            'paid_at' => now(),
        ]);

        app(NotificationService::class)
            ->newPayment($payment);

        Notification::assertSentTo(
            $admin,
            \App\Notifications\NewPaymentNotification::class
        );

        Notification::assertNotSentTo(
            $user,
            \App\Notifications\NewPaymentNotification::class
        );
    }

    public function test_new_review_notification_is_sent_to_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->create();

        $admin->assignRole('admin');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = \App\Models\Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $review = \App\Models\Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent product.',
            'status' => \App\Enums\ReviewStatus::Pending,
        ]);

        app(NotificationService::class)
            ->newReview($review);

        Notification::assertSentTo(
            $admin,
            \App\Notifications\NewReviewNotification::class
        );

        Notification::assertNotSentTo(
            $user,
            \App\Notifications\NewReviewNotification::class
        );
    }

    public function test_low_stock_notification_is_sent_to_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->create();

        $admin->assignRole('admin');

        $product = \App\Models\Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 2,
                'status' => true,
            ]);

        app(NotificationService::class)
            ->lowStock($product);

        Notification::assertSentTo(
            $admin,
            \App\Notifications\LowStockNotification::class
        );
    }

    public function test_processing_order_notification_is_sent_to_customer(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $admin = User::factory()->create();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

            'status' => OrderStatus::Processing,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        app(NotificationService::class)
            ->orderStatusChanged($order);

        Notification::assertSentTo(
            $user,
            \App\Notifications\OrderProcessingNotification::class
        );

        Notification::assertNotSentTo(
            $admin,
            \App\Notifications\OrderProcessingNotification::class
        );
    }

    public function test_shipped_order_notification_is_sent_to_customer(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

            'status' => OrderStatus::Shipped,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        app(NotificationService::class)
            ->orderStatusChanged($order);

        Notification::assertSentTo(
            $user,
            \App\Notifications\OrderShippedNotification::class
        );
    }

    public function test_delivered_order_notification_is_sent_to_customer(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

            'status' => OrderStatus::Delivered,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        app(NotificationService::class)
            ->orderStatusChanged($order);

        Notification::assertSentTo(
            $user,
            \App\Notifications\OrderDeliveredNotification::class
        );
    }

    public function test_unread_count_returns_number_of_unread_notifications(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $user->notify(
            new \App\Notifications\OrderProcessingNotification(
                Order::create([
                    'user_id' => $user->id,
                    'order_number' => 'TEST-' . uniqid(),

                    'subtotal' => 100,
                    'shipping' => 0,
                    'discount' => 0,
                    'total' => 100,

                    'status' => OrderStatus::Processing,

                    'shipping_name' => 'Test User',
                    'shipping_phone' => '01012345678',
                    'shipping_country' => 'Egypt',
                    'shipping_state' => 'Dakahlia',
                    'shipping_city' => 'Mansoura',
                    'shipping_address' => 'Test Address',
                    'shipping_postal_code' => '35511',
                ])
            )
        );

        $count = app(NotificationService::class)
            ->unreadCount($user);

        $this->assertSame(1, $count);
    }

    public function test_user_can_mark_notification_as_read(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),

            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,

            'status' => OrderStatus::Processing,

            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $user->notify(
            new \App\Notifications\OrderProcessingNotification($order)
        );

        $notification = $user->notifications()->first();

        $this->assertNull($notification->read_at);

        app(NotificationService::class)->markAsRead(
            $user,
            $notification->id
        );

        $notification->refresh();

        $this->assertNotNull($notification->read_at);

        $this->assertSame(
            0,
            app(NotificationService::class)->unreadCount($user)
        );
    }

    public function test_user_can_mark_all_notifications_as_read(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order1 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),
            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,
            'status' => OrderStatus::Processing,
            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $order2 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),
            'subtotal' => 200,
            'shipping' => 0,
            'discount' => 0,
            'total' => 200,
            'status' => OrderStatus::Shipped,
            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $user->notify(
            new \App\Notifications\OrderProcessingNotification($order1)
        );

        $user->notify(
            new \App\Notifications\OrderShippedNotification($order2)
        );

        $service = app(NotificationService::class);

        $this->assertSame(
            2,
            $service->unreadCount($user)
        );

        $service->markAllAsRead($user);

        $this->assertSame(
            0,
            $service->unreadCount($user)
        );

        $this->assertCount(
            2,
            $user->notifications()->whereNotNull('read_at')->get()
        );
    }

    public function test_latest_returns_notifications_in_latest_order(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $order1 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),
            'subtotal' => 100,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,
            'status' => OrderStatus::Processing,
            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $user->notify(
            new \App\Notifications\OrderProcessingNotification($order1)
        );

        // Ensure the second notification has a later timestamp.
        Carbon::setTestNow(now()->addSecond());

        $order2 = Order::create([
            'user_id' => $user->id,
            'order_number' => 'TEST-' . uniqid(),
            'subtotal' => 200,
            'shipping' => 0,
            'discount' => 0,
            'total' => 200,
            'status' => OrderStatus::Shipped,
            'shipping_name' => 'Test User',
            'shipping_phone' => '01012345678',
            'shipping_country' => 'Egypt',
            'shipping_state' => 'Dakahlia',
            'shipping_city' => 'Mansoura',
            'shipping_address' => 'Test Address',
            'shipping_postal_code' => '35511',
        ]);

        $user->notify(
            new \App\Notifications\OrderShippedNotification($order2)
        );

        Carbon::setTestNow();

        $latest = app(NotificationService::class)
            ->latest($user, 1);

        $this->assertCount(1, $latest);

        $this->assertSame(
            $order2->id,
            $latest->first()->data['order_id']
        );
    }
}
