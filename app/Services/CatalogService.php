<?php

namespace App\Services;

use App\Models\Product;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;

class CatalogService
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryService $categoryService,
        private readonly BrandService $brandService,
    ) {}

    public function products(array $filters = [])
    {
        return $this->productService->paginateStore($filters);
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
