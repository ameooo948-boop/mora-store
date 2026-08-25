<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\Product\CreateProductData;
use App\DTOs\Product\UpdateProductData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly BrandRepositoryInterface $brandRepository,
    ) {}

    public function index(Request $request)
    {
        $status = $request->filled('status') ? (int) $request->status : null;

        $products = $this->productService->paginateAdmin(
            $request->search,
            $request->category,
            $request->brand,
            $status,
        );

        return response()->json([
            'products' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ],
            'statistics' => $this->productService->getStatistics(),
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
            'brands' => BrandResource::collection(Brand::orderBy('name')->get()),
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'images']);

        return response()->json([
            'product' => new ProductResource($product),
        ]);
    }

    public function formOptions()
    {
        return response()->json([
            'categories' => CategoryResource::collection($this->categoryRepository->getActive()),
            'brands' => BrandResource::collection($this->brandRepository->getActive()),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create(
            new CreateProductData(
                categoryId: $request->integer('category_id'),
                brandId: $request->integer('brand_id'),
                name: $request->string('name')->value(),
                description: $request->input('description'),
                price: (float) $request->input('price'),
                salePrice: $request->filled('sale_price') ? (float) $request->input('sale_price') : null,
                quantity: $request->integer('quantity'),
                status: $request->boolean('status'),
                featured: $request->boolean('featured'),
                sortOrder: $request->integer('sort_order', 0),
                images: $request->file('images', []),
            )
        );

        $product->load(['category', 'brand', 'images']);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => new ProductResource($product),
        ], 201);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->update(
            $product,
            new UpdateProductData(
                categoryId: $request->integer('category_id'),
                brandId: $request->integer('brand_id'),
                name: $request->string('name')->value(),
                description: $request->input('description'),
                price: (float) $request->input('price'),
                salePrice: $request->filled('sale_price') ? (float) $request->input('sale_price') : null,
                quantity: $request->integer('quantity'),
                status: $request->boolean('status'),
                featured: $request->boolean('featured'),
                sortOrder: $request->integer('sort_order', 0),
                images: $request->file('images', []),
            )
        );

        $product->load(['category', 'brand', 'images']);

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => new ProductResource($product),
        ]);
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}