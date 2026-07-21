<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'sale_price',
        'quantity',
        'status',
        'featured',
        'sort_order',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'sale_price' => 'decimal:2',
        'status'     => 'boolean',
        'featured'   => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->sale_price ?: $this->price,
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // public function cartItems(): HasMany
    // {
    //     return $this->hasMany(CartItem::class);
    // }

    // public function orderItems(): HasMany
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    // public function wishlists(): HasMany
    // {
    //     return $this->hasMany(Wishlist::class);
    // }
}
