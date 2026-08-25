<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\Category\CreateCategoryData;
use App\DTOs\Category\UpdateCategoryData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        $categories = $this->categoryService->paginate(
            $request->search,
            $request->filled('status') ? (int) $request->status : null,
        );

        return response()->json([
            'categories' => CategoryResource::collection($categories),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'total' => $categories->total(),
            ],
            'statistics' => $this->categoryService->getStatistics(),
        ]);
    }

    public function show(Category $category)
    {
        $category->load(['parent'])->loadCount('products');

        return response()->json([
            'category' => new CategoryResource($category),
        ]);
    }

    public function parents(Request $request)
    {
        $parents = $this->categoryService->getParents();

        if ($request->filled('exclude')) {
            $parents = $parents->where('id', '!=', $request->integer('exclude'));
        }

        return response()->json([
            'parents' => CategoryResource::collection($parents),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create(
            new CreateCategoryData(
                name: $request->string('name')->value(),
                description: $request->input('description'),
                image: $request->file('image'),
                parentId: $request->filled('parent_id') ? $request->integer('parent_id') : null,
                status: $request->boolean('status'),
                sortOrder: $request->integer('sort_order', 0),
            )
        );

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => new CategoryResource($category),
        ], 201);
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {
        $category = $this->categoryService->update(
            $category,
            new UpdateCategoryData(
                name: $request->string('name')->value(),
                description: $request->input('description'),
                image: $request->file('image'),
                parentId: $request->filled('parent_id') ? $request->integer('parent_id') : null,
                status: $request->boolean('status'),
                sortOrder: $request->integer('sort_order', 0),
            )
        );

        return response()->json([
            'message' => 'Category updated successfully.',
            'category' => new CategoryResource($category),
        ]);
    }

    public function destroy(Category $category)
    {
        if (! $this->categoryService->delete($category)) {
            return response()->json([
                'message' => 'Cannot delete category because it contains products.',
            ], 422);
        }

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
