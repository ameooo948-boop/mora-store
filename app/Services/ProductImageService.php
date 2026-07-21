<?php

namespace App\Services;

use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Services\StorageService;

class ProductImageService
{
    public function __construct(
        private readonly ProductImageRepositoryInterface $productImageRepository,
        private readonly StorageService $storageService,
    ) {}

    public function delete(ProductImage $image): bool
    {
        return DB::transaction(function () use ($image) {

            if ($image->product->images()->count() <= 1) {
                return false;
            }
            $this->storageService->delete($image->image);

            $this->productImageRepository->delete($image);

            return true;
        });
    }
}
