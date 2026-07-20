<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{

    public function create(array $data): Category;

    public function update(Category $category, array $data): bool;

    public function delete(Category $category): bool;

    public function getParents();

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator;

    public function getStatistics(): array;

    public function getActive(): Collection;
}