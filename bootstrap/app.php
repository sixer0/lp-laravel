<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\Contracts\View\Factory as FactoryContract;
use Illuminate\Filesystem\Filesystem as NativeFilesystem;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\View\Compilers\BladeCompiler;

$builder = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        ]);
        $middleware->alias([
            'session.admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Throwable $e) {});
    })
    ->withProviders([
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Routing\RoutingServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ]);

$app = $builder->create();

// ╔══════════════════════════════════════════════════════════════════════╗
// ║  PHP >= 8.5 Alias Bridge — short-name binding closures                ║
// ╚══════════════════════════════════════════════════════════════════════╝
// Container::$aliases is empty on LSPHP 8.5.
// make('config') / make('view') would hit Reflection -> die.
// We install FACADES-style concrete bindings (Closures) so make()
// short-circuits into the closure, never calls build()/ReflectionClass.

// ── config ────────────────────────────────────────────────────────────────
$app->bind('config', fn(): \Illuminate\Config\Repository => new \Illuminate\Config\Repository([]));

// ── events ────────────────────────────────────────────────────────────────
$app->bind('events', fn($app): \Illuminate\Contracts\Events\Dispatcher => new \Illuminate\Events\Dispatcher($app));

// ── view ──────────────────────────────────────────────────────────────────
// Build EngineResolver up-front and close over it in the binding closure.
$engineResolver = new EngineResolver();
$engineResolver->register('php', fn() => new \Illuminate\View\Engines\PhpEngine());

$bladeCompiler = new BladeCompiler(
    new NativeFilesystem(),
    dirname(__DIR__) . '/storage/framework/views',
);
$engineResolver->register('blade', fn() => new \Illuminate\View\Engines\CompilerEngine($bladeCompiler));

$viewsDir = dirname(__DIR__) . '/resources/views';
$finder   = new FileViewFinder(new NativeFilesystem(), [$viewsDir]);

$app->bind(FactoryContract::class, fn($app): Factory => new Factory(
    $engineResolver,
    $finder,
    $app->make(DispatcherContract::class),
));

// Short alias 'view' -> FactoryContract.
$app->bind('view', fn($app) => $app->make(FactoryContract::class));

return $app;
