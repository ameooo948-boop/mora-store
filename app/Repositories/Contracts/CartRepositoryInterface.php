<?php

namespace App\Repositories\Contracts;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function getOrCreate(int $userId): Cart;
}
