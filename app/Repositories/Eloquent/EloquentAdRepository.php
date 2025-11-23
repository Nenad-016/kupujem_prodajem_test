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
        $query = Ad::query()
            ->where('status', 'active')

            ->with(['user', 'category']);

        if (! empty($filters['q'])) {
            $s = trim($filters['q']);
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if (! empty($filters['location'])) {
            $query->where('location', 'like', '%'.trim($filters['location']).'%');
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['price_min'])) {
            $query->where('price', '>=', (float) $filters['price_min']);
        }

        if (! empty($filters['price_max'])) {
            $query->where('price', '<=', (float) $filters['price_max']);
        }

        return $query
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
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

    public function delete(Ad $ad): void
    {
        $ad->delete();
    }
}
