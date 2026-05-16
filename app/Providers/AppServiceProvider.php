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

        // Register ExceptionHandler singleton so Kernel->reportException() works
        // during HTTP bootstrapping before FrameworkServiceProvider finishes.
        // This is a minimal fallback — FrameworkServiceProvider will configure the
        // real Handler once it finishes registering.
        $this->app->singleton(ExceptionHandlerContract::class, fn ($app) =>
            new DefaultExceptionHandler($app)
        );
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
