<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Services\BrandService;
use App\Services\ProductService;

class BrandController extends Controller
{
    public function __construct(
        private readonly BrandService $brandService,
        private readonly ProductService $productService,
    ) {}

    public function index()
    {
        $brands = $this->brandService->getActive();

        $brands->loadCount([
            'products' => fn ($query) => $query->where('status', true),
        ]);

        return response()->json([
            'brands' => BrandResource::collection($brands),
        ]);
    }

    public function show(Brand $brand)
    {
        abort_unless($brand->status, 404);

        $products = $this->productService->paginateStore(brand: $brand->id);

        $brand->loadCount([
            'products' => fn ($query) => $query->where('status', true),
        ]);

        return response()->json([
            'brand' => new BrandResource($brand),
            'products' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ],
        ]);
    }
}