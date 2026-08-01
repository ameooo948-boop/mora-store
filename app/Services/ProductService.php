<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\StockMovementService;
use DomainException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductImageRepositoryInterface $productImageRepository,
        protected StockMovementService $stockMovementService,
        protected ReviewService $reviewService,
    ) {}

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            $images = $data['images'] ?? [];

            unset($data['images']);

            $data['sku'] = $this->generateSku();

            $product = $this->productRepository->create($data);

            if (!empty($images)) {
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

    public function update(Product $product, array $data): bool
    {
        return DB::transaction(function () use ($product, $data) {

            $images = $data['images'] ?? [];

            unset($data['images']);
            $beforeQuantity = $product->quantity;

            $updated = $this->productRepository->update(
                $product,
                $data
            );

            if (!empty($images)) {

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

            return $updated;
        });
    }

    public function delete(Product $product): bool
    {
        return DB::transaction(function () use ($product) {

            $this->productImageRepository->deleteByProduct($product);

            return $this->productRepository->delete($product);
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
        array $filters = []
    ) {
        return $this->productRepository
            ->paginateStore($filters);
    }

    public function getStatistics(): array
    {
        return $this->productRepository->getStatistics();
    }

    private function generateSku(): string
    {
        $lastProduct = Product::latest('id')->first();

        $nextId = $lastProduct
            ? $lastProduct->id + 1
            : 1;

        return 'PRD-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
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

        if ($product->quantity < $quantity) {
            throw new DomainException(
                'Not enough stock available.'
            );
        }

        return DB::transaction(function () use (
            $product,
            $quantity,
            $reference,
        ) {

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
