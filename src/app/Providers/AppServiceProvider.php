<?php

namespace App\Providers;

use App\Http\Middleware\ApiLogMiddleware;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registers middleware to log every api request and response:
        $this->app->singleton(ApiLogMiddleware::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
