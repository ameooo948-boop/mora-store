<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    protected $fillable = [

        'order_id',

        'user_id',

        'old_status',

        'new_status',

        'notes',

        'changed_at',

    ];

    protected function casts(): array
    {
        return [

            'old_status' => OrderStatus::class,

            'new_status' => OrderStatus::class,
            
            'changed_at' => 'datetime',

        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}
