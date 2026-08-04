<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\OrderStatusHistoryService;
use App\Services\PaymentService;
use App\Services\ProductService;
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
        int $addressId,
        PaymentMethod $paymentMethod,
        ?string $couponCode = null,
    ): Order {
        return DB::transaction(function () use ($user, $addressId, $paymentMethod, $couponCode) {

            $cart = $this->cartService->getCart($user->id);

            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty.',
                ]);
            }

            $address = $this->addressRepository->find($user, $addressId);

            if (! $address) {
                throw ValidationException::withMessages([
                    'address_id' => 'Invalid address.',
                ]);
            }

            $this->validateStock($cart);

            $totals = $this->cartService->calculateTotals($cart);

            $coupon = null;

            if ($couponCode) {

                $couponData = $this->couponService
                    ->applyCoupon(
                        $couponCode,
                        $totals['subtotal']
                    );

                $coupon = $couponData['coupon'];

                $totals['discount'] = $couponData['discount'];

                $totals['total'] =
                    $couponData['total'] + $totals['shipping'];
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
                $paymentMethod
            );

            $items = [];

            foreach ($cart->items as $item) {

                $items[] = [
                    'product_id' => $item->product_id,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                    'total'      => $item->price * $item->quantity,
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

            $this->notificationService
                ->newOrder(
                    $order
                );

            $this->cartService->clear($user->id);

            if ($coupon) {

                $this->couponService
                    ->incrementUsedCount($coupon);
            }

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
            . now()->format('YmdHis')
            . '-'
            . Str::upper(Str::random(5));
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

        $this->historyService->create(
            $updatedOrder,
            $oldStatus,
            $status
        );

        $this->notificationService
            ->orderStatusChanged(
                $order
            );

        return $updatedOrder;
    }
}
