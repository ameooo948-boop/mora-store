<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected $appends = [
        'is_in_wishlist',
    ];

    public function getIsInWishlistAttribute(): bool
    {
        if (! Auth::check()) {
            return false;
        }

        return self::where('product_id', $this->product_id)
            ->where('user_id', Auth::id())
            ->exists();
    }
}
