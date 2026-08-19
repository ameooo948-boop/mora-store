<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'order_number',
        'subtotal',
        'shipping',
        'discount',
        'total',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_country',
        'shipping_state',
        'shipping_city',
        'shipping_address',
        'shipping_postal_code',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'status' => OrderStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(
            OrderStatusHistory::class
        )->latest();
    }

    public function stockMovements()
    {
        return $this->hasMany(
            StockMovement::class
        );
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d M Y');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status->badge();
    }

    public function getStatusIconAttribute(): string
    {
        return $this->status->icon();
    }

    public function getItemsCountAttribute(): int
    {
        if (array_key_exists('items_count', $this->attributes)) {
            return (int) $this->attributes['items_count'];
        }

        return $this->relationLoaded('items')
            ? $this->items->count()
            : $this->items()->count();
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return number_format($this->subtotal, 2);
    }

    public function getFormattedShippingAttribute(): string
    {
        return number_format($this->shipping, 2);
    }

    public function getFormattedDiscountAttribute(): string
    {
        return number_format($this->discount, 2);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2);
    }
}
