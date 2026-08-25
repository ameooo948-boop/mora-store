<?php

namespace App\Services;

use App\DTOs\Order\PlaceOrderData;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Events\OrderCreated;
use App\Events\OrderStatusChanged;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly OrderItemRepositoryInterface $orderItemRepository,
        private readonly AddressRepositoryInterface $addressRepository,
        private readonly CouponService $couponService,
        private readonly PaymentService $paymentService,
        protected OrderStatusHistoryService $historyService,
        private readonly ProductService $productService,
        protected NotificationService $notificationService,
    ) {}

    public function placeOrder(
        User $user,
        PlaceOrderData $data,
    ): Order {
        return DB::transaction(function () use ($user, $data) {

            $cart = $this->cartService->getCartForUpdate(
                $user->id
            );

            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty.',
                ]);
            }

            $address = $this->addressRepository->find($user, $data->addressId);

            if (! $address) {
                throw ValidationException::withMessages([
                    'address_id' => 'Invalid address.',
                ]);
            }

            $this->validateStock($cart);

            $totals = $this->cartService->calculateTotals($cart);

            $coupon = null;

            if ($data->couponCode) {

                $coupon = $this->couponService
                    ->findByCodeForUpdate($data->couponCode);

                if (! $coupon) {
                    throw ValidationException::withMessages([
                        'coupon' => __('Coupon not found.'),
                    ]);
                }

                $this->couponService->validateCoupon(
                    $coupon,
                    $totals['subtotal']
                );

                $discount = $this->couponService
                    ->calculateDiscount(
                        $coupon,
                        $totals['subtotal']
                    );

                $totals['discount'] = $discount;

                $totals['total'] =
                    max(0, $totals['subtotal'] - $discount)
                    + $totals['shipping'];
            }

            $order = $this->orderRepository->create([
                'user_id' => $user->id,

                'order_number' => $this->generateOrderNumber(),

                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],

                'status' => OrderStatus::Pending,

                // Shipping Snapshot
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'shipping_country' => $address->country,
                'shipping_state' => $address->state,
                'shipping_city' => $address->city,
                'shipping_address' => $address->address_line,
                'shipping_postal_code' => $address->postal_code,

                'coupon_id' => $coupon?->id,
            ]);

            $this->paymentService->createPayment(
                $order,
                $data->paymentMethod
            );

            $items = [];

            foreach ($cart->items as $item) {

                $items[] = [
                    'product_id' => $item->product_id,
                    'price' => $item->product->final_price,
                    'quantity' => $item->quantity,
                    'total' => $item->product->final_price * $item->quantity,
                ];

                $this->decreaseStock(
                    $item->product,
                    $item->quantity,
                    $order
                );
            }

            $this->orderItemRepository->createMany(
                $order,
                $items
            );

            $this->cartService->clear($user->id);

            if ($coupon) {

                $this->couponService
                    ->incrementUsedCount($coupon);
            }

            OrderCreated::dispatch($order);

            return $order->fresh([
                'items.product',
            ]);
        });
    }

    private function validateStock(Cart $cart): void
    {
        foreach ($cart->items as $item) {

            if (! $item->product->status) {
                throw ValidationException::withMessages([
                    'product' => "{$item->product->name} is unavailable.",
                ]);
            }

            if ($item->quantity > $item->product->quantity) {
                throw ValidationException::withMessages([
                    'product' => "Not enough stock for {$item->product->name}.",
                ]);
            }
        }
    }

    private function decreaseStock(
        Product $product,
        int $quantity,
        Order $order
    ): void {

        $this->productService->decreaseStock(
            $product,
            $quantity,
            $order
        );
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-'
            .now()->format('YmdHis')
            .'-'
            .Str::upper(Str::random(5));
    }

    public function getUserOrders(User $user)
    {
        return $this->orderRepository
            ->getUserOrders($user);
    }

    public function find(int $id): ?Order
    {
        return $this->orderRepository
            ->find($id);
    }

    public function getStatistics(User $user): array
    {
        return $this->orderRepository
            ->getStatistics($user);
    }

    public function getStatisticsAdmin(): array
    {
        return $this->orderRepository
            ->getStatisticsAdmin();
    }

    public function findUserOrder(
        User $user,
        int $id
    ): ?Order {
        return $this->orderRepository
            ->findUserOrder($user, $id);
    }

    public function paginateAdmin(
        ?string $search = null,
        ?OrderStatus $status = null
    ) {
        return $this->orderRepository->paginateAdmin(
            search: $search,
            status: $status
        );
    }

    public function getPaginatedOrders(
        ?string $search = null,
        ?string $status = null,
    ) {
        return Order::query()

            ->with([
                'user',
            ])

            ->withCount('items')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($user) use ($search) {

                            $user->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })

            ->when($status, function ($query) use ($status) {

                $query->where('status', $status);
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();
    }

    public function findForAdmin(int $id)
    {
        return $this->orderRepository->findForAdmin($id);
    }

    public function updateStatus(
        Order $order,
        OrderStatus $status
    ): Order {
        return DB::transaction(function () use ($order, $status) {

            $currentStatus = $order->status;

            if (! $currentStatus->canTransitionTo($status)) {
                throw new DomainException(
                    'Invalid order status transition.'
                );
            }

            $oldStatus = $currentStatus;

            $updatedOrder = $this->orderRepository->update(
                $order,
                [
                    'status' => $status,
                ]
            );

            if ($status === OrderStatus::Cancelled) {

                $order->loadMissing([
                    'items.product',
                    'payment',
                ]);

                foreach ($order->items as $item) {

                    $this->productService->increaseStock(
                        product: $item->product,
                        quantity: $item->quantity,
                        reference: $order,
                    );
                }

                if (
                    $order->payment &&
                    $order->payment->status->isPaid()
                ) {
                    $this->paymentService->refund(
                        $order->payment
                    );
                }
            }

            if ($status === OrderStatus::Delivered) {

                $order->loadMissing('payment');

                if (
                    $order->payment &&
                    $order->payment->payment_method === PaymentMethod::CashOnDelivery
                ) {
                    $this->paymentService->markAsPaid(
                        $order->payment
                    );
                }
            }
            $this->historyService->create(
                $updatedOrder,
                $oldStatus,
                $status
            );

            event(new OrderStatusChanged($order));

            return $updatedOrder;
        });
    }
}
