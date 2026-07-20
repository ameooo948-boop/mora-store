<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function getParents()
    {
        return Category::query()
            ->orderBy('name', 'asc')
            ->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        return Category::query()
            ->with('parent')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('sort_order', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getStatistics(): array
{
        return [
            'total' => Category::count(),
            'active' => Category::where('status', true)->count(),
            'inactive' => Category::where('status', false)->count(),
            'main' => Category::whereNull('parent_id')->count(),
        ];
    }

    public function getActive(): Collection
    {
        return Category::where('status', true)->orderBy('sort_order')->get();
    }
}