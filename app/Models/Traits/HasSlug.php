<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{

    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function (Model $model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
