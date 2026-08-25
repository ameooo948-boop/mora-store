<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function index()
    {
        $categories = $this->categoryService->getActiveParents();

        return response()->json([
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function show(Category $category)
    {
        abort_unless($category->status, 404);

        $category = $this->categoryService->findBySlug($category->slug);

        abort_if(! $category, 404);

        $products = $this->categoryService->getProductsForCategory($category);

        return response()->json([
            'category' => new CategoryResource($category),
            'products' => ProductResource::collection($products),
        ]);
    }
}
