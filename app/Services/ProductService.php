<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductImageRepositoryInterface $productImageRepository,
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

            return $product;
        });
    }

    public function update(Product $product, array $data): bool
    {
        return DB::transaction(function () use ($product, $data) {

            $images = $data['images'] ?? [];

            unset($data['images']);

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
}
