<?php

namespace App\Repositories\Eloquent;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): bool
    {
        return $order->update($data);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Order::with('user')
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $id): ?Order
    {
        return Order::with([
            'user',
            'items.product',
            'items.product.images',
        ])->find($id);
    }

    public function getUserOrders(User $user): LengthAwarePaginator
    {
        return $user->orders()
            ->latest()
            ->paginate(10);
    }

    public function getStatistics(): array
    {
        return [
            'total' => Order::count(),

            'pending' => Order::where('status', 'pending')->count(),

            'processing' => Order::where('status', 'processing')->count(),

            'shipped' => Order::where('status', 'shipped')->count(),

            'delivered' => Order::where('status', 'delivered')->count(),

            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
    }

    public function findUserOrder(User $user, int $id): ?Order
    {
        return Order::query()
            ->with([
                'user',
                'items.product.images',
            ])
            ->where('user_id', $user->id)
            ->find($id);
    }

    public function paginateAdmin(
        ?string $search = null,
        ?OrderStatus $status = null,
        int $perPage = 15
    ): LengthAwarePaginator {

        return Order::query()
            ->with([
                'user',
                'items.product',
            ])
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {

                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($query) use ($status) {

                $query->where('status', $status);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function findForAdmin(int $id): ?Order
    {
        return Order::with([
            'user',
            'items.product',
        ])->find($id);
    }

    public function updateStatus(Order $order, OrderStatus $status): bool
    {
        return $order->update([
            'status' => $status,
        ]);
    }
}
