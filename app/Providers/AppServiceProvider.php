<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Ensure public path is correct
        $this->app->bind('path.public', fn() => base_path('public'));

        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Custom Blade directives
        Blade::if('dev', fn () => $this->app->environment('local'));
        
        // Set timezone
        date_default_timezone_set('Asia/Jakarta');
    }
}
