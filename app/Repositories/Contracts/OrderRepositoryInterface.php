<?php

namespace App\Repositories\Contracts;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function create(array $data): Order;

    public function update(Order $order, array $data): bool;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function find(int $id): ?Order;

    public function getUserOrders(User $user): LengthAwarePaginator;

    public function getStatistics(): array;

    public function findUserOrder(User $user, int $id): ?Order;

    public function paginateAdmin(
        ?string $search = null,
        ?OrderStatus $status = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findForAdmin(int $id): ?Order;
    
    public function updateStatus(Order $order, OrderStatus $status): bool;
}
