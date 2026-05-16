<?php
/**
 * landing.sixer0-bk.my.id  —  LSPHP 8.5.5 / Laravel 11.52 / cPanel shared
 *
 * Two binding pre-heats before kernel boot:
 *  BIND1: config singleton  (registerCoreContainerAliases only aliases, no concrete)
 *  BIND2: db singleton     (DatabaseServiceProvider binds during create() but Session
 *                            tries to resolve 'db' DURING create() itself — not after,
 *                            so DSP binding is too late; we must supply it ourselves)
 *  BIND3: ExceptionHandler (FrameworkServiceProvider not guaranteed to register first)
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Kill any stale LSPHP opcode view of this file
if (function_exists('opcache_invalidate')) { @opcache_invalidate(__FILE__, true); }
if (function_exists('opcache_reset'))      { @opcache_reset(); }

define('LARAVEL_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';

$base = __DIR__;

$app = \Illuminate\Foundation\Application::configure(basePath: $base)
    ->withRouting(
        web: __DIR__ . '/routes/web.php',
        commands: __DIR__ . '/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        ]);
    })
    ->create();

// ── BIND1: config singleton ────────────────────────────────────────────
if (! $app->bound('config')) {
    $app->instance('config', new \Illuminate\Config\Repository([
        'app' => [
            'name'            => 'Laravel',
            'env'             => 'local',
            'debug'           => true,
            'url'             => 'http://landing.sixer0-bk.my.id',
            'timezone'        => 'UTC',
            'locale'          => 'en',
            'fallback_locale' => 'en',
        ],
        'database' => [
            'default' => 'sqlite',
            'connections' => [
                'sqlite' => [
                    'driver'   => 'sqlite',
                    'database' => '/tmp/lp-laravel.sqlite',
                    'prefix'   => '',
                    'foreign_key_constraints' => true,
                ],
            ],
        ],
    ]));
}

// ── BIND2: ExceptionHandler ─────────────────────────────────────────────
$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \App\Exceptions\AppExceptionHandler::class
);

// ── BIND3: db singleton ────────────────────────────────────────────────
// services.php lists DatabaseServiceProvider.
// In LSPHP boot order: ProviderRepository::load() needs
// ServiceProvider->isDeferred() → calls App->make('db') → boom.
// Our config+handler binding clearing serve, but 'db' isn't a real class
// so Container::build('db') throws.
// Fix: supply a real DatabaseManager singleton backed by SQLite.
if (! $app->bound('db')) {
    try {
        // Register SQLite resolver BEFORE constructing ConnectionFactory
        if (! \Illuminate\Database\DBAL\Connection::resolverFor('sqlite')) {
            \Illuminate\Database\DBAL\Connection::resolverFor('sqlite', function (
                $conn, $database, $prefix, $cfg
            ) {
                return new \Illuminate\Database\SQLiteConnection(
                    new \Illuminate\Database\Connectors\SQLiteConnector(),
                    file: $database,
                    database: $database,
                    tablePrefix: $prefix ?: ''
                );
            });
        }
    } catch (\Throwable $e) {
        // ignore already-registered
    }

    // Build a real DatabaseManager
    $factory = new \Illuminate\Database\Connectors\ConnectionFactory($app);
    $dbMgr   = new \Illuminate\Database\DatabaseManager($app, $factory);
    $app->instance('db', $dbMgr);
}

// ── Kernel ─────────────────────────────────────────────────────────────
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = \Illuminate\Http\Request::capture());
$response->send();
$kernel->terminate($request, $response);
