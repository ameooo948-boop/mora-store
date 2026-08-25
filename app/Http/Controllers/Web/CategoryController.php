<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

        return view('web.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        abort_unless($category->status, 404);

        $category = $this->categoryService->findBySlug(
            $category->slug
        );

        abort_if(! $category, 404);

        $products = $this->categoryService
            ->getProductsForCategory($category);

        return view('web.categories.show', compact(
            'category',
            'products'
        ));
    }
}
