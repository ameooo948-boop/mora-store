<?php

namespace App\Http\Controllers\Admin;

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
        $this->categoryService->create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->update(
            $category,
            $request->validated()
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
