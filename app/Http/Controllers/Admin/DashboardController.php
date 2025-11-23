<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly AdminDashboardService $service,
    ) {}

    public function index()
    {
        $stats        = $this->service->getStats();
        $latestAds    = $this->service->getLatestAds(10);
        $categoryTree = $this->service->getCategoryTree();

        return view('admin.dashboard', compact('stats', 'latestAds', 'categoryTree'));
    }
}
