<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use App\Exceptions\AppExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services — runs during ProviderRepository::load() before create().
     */
    public function register(): void
    {
        // Don't force public path — server index.php + .htaccess handle it.
        // $this->app->bind('path.public', fn() => base_path('public'));

        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap services — runs AFTER all providers ->register() -> boot().
     *
     * ExceptionHandler is intentionally declared here (not in register())
     * because DefaultExceptionHandler($app) tries to resolve Log/Cache
     * facades during its own constructor, which would fire before those
     * facades are bound in FrameworkServiceProvider::register().
     *
     * At boot-time every provider has already fired register(), so
     * the container is in a consistent state and AppExceptionHandler
     * (which has zero dependencies) can be safely bound.
     */
    public function boot(): void
    {
        $this->app->singleton(
            ExceptionHandlerContract::class,
            AppExceptionHandler::class
        );

        // Custom Blade directives
        Blade::if('dev', fn () => $this->app->environment('local'));

        // Set timezone
        date_default_timezone_set('Asia/Jakarta');
    }
}
