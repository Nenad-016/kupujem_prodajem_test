<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface AdRepositoryInterface extends BaseRepositoryInterface
{
    public function getPublicAdsPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getAdsByUser(User $user, int $perPage = 15): LengthAwarePaginator;

    public function getAdsByCategory(Category $category, int $perPage = 15): LengthAwarePaginator;

    public function findPublicById(int $id): ?Model;
}
