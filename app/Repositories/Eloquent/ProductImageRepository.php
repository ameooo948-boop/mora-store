<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Services\StorageService;
use Illuminate\Database\Eloquent\Collection;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    public function __construct(
        private readonly StorageService $storageService,
    ) {}

    public function create(array $data): ProductImage
    {
        return ProductImage::create($data);
    }

    public function createMany(Product $product, array $images): Collection
    {
        $createdImages = new Collection();
        $lastSortOrder = $product->images()->max('sort_order') ?? -1;

        foreach ($images as $index => $image) {

            $createdImages->push(
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $this->storageService->upload($image, 'products'),
                    'sort_order' => ++$lastSortOrder,
                ])
            );
        }

        return $createdImages;
    }

    public function delete(ProductImage $image): bool
    {
        return $image->delete();
    }
}
