<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [

        'order_id',

        'transaction_id',

        'amount',

        'payment_method',

        'status',

        'paid_at',

        'gateway_response',
    ];

    protected function casts(): array
    {
        return [

            'payment_method' => PaymentMethod::class,

            'status' => PaymentStatus::class,

            'paid_at' => 'datetime',

            'gateway_response' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function formattedAmount(): string
    {
        return number_format(
            $this->amount,
            2
        );
    }
}
