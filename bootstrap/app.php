<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {

            Route::middleware('api')
                ->prefix('admin')
                ->group(base_path('routes/Apis/admin.php'));

            Route::middleware('api')
                ->prefix('client')
                ->group(base_path('routes/Apis/client.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // 🔵 API JSON support
        $middleware->statefulApi();

        // 🔐 Sanctum
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // 🧠 Role middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 🔐 401
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e) {
            return api_response('fail', 'Unauthenticated', null, 401);
        });

        // 🚫 404
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return api_response('fail', 'Route not found', null, 404);
        });

        // ❌ 422
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e) {
            return api_response('fail', 'Validation error', $e->errors(), 422);
        });

        // 💥 500
        $exceptions->render(function (\Throwable $e) {
            return api_response(
                'fail',
                'Server error',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        });
    })
    ->create();
