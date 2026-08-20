<?php

namespace App\Services;

use App\Models\Product;

class CatalogService
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryService $categoryService,
        private readonly BrandService $brandService,
    ) {}

    public function products(array $filters = [])
    {
        return $this->productService->paginateStore(
            search: $filters['search'] ?? null,
            category: isset($filters['category'])
                ? (int) $filters['category']
                : null,
            brand: isset($filters['brand'])
                ? (int) $filters['brand']
                : null,
            sort: $filters['sort'] ?? null,
        );
    }

    public function categories()
    {
        return $this->categoryService->getActive();
    }

    public function brands()
    {
        return $this->brandService->getActive();
    }

    public function findProduct(Product $product)
    {
        return $this->productService->find($product);
    }

    public function relatedProducts(Product $product)
    {
        return $this->productService->related($product);
    }
}
