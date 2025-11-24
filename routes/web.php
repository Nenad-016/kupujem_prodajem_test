<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Admin\AdminAdController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AdController::class, 'index'])->name('home');

Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');

Route::get('/categories/{category}/ads', [AdController::class, 'byCategory'])
    ->name('ads.by-category');

Route::get('/dashboard', function () {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('home');
    }

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('ads.my');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:user,admin')->group(function () {
        Route::get('/my-ads', [AdController::class, 'myAds'])->name('ads.my');

        Route::get('/my-ads/create', [AdController::class, 'create'])->name('ads.create');
        Route::post('/ads', [AdController::class, 'store'])->name('ads.store');

        Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
        Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update');
        Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');

    });
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Admin dashboard – DashboardController
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Categories (Admin)
        Route::get('/categories', [AdminCategoryController::class, 'index'])
            ->name('categories.index');

        Route::get('/categories/create', [AdminCategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/categories', [AdminCategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/categories/{category}', [AdminCategoryController::class, 'show'])
            ->name('categories.show');

        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])
            ->name('categories.destroy');

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        // Users (Admin)
        Route::get('/users/create', [AdminUserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [AdminUserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        // Ads (Admin)
        Route::get('/ads', [AdminAdController::class, 'index'])
            ->name('ads.index');

        Route::get('/ads/create', [AdminAdController::class, 'create'])
            ->name('ads.create');

        Route::post('/ads', [AdminAdController::class, 'store'])
            ->name('ads.store');

        Route::get('/ads/{ad}/edit', [AdminAdController::class, 'edit'])
            ->name('ads.edit');

        Route::put('/ads/{ad}', [AdminAdController::class, 'update'])
            ->name('ads.update');

        Route::delete('/ads/{ad}', [AdminAdController::class, 'destroy'])
            ->name('ads.destroy');

        Route::post('/ads/{ad}/restore', [AdminAdController::class, 'restore'])
            ->withTrashed()
            ->name('ads.restore');
    });

Route::get('/users/{user}', [UserProfileController::class, 'show'])
    ->name('users.profile');

require __DIR__.'/auth.php';
