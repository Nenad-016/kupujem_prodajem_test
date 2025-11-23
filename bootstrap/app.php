<?php

use App\Http\Middleware\RoleMiddleware;
use App\Repositories\Contracts\Admin\AdminAdRepositoryInterface;
use App\Repositories\Contracts\AdRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Admin\EloquentAdminAdRepository;
use App\Repositories\Eloquent\EloquentAdRepository;
use App\Repositories\Eloquent\EloquentCategoryRepository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSingletons([
        AdRepositoryInterface::class => EloquentAdRepository::class,
        CategoryRepositoryInterface::class => EloquentCategoryRepository::class,
        AdminAdRepositoryInterface::class => EloquentAdminAdRepository::class,

    ])
    ->create();
