<?php

namespace App\Repositories\Eloquent;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use App\Repositories\Contracts\AdRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class EloquentAdRepository extends BaseRepository implements AdRepositoryInterface
{
    public function __construct(Ad $model)
    {
        parent::__construct($model);
    }

   
    public function getPublicAdsPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->where('status', 'active') 
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

 
    public function getAdsByUser(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $user->ads()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

  
    public function getAdsByCategory(Category $category, int $perPage = 15): LengthAwarePaginator
    {
        return $category->ads()
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    
    public function findPublicById(int $id): ?Model
    {
        return $this->model
            ->newQuery()
            ->where('id', $id)
            ->where('status', 'active')
            ->first();
    }
}
