<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Ad;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdminAdRepositoryInterface
{
    /**
     * Admin lista oglasa
     */
    public function paginateWithRelations(int $perPage = 20): LengthAwarePaginator;

    /**
     * Kreiranje novog oglasa.
     */
    public function create(array $data): Ad;

    /**
     * Ažuriranje postojećeg oglasa.
     */
    public function update(Ad $ad, array $data): Ad;

    /**
     * Brisanje oglasa.
     */
    public function delete(Ad $ad): void;
}
