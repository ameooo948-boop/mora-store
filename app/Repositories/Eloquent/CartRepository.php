<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getOrCreate(int $userId): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => $userId,
        ]);
    }
}
