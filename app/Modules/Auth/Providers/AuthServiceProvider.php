<?php

namespace App\Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::middleware('api')
            ->prefix(config('app.api_prefix', 'api/v1'))
            ->group(__DIR__ . '/../routes/api.php');
    }
}
