<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentCategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAllWithCounts(): Collection
    {
        return $this->model
            ->newQuery()
            ->withCount('ads')
            ->orderBy('name')
            ->get();
    }
}
