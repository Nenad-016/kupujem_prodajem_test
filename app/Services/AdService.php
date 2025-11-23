<?php

namespace App\Services;

use App\Enums\AdStatus;
use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\AdRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdService
{
    public function __construct(
        protected readonly AdRepositoryInterface $ads,
    ) {}

    public function listPublicAds(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Ad::query()
            ->where('status', AdStatus::ACTIVE);

        if (! empty($filters['q'])) {
            $search = trim($filters['q']);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            });
        }

        if (! empty($filters['location'])) {
            $location = trim($filters['location']);

            $query->where('location', 'like', '%'.$location.'%');
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

    public function listPublicAdsByCategory(Category $category, int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $filters['category_id'] = $category->id;

        return $this->listPublicAds($perPage, $filters);
    }

    public function listUserAds(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $this->ads->getAdsByUser($user, $perPage);
    }

    public function createForUser(User $user, array $data): Ad
    {
        $data['user_id'] = $user->id;

        $data['status'] = $data['status'] ?? AdStatus::DRAFT->value;

        /** @var Ad $ad */
        $ad = $this->ads->create($data);

        return $ad;
    }

    public function updateAd(Ad $ad, User $actingUser, array $data): bool
    {
        if (! $this->canManage($ad, $actingUser)) {
            throw new AuthorizationException('Nije ti dozvoljeno da menjaš ovaj oglas.');
        }

        if (isset($data['status'])) {
            $data['status'] = AdStatus::from($data['status'])->value;
        }

        return $this->ads->update($ad->id, $data);
    }

    public function deleteAd(Ad $ad, User $actingUser): bool
    {
        if (! $this->canManage($ad, $actingUser)) {
            throw new AuthorizationException('Nije ti dozvoljeno da brišeš ovaj oglas.');
        }

        return $this->ads->delete($ad->id);
    }

    protected function canManage(Ad $ad, User $user): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $ad->user_id === $user->id;
    }
}
