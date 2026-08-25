<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Category\CreateCategoryData;
use App\DTOs\Category\UpdateCategoryData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $this->categoryService->paginate(

            $request->search,

            $request->filled('status')
                ? (int) $request->status
                : null,

        );

        $statistics = $this->categoryService->getStatistics();

        return view(

            'admin.categories.index',

            compact(

                'categories',

                'statistics',

            )

        );
    }

    public function show(Category $category)
    {
        $category->load([
            'parent',
        ])->loadCount('products');

        return view(
            'admin.categories.show',
            compact('category')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = $this->categoryService->getParents();

        return view('admin.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create(
            new CreateCategoryData(
                name: $request->string('name')->value(),
                description: $request->input('description'),
                image: $request->file('image'),
                parentId: $request->filled('parent_id')
                    ? $request->integer('parent_id')
                    : null,
                status: $request->boolean('status'),
                sortOrder: $request->integer('sort_order', 0),
            )
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parents = $this->categoryService->getParents()
            ->where('id', '!=', $category->id);

        return view('admin.categories.edit', compact(
            'category',
            'parents'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {
        $this->categoryService->update(
            $category,
            new UpdateCategoryData(
                name: $request->string('name')->value(),
                description: $request->input('description'),
                image: $request->file('image'),
                parentId: $request->filled('parent_id')
                    ? $request->integer('parent_id')
                    : null,
                status: $request->boolean('status'),
                sortOrder: $request->integer('sort_order', 0),
            )
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        if (! $this->categoryService->delete($category)) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it contains products.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
