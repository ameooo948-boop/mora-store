<?php

namespace App\Services;

use App\Models\ProductImage;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductImageService
{
    public function __construct(
        private readonly ProductImageRepositoryInterface $productImageRepository,
        private readonly StorageService $storageService,
    ) {}

    public function delete(ProductImage $image): bool
    {
        return DB::transaction(function () use ($image) {
            $image->loadMissing('product');

            if ($image->product->images()->count() <= 1) {
                return false;
            }

            $path = $image->image;
            $this->productImageRepository->delete($image);

            DB::afterCommit(function () use ($path) {
                $this->storageService->delete($path);
            });

            return true;
        });
    }
}
