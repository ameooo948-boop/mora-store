<?php

namespace App\Models;

use App\Enums\StockMovementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [

        'product_id',

        'user_id',

        'type',

        'quantity',

        'before_quantity',

        'after_quantity',

        'notes',

        'reference_type',

        'reference_id',

        'reason',

    ];

    protected function casts(): array
    {
        return [

            'type' => StockMovementType::class,

        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    public function getReferenceLabelAttribute(): string
    {
        if (! $this->reference) {
            return '-';
        }

        return match (class_basename($this->reference_type)) {

            'Order' => 'Order #' . $this->reference->id,

            default => class_basename($this->reference_type) . ' #' . $this->reference->id,
        };
    }
}
