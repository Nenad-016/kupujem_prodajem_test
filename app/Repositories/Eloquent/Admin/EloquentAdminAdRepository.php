<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Ad;
use App\Repositories\Contracts\Admin\AdminAdRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentAdminAdRepository implements AdminAdRepositoryInterface
{
    public function paginateWithRelations(int $perPage = 20, bool $withTrashed = false): LengthAwarePaginator
    {
        $query = Ad::query()
            ->with(['user', 'category'])
            ->orderByDesc('created_at');

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Ad
    {
        return Ad::create($data);
    }

    public function update(Ad $ad, array $data): Ad
    {
        $ad->update($data);

        return $ad;
    }

    public function delete(Ad $ad): void
    {
        $ad->delete();
    }
}
