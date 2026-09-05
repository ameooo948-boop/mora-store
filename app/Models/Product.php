<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

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
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'status' => 'boolean',
        'featured' => 'boolean',
    ];

    protected $appends = [
        'final_price',
        'has_discount',
        'discount_percentage',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', false);
    }

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

    public function stockMovements()
    {
        return $this->hasMany(
            StockMovement::class
        )->latest();
    }

    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sale_price !== null ? (float) $this->sale_price : (float) $this->price,
        );
    }

    protected function hasDiscount(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->sale_price)
                && $this->sale_price < $this->price,
        );
    }

    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->has_discount
                ? ($this->price > 0
                    ? round((($this->price - $this->sale_price) / $this->price) * 100)
                    : 0)
                : 0,
        );
    }

    public function getAverageRatingAttribute(): float
    {
        if (array_key_exists('approved_reviews_avg_rating', $this->attributes)) {
            return round(
                (float) $this->attributes['approved_reviews_avg_rating'],
                1
            );
        }

        return round(
            $this->approvedReviews()->avg('rating') ?? 0,
            1
        );
    }

    public function getReviewsCountAttribute(): int
    {
        if (array_key_exists('approved_reviews_count', $this->attributes)) {
            return (int) $this->attributes['approved_reviews_count'];
        }

        return $this->approvedReviews()->count();
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(
            Review::class
        );
    }

    public function approvedReviews()
    {
        return $this->hasMany(
            Review::class
        )->where('status', ReviewStatus::Approved);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
