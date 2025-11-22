<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateAdmin(int $perPage = 15): LengthAwarePaginator;

    public function getAll(): iterable;

    public function getAllWithCounts(): iterable;
}
