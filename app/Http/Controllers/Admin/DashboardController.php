<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'ads_count' => Ad::count(),
            'users_count' => User::count(),
            'categories_count' => Category::count(),
            'root_categories_count' => Category::whereNull('parent_id')->count(),
            'ads_today' => Ad::whereDate('created_at', today())->count(),
            'users_today' => User::whereDate('created_at', today())->count(),
        ];

        $latestAds = Ad::query()
            ->with(['category', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        $categoryTree = Category::query()
            ->with(['children.children.children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.dashboard', compact('stats', 'latestAds', 'categoryTree'));
    }
}
