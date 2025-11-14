<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api',
        then: function () {
            Route::middleware(['api', 'auth:sanctum'])
                ->prefix('api/user')
                ->as('api.v1.user.')
                ->group(base_path('routes/user.php'));
            Route::middleware(['web'])
                ->prefix('api/auth')
                ->as('api.v1.auth.')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        // Disable CSRF token verfication for API routes
        $middleware->validateCsrfTokens(except: [
            'api/auth/login',
            'api/auth/logout',
            'api/user/me',
            'sanctum/csrf-cookie',
            'login',
            'logout',
            'user',
        ]);

        // Enable CORS for all routes
        $middleware->web(\Illuminate\Http\Middleware\HandleCors::class);

        // Add Sanctum middleware for API authentication
        $middleware->alias([
            'auth:sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
