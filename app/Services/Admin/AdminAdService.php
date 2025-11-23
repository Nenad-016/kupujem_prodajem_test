<?php

namespace App\Services\Admin;

use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\Admin\AdminAdRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminAdService
{
    public function __construct(
        protected readonly AdminAdRepositoryInterface $ads,
    ) {}

    /**
     * Lista oglasa za admin panel.
     */
    public function listAds(int $perPage = 20): LengthAwarePaginator
    {
        return $this->ads->paginateWithRelations($perPage);
    }

    /**
     * Podaci za formu (create / edit) – kategorije + korisnici.
     */
    public function getFormData(): array
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $users = User::query()
            ->orderBy('name')
            ->get();

        return compact('categories', 'users');
    }

    /**
     * Kreiranje novog oglasa.
     */
    public function create(array $data, ?UploadedFile $image = null): Ad
    {
        if ($image) {
            $data['image_path'] = $image->store('ads', 'public');
        }

        return $this->ads->create($data);
    }

    /**
     * Ažuriranje oglasa.
     */
    public function update(Ad $ad, array $data, ?UploadedFile $image = null): Ad
    {
        if ($image) {
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }

            $data['image_path'] = $image->store('ads', 'public');
        }

        return $this->ads->update($ad, $data);
    }

    /**
     * Brisanje oglasa (uključujući i sliku).
     */
    public function delete(Ad $ad): void
    {
        if ($ad->image_path) {
            Storage::disk('public')->delete($ad->image_path);
        }

        $this->ads->delete($ad);
    }
}
