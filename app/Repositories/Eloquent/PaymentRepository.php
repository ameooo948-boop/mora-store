<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function update(
        Payment $payment,
        array $data,
    ): Payment {

        $payment->update($data);

        return $payment->fresh();
    }

    public function find(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function findByOrder(
        Order $order,
    ): ?Payment {

        return Payment::where(
            'order_id',
            $order
        )->first();
    }

    public function findByTransactionId(
        string $transactionId,
    ): ?Payment {

        return Payment::where(
            'transaction_id',
            $transactionId
        )->first();
    }

    public function paginate(
        int $perPage = 10,
        ?string $search = null,
    ) {
        return Payment::with([
            'order',
            'order.user',
        ])
            ->when($search, function ($query) use ($search) {

                $query->where('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($query) use ($search) {

                        $query->where('id', 'like', "%{$search}%");
                    })
                    ->orWhereHas('order.user', function ($query) use ($search) {

                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }
}
