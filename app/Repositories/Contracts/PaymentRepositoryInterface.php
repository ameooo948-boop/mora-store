<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\Payment;

interface PaymentRepositoryInterface
{
    public function create(array $data): Payment;

    public function update(
        Payment $payment,
        array $data,
    ): Payment;

    public function find(int $id): ?Payment;

    public function findByOrder(Order $order): ?Payment;

    public function findByTransactionId(
        string $transactionId,
    ): ?Payment;

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
    );
}
