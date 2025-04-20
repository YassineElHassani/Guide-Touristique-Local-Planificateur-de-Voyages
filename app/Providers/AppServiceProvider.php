<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Register middleware aliases
        Route::middleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        Route::middleware('guide', \App\Http\Middleware\GuideMiddleware::class);
        Route::middleware('client', \App\Http\Middleware\ClientMiddleware::class);
        Route::middleware('auth.check', \App\Http\Middleware\AuthMiddleware::class);
    }
}
