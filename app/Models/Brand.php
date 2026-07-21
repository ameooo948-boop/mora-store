<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Traits\HasSlug;
use Illuminate\Support\Facades\Storage;


class Brand extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->logo
                ? Storage::url($this->logo)
                : null
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
