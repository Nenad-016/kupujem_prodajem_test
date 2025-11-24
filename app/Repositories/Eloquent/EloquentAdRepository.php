<?php

namespace App\Repositories\Eloquent;

use App\Models\Ad;
use App\Models\User;
use App\Repositories\Contracts\AdRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentAdRepository implements AdRepositoryInterface
{
    public function findById(int $id): ?Ad
    {
        return Ad::query()->find($id);
    }

    public function findForUser(int $id, User $user): ?Ad
    {
        return Ad::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();
    }

    public function listPublicAds(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Ad::query()
            ->with(['user', 'category.parent.parent'])
            ->when($filters['q'] ?? null, function ($q, $value) {
                $q->where(function ($qq) use ($value) {
                    $qq->where('title', 'like', "%{$value}%")
                      ->orWhere('description', 'like', "%{$value}%");
                });
            })
            ->when($filters['location'] ?? null, function ($q, $value) {
                $q->where('location', 'like', "%{$value}%");
            })
            ->when($filters['category_id'] ?? null, function ($q, $value) {
                $q->where('category_id', $value);
            })
            ->when($filters['price_min'] ?? null, function ($q, $value) {
                $q->where('price', '>=', $value);
            })
            ->when($filters['price_max'] ?? null, function ($q, $value) {
                $q->where('price', '<=', $value);
            })
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function listUserAds(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return Ad::query()
            ->where('user_id', $user->id)
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate($perPage);
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

    public function delete(Ad $ad): bool
    {
        return (bool) $ad->delete();
    }
}
