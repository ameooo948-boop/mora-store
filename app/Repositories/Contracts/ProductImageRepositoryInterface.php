<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

interface ProductImageRepositoryInterface
{
    public function create(array $data): ProductImage;

    public function createMany(Product $product, array $images): Collection;

    public function delete(ProductImage $image): bool;
}