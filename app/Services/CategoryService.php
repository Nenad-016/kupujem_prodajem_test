<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(
        protected readonly CategoryRepositoryInterface $categories
    ) {}

    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator
    {

        // return $this->categories->paginateAdmin($perPage) ako bi se islo preko repa;
        return Category::query()
            ->withCount('ads')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function create(array $data): Category
    {
        $data['slug'] = $this->createSlug($data);

        return $this->categories->create($data);
    }

    public function update(Category $category, array $data): bool
    {
        $data['slug'] = $this->updateSlug($category, $data);

        return $this->categories->update($category->id, $data);
    }

    public function delete(Category $category): bool
    {
        return $this->categories->delete($category->id);
    }

    protected function createSlug(array $data): string
    {
        if (! empty($data['slug'])) {
            return Str::slug($data['slug']);
        }

        return Str::slug($data['name']);
    }

    protected function updateSlug(Category $category, array $data): string
    {

        if (! empty($data['slug'])) {
            return Str::slug($data['slug']);
        }

        if (empty($data['name']) || $data['name'] === $category->name) {
            return $category->slug;
        }

        return Str::slug($data['name']);
    }
}
