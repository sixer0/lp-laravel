<?php
/**
 * MAIN SITE final-index.php  —  landing.sixer0-bk.my.id
 * Laravel 11.52 / LSPHP 8.5.5 / cPanel shared
 *
 * Pre-bootstrap bindings that registerCoreContainerAliases() / framework
 * service providers fail to populate on this server:
 *   1. 'config'  — alias only (not singleton), container has no concrete
 *   2. 'db'      — DatabaseServiceProvider registered in services.php but
 *                  Runtime environment (LSPHP/cPanel) prevents db binding.
 *                  Pre-bind a functional DatabaseManager with SQLite so the
 *                  app can boot without a live server DB.
 *   3. ExceptionHandler binding
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);

define('LARAVEL_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';

$app = \Illuminate\Foundation\Application::configure(basePath: dirname(__DIR__))
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
            \Illuminate\Http\Middleware\AddPathCookies::class,
        ]);
    })
    ->create();

// ── Fix 1: config binding ─────────────────────────────────────────────
if (! $app->bound('config')) {
    $app->instance('config', new \Illuminate\Config\Repository([
        'app' => [
            'name'            => $app->getName(),
            'env'             => $app->environment(),
            'debug'           => $app->hasDebugModeEnabled(),
            'url'             => $app->getUrl(),
            'timezone'        => $app->getTimezone(),
            'locale'          => $app->getLocale(),
            'fallback_locale' => $app->getFallbackLocale(),
        ],
    ]));
}

// ── Fix 2: ExceptionHandler (no filesystem writes, plain text return) ──
$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \App\Exceptions\AppExceptionHandler::class
);

// ── Fix 3: db binding ─────────────────────────────────────────────────
// services.php lists DatabaseServiceProvider but the container doesn't have
// a 'db' singleton after create() on this LSPHP server.  Bind a functional
// DatabaseManager backed by SQLite to let the app boot cleanly; migrations /
// schema writes are a no-op for SQLite — DB fix can be added separately.
if (! $app->bound('db')) {
    $pf = dirname(__DIR__);
    try {
        \Illuminate\Database\DBAL\Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            return new \Illuminate\Database\SQLiteConnection(
                new \Illuminate\Database\Connectors\SQLiteConnector(),
                file: $database,
                database: $database,
                tablePrefix: $prefix ?: ''
            );
        });
    } catch (\Throwable $e) {
        // ignore if resolver already set
    }
    $app->instance('db', new \Illuminate\Database\DatabaseManager(
        $app,
        new \Illuminate\Database\Connectors\ConnectionFactory($app)
    ));
}

// ── Kernel ────────────────────────────────────────────────────────────
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = \Illuminate\Http\Request::capture());
$response->send();
$kernel->terminate($request, $response);
