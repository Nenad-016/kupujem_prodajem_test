<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use App\Repositories\Contracts\AdRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdService
{
    public function __construct(
        protected AdRepositoryInterface $ads,
    ) {}

  
    public function listPublicAds(int $perPage = 15): LengthAwarePaginator
    {
        return $this->ads->getPublicAdsPaginated($perPage);
    }

  
    public function listPublicAdsByCategory(Category $category, int $perPage = 15): LengthAwarePaginator
    {
        return $this->ads->getAdsByCategory($category, $perPage);
    }

   
    public function listUserAds(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $this->ads->getAdsByUser($user, $perPage);
    }

   
    public function createForUser(User $user, array $data): Ad
    {
        $data['user_id'] = $user->id;

        if (! array_key_exists('status', $data)) {
            $data['status'] = 'draft';
        }

        /** @var Ad $ad */
        $ad = $this->ads->create($data);

        return $ad;
    }

  
    public function updateAd(Ad $ad, User $actingUser, array $data): bool
    {
        if (! $this->canManage($ad, $actingUser)) {
            throw new AuthorizationException('Nije ti dozvoljeno da menjaš ovaj oglas.');
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
