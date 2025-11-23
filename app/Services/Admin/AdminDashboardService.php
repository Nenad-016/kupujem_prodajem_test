<?php

namespace App\Services\Admin;

use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Collection;

class AdminDashboardService
{
    /**
     * Statistika za dashboard.
     */
    public function getStats(): array
    {
        return [
            'ads_count' => Ad::count(),
            'users_count' => User::count(),
            'categories_count' => Category::count(),
            'root_categories_count' => Category::whereNull('parent_id')->count(),
            'ads_today' => Ad::whereDate('created_at', today())->count(),
            'users_today' => User::whereDate('created_at', today())->count(),
        ];
    }

    /**
     * Najnovijih X oglasa.
     */
    public function getLatestAds(int $limit = 10): Collection
    {
        return Ad::query()
            ->with(['category', 'user'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Hijerarhija kategorija
     */
    public function getCategoryTree(): Collection
    {
        return Category::query()
            ->with(['children.children.children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }
}
