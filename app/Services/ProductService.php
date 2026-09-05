<?php

namespace App\Services;

use App\DTOs\Product\CreateProductData;
use App\DTOs\Product\UpdateProductData;
use App\Enums\StockMovementType;
use App\Models\Product;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use DomainException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductImageRepositoryInterface $productImageRepository,
        protected StockMovementService $stockMovementService,
        protected ReviewService $reviewService,
        private readonly StorageService $storageService,
    ) {}

    public function create(CreateProductData $data): Product
    {
        return DB::transaction(function () use ($data) {

            $images = $data->images;

            $product = $this->productRepository->create([
                'category_id' => $data->categoryId,
                'brand_id' => $data->brandId,
                'name' => $data->name,
                'description' => $data->description,
                // Use a unique placeholder first; the auto-increment ID then gives us
                // a deterministic human-friendly SKU without a race on MAX(id).
                'sku' => 'TMP-' . Str::uuid(),
                'price' => $data->price,
                'sale_price' => $data->salePrice,
                'quantity' => $data->quantity,
                'status' => $data->status,
                'featured' => $data->featured,
                'sort_order' => $data->sortOrder,
            ]);

            $product->update([
                'sku' => 'PRD-' . str_pad((string) $product->id, 6, '0', STR_PAD_LEFT),
            ]);

            if (! empty($images)) {
                $this->productImageRepository->createMany(
                    $product,
                    $images
                );
            }

            if ($product->quantity > 0) {

                $this->stockMovementService->create(

                    product: $product,

                    beforeQuantity: 0,

                    type: StockMovementType::Increase,

                    quantity: $product->quantity,

                    reference: $product,

                    notes: 'Initial stock.'

                );
            }

            return $product;
        });
    }

    public function update(
        Product $product,
        UpdateProductData $data,
    ): Product {
        return DB::transaction(function () use ($product, $data) {

            $images = $data->images;

            $beforeQuantity = $product->quantity;

            $this->productRepository->update(
                $product,
                [
                    'category_id' => $data->categoryId,
                    'brand_id' => $data->brandId,
                    'name' => $data->name,
                    'description' => $data->description,
                    'price' => $data->price,
                    'sale_price' => $data->salePrice,
                    'quantity' => $data->quantity,
                    'status' => $data->status,
                    'featured' => $data->featured,
                    'sort_order' => $data->sortOrder,
                ]
            );

            if (! empty($images)) {
                $this->productImageRepository->createMany(
                    $product,
                    $images
                );
            }

            $product->refresh();

            if ($beforeQuantity !== $product->quantity) {

                $type = $product->quantity > $beforeQuantity
                    ? StockMovementType::Increase
                    : StockMovementType::Decrease;

                $this->stockMovementService->create(
                    product: $product,
                    beforeQuantity: $beforeQuantity,
                    type: $type,
                    quantity: abs(
                        $product->quantity - $beforeQuantity
                    ),
                    reference: $product,
                    notes: 'Stock adjusted from admin.'
                );
            }

            return $product;
        });
    }

    public function delete(Product $product): bool
    {
        return DB::transaction(function () use ($product) {
            $product->loadMissing('images');
            $paths = $product->images->pluck('image')->filter()->values()->all();

            foreach ($product->images as $image) {
                $this->productImageRepository->delete($image);
            }

            $deleted = $this->productRepository->delete($product);

            if ($deleted) {
                DB::afterCommit(function () use ($paths) {
                    foreach ($paths as $path) {
                        $this->storageService->delete($path);
                    }
                });
            }

            return $deleted;
        });
    }

    public function paginateAdmin(
        ?string $search = null,
        ?int $category = null,
        ?int $brand = null,
        ?int $status = null,
    ) {
        return $this->productRepository
            ->paginateAdmin($search, $category, $brand, $status);
    }

    public function paginateStore(
        ?string $search = null,
        ?int $category = null,
        ?int $brand = null,
        ?string $sort = null,
    ) {
        return $this->productRepository->paginateStore(
            $search,
            $category,
            $brand,
            $sort
        );
    }

    public function getStatistics(): array
    {
        return $this->productRepository->getStatistics();
    }

    public function latest(int $limit = 8)
    {
        return $this->productRepository->latest($limit);
    }

    public function find(Product $product)
    {
        return $this->productRepository->find($product);
    }

    public function related(
        Product $product,
        int $limit = 4
    ) {
        return $this->productRepository->related(
            $product,
            $limit
        );
    }

    public function decreaseStock(
        Product $product,
        int $quantity,
        ?Model $reference = null,
    ): Product {

        if ($quantity <= 0) {
            throw new DomainException(
                'Quantity must be greater than zero.'
            );
        }

        return DB::transaction(function () use (
            $product,
            $quantity,
            $reference,
        ) {

            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($product->id);

            if ($product->quantity < $quantity) {
                throw new DomainException(
                    'Not enough stock available.'
                );
            }

            $beforeQuantity = $product->quantity;

            $product->decrement(
                'quantity',
                $quantity
            );

            $product->refresh();

            $this->stockMovementService->create(
                $product,
                $beforeQuantity,
                StockMovementType::Decrease,
                $quantity,
                $reference
            );

            return $product;
        });
    }

    public function increaseStock(
        Product $product,
        int $quantity,
        ?Model $reference = null,
    ): Product {

        if ($quantity <= 0) {
            throw new DomainException(
                'Quantity must be greater than zero.'
            );
        }

        return DB::transaction(function () use (
            $product,
            $quantity,
            $reference,
        ) {

            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($product->id);

            $beforeQuantity = $product->quantity;

            $product->increment(
                'quantity',
                $quantity
            );

            $product->refresh();

            $this->stockMovementService->create(
                $product,
                $beforeQuantity,
                StockMovementType::Increase,
                $quantity,
                $reference
            );

            return $product;
        });
    }

    public function averageRating(
        Product $product,
    ): float {

        return $this->reviewService
            ->averageRating($product);
    }

    public function reviewsCount(
        Product $product,
    ): int {

        return $this->reviewService
            ->reviewsCount($product);
    }
}
