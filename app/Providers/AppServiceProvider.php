<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Foundation\Exceptions\Handler as DefaultExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Don't force public path — server already has index.php + .htaccess handling it
        // $this->app->bind('path.public', fn() => base_path('public'));

        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // NOTE: ExceptionHandler is NOT bound here on purpose.
        // DefaultExceptionHandler($app) resolves Log/Cache Facades during
        // register(), before FrameworkServiceProvider finishes binding them
        // — causing "Class 'Log' not found" in bootstrap/app.php.
        // FrameworkServiceProvider registers the real handler after create().
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
