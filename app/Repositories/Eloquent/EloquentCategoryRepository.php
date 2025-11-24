<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentCategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function paginateAdmin(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->withCount('ads')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function getAll(): iterable
    {
        return $this->model
            ->newQuery()
            ->orderBy('name')
            ->get();
    }

    public function getAllWithCounts(): iterable
    {
        return Category::query()
            ->withCount('ads')
            ->with([
                'children' => function ($q) {
                    $q->withCount('ads')
                        ->with('children');
                },
            ])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }
}
