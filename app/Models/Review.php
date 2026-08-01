<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [

        'product_id',

        'user_id',

        'rating',

        'comment',

        'status',

        'approved_by',

        'approved_at',

    ];

    protected function casts(): array
    {
        return [

            'status' => ReviewStatus::class,

            'approved_at' => 'datetime',

        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }
}
