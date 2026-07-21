<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function paginate(
        ?string $search = null,
        ?int $category = null,
        ?int $status = null,
    ): LengthAwarePaginator {
        return $this->productRepository->paginate($category, $status, $search);
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
}
