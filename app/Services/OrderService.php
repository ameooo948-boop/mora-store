<?php

namespace App\Services;

use App\DTOs\Order\PlaceOrderData;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Events\OrderCreated;
use App\Events\OrderStatusChanged;
use App\Models\Cart;
use App\Models\Coupon;
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
    ) {}

    public function placeOrder(User $user, PlaceOrderData $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = $this->cartService->getCartForUpdate($user->id);

            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty.',
                ]);
            }

            if (! in_array($data->paymentMethod, $this->paymentService->availableMethods(), true)) {
                throw ValidationException::withMessages([
                    'payment_method' => 'The selected payment method is currently unavailable.',
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
                $coupon = $this->couponService->findByCodeForUpdate($data->couponCode);

                if (! $coupon) {
                    throw ValidationException::withMessages([
                        'coupon' => __('Coupon not found.'),
                    ]);
                }

                $this->couponService->validateCoupon($coupon, $totals['subtotal']);

                $discount = $this->couponService->calculateDiscount(
                    $coupon,
                    $totals['subtotal']
                );

                $totals = $this->cartService->calculateTotals($cart, $discount);
            }

            if ($data->paymentMethod === PaymentMethod::Stripe && (float) $totals['total'] <= 0) {
                throw ValidationException::withMessages([
                    'payment_method' => 'Stripe cannot be used for a zero-value order.',
                ]);
            }

            $order = $this->orderRepository->create([
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'discount' => $totals['discount'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
                'status' => OrderStatus::Pending,
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'shipping_country' => $address->country,
                'shipping_state' => $address->state,
                'shipping_city' => $address->city,
                'shipping_address' => $address->address_line,
                'shipping_postal_code' => $address->postal_code,
                'coupon_id' => $coupon?->id,
            ]);

            $this->paymentService->createPayment($order, $data->paymentMethod);

            $items = [];

            foreach ($cart->items as $item) {
                $items[] = [
                    'product_id' => $item->product_id,
                    'price' => round((float) $item->product->final_price, 2),
                    'quantity' => $item->quantity,
                    'total' => round((float) $item->product->final_price * $item->quantity, 2),
                ];

                $this->decreaseStock($item->product, $item->quantity, $order);
            }

            $this->orderItemRepository->createMany($order, $items);
            $this->cartService->clear($user->id);

            if ($coupon) {
                $this->couponService->incrementUsedCount($coupon);
            }

            OrderCreated::dispatch($order);

            return $order->fresh(['items.product', 'payment']);
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

    private function decreaseStock(Product $product, int $quantity, Order $order): void
    {
        $this->productService->decreaseStock(
            product: $product,
            quantity: $quantity,
            reference: $order,
        );
    }

    /**
     * Cancel an unpaid order after payment initialization/cancellation.
     * Stock is released exactly once and the payment is marked failed.
     */
    public function cancelUnpaidOrder(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            $order = Order::query()
                ->with(['items.product', 'payment'])
                ->lockForUpdate()
                ->findOrFail($order->id);

            if ($order->status !== OrderStatus::Pending) {
                return $order;
            }

            $payment = $order->payment;

            if ($payment?->status === PaymentStatus::Paid || $payment?->status === PaymentStatus::Refunded) {
                throw new DomainException('A paid order cannot be cancelled as an unpaid order.');
            }

            $oldStatus = $order->status;

            foreach ($order->items->sortBy('product_id') as $item) {
                $this->productService->increaseStock(
                    product: $item->product,
                    quantity: (int) $item->quantity,
                    reference: $order,
                    );
            }

            if ($payment && $payment->status->isPending()) {
                $this->paymentService->markAsFailed($payment);
            }

            if ($order->coupon_id) {
                $coupon = Coupon::find($order->coupon_id);
                if ($coupon) {
                    $this->couponService->decrementUsedCount($coupon);
                }
            }

            $updatedOrder = $this->orderRepository->update($order, [
                'status' => OrderStatus::Cancelled,
            ]);

            $this->historyService->create(
                $updatedOrder,
                $oldStatus,
                OrderStatus::Cancelled,
                'Cancelled because payment was not completed.'
            );

            OrderStatusChanged::dispatch($updatedOrder);

            return $updatedOrder;
        });
    }

    /**
     * Expire an unpaid Stripe order and release its reserved inventory.
     * This operation is idempotent and safe to call from the scheduler or webhook.
     */
    public function expireUnpaidOrder(int $orderId): bool
    {
        $order = Order::query()
            ->with('payment')
            ->find($orderId);

        if (! $order || $order->status !== OrderStatus::Pending) {
            return false;
        }

        $payment = $order->payment;

        if (! $payment || $payment->payment_method !== PaymentMethod::Stripe || ! $payment->status->isPending()) {
            return false;
        }

        $updated = $this->cancelUnpaidOrder($order);

        return $updated->status === OrderStatus::Cancelled;
    }

    public function getUserOrders(User $user)
    {
        return $this->orderRepository->getUserOrders($user);
    }

    public function find(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    public function getStatisticsAdmin(): array
    {
        return $this->orderRepository->getStatisticsAdmin();
    }

    public function findUserOrder(User $user, int $id): ?Order
    {
        return $this->orderRepository->findUserOrder($user, $id);
    }

    public function getPaginatedOrders(?string $search = null, ?string $status = null)
    {
        return Order::query()
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function getStatistics(User $user): array
    {
        return $this->orderRepository->getStatistics($user);
    }

    public function paginateAdmin(
        ?string $search = null,
        ?OrderStatus $status = null,
        int $perPage = 15
    ) {
        return $this->orderRepository->paginateAdmin($search, $status, $perPage);
    }

    public function findForAdmin(int $id)
    {
        return $this->orderRepository->findForAdmin($id);
    }

    public function updateStatus(Order $order, OrderStatus $status): Order
    {
        return DB::transaction(function () use ($order, $status) {
            $order = Order::query()
                ->with(['items.product', 'payment'])
                ->lockForUpdate()
                ->findOrFail($order->id);

            $currentStatus = $order->status;

            if (! $currentStatus->canTransitionTo($status)) {
                throw new DomainException('Invalid order status transition.');
            }

            $oldStatus = $currentStatus;

            if ($status === OrderStatus::Cancelled) {
                foreach ($order->items->sortBy('product_id') as $item) {
                    $this->productService->increaseStock(
                        product: $item->product,
                        quantity: (int) $item->quantity,
                        reference: $order,
                    );
                }

                if ($order->payment?->status->isPaid()) {
                    $this->paymentService->refund($order->payment);
                } else {
                    if ($order->payment?->status->isPending()) {
                        $this->paymentService->markAsFailed($order->payment);
                    }

                    if ($order->coupon_id) {
                        $coupon = Coupon::find($order->coupon_id);
                        if ($coupon) {
                            $this->couponService->decrementUsedCount($coupon);
                        }
                    }
                }
            }

            if ($status === OrderStatus::Delivered &&
                $order->payment &&
                $order->payment->payment_method === PaymentMethod::CashOnDelivery
            ) {
                $this->paymentService->markAsPaid($order->payment);
            }

            $updatedOrder = $this->orderRepository->update($order, [
                'status' => $status,
            ]);

            $this->historyService->create($updatedOrder, $oldStatus, $status);
            OrderStatusChanged::dispatch($updatedOrder);

            return $updatedOrder;
        });
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'MORA-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
