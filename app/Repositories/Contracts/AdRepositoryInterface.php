<?php

namespace App\Repositories\Contracts;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdRepositoryInterface
{
    public function findById(int $id): ?Ad;

    public function findForUser(int $id, User $user): ?Ad;

    public function listPublicAds(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function listUserAds(User $user, int $perPage = 15): LengthAwarePaginator;

    public function create(array $data): Ad;

    public function update(Ad $ad, array $data): Ad;

    public function delete(Ad $ad): void;
}
