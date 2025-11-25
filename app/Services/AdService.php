<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\AdRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdService
{
    public function __construct(
        protected readonly AdRepositoryInterface $ads,
    ) {}

    public function listPublicAds(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->ads->listPublicAds($filters, $perPage);
    }

    public function listPublicAdsByCategory(Category $category, int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $filters['category_id'] = $category->id;

        return $this->ads->listPublicAds($filters, $perPage);
    }

    public function listUserAds(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $this->ads->listUserAds($user, $perPage);
    }

    public function createForUser(User $user, array $data): Ad
    {
        $data['user_id'] = $user->id;

        return DB::transaction(function () use ($data) {
            return $this->ads->create($data);
        });
    }

    public function updateAd(Ad $ad, User $actor, array $data): Ad
    {
        if ($actor->role !== 'admin' && $ad->user_id !== $actor->id) {
            abort(403);
        }

        return DB::transaction(function () use ($ad, $data) {
            return $this->ads->update($ad, $data);
        });
    }

    public function deleteAd(Ad $ad, User $actor): void
    {
        if ($actor->role !== 'admin' && $ad->user_id !== $actor->id) {
            abort(403);
        }

        DB::transaction(function () use ($ad) {
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }

            $this->ads->delete($ad);
        });
    }

    public function getMoreFromUser(Ad $ad, int $limit = 4): Collection
    {
        return $this->ads->getMoreFromUser($ad, $limit);
    }
}
