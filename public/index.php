<?php
/**
 * landing.sixer0-bk.my.id  —  public/index.php
 * LSPHP 8.5.5 / Laravel 11.52 / cPanel shared
 *
 * Directory layout on the server:
 *   landing.sixer0-bk.my.id/
 *     vendor/autoload.php
 *     routes/web.php        ← symlinked to routes/web.php
 *     app/…                 ← application code
 *     public/index.php      ← this file
 *     .env                  ← environment variables
 *
 *   __DIR__                = .../landing.sixer0-bk.my.id/public
 *   dirname(__DIR__)       =/public_html/landing.sixer0-bk.my.id  ← DOES NOT contain vendor/!
 *   dirname(dirname(__DIR__))=public_html  ← DOES contain vendor/
 *  => USE dirname(dirname(__DIR__))  AS THE APP BASE
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Kill any stale LSPHP opcode cache for this file
if (function_exists('opcache_invalidate')) { @opcache_invalidate(__FILE__, true); }
if (function_exists('opcache_reset'))      { @opcache_reset(); }

define('LARAVEL_START', microtime(true));

/**
 * Laravel project root: the directory that contains vendor/ and routes/
 */
$base = dirname(__DIR__);

require $base . '/vendor/autoload.php';

/**
 * Load .env — supplies APP_KEY, DB_DATABASE, SESSION_* etc.
 * Laravel's EncryptionServiceProvider reads APP_KEY from the env at
 * provider register time; without it the app dies with MissingAppKeyException.
 */
if (class_exists('\Dotenv\Dotenv')) {
    $envFile = $base . '/.env';
    if (file_exists($envFile)) {
        \Dotenv\Dotenv::createImmutable($base)->safeLoad();
    }
}

/**
 * Minimal safety net: give the app a key at runtime if .env was absent.
 * This lets the app boot long enough to return a useful error message
 * rather than a white-screen 500.
 */
if (empty($_ENV['APP_KEY'] ?? '')) {
    $_ENV['APP_KEY'] = 'base64:' . base64_encode(random_bytes(32));
}

/**
 * Build the Laravel application using the Laravel-12-style API that
 * Laravel 11.51+ supports via Illuminate\Foundation\Configuration\Middleware.
 *
 * WithRouting() points the framework at our routes/ directory which
 * lives NEXT TO this public/ folder (i.e. dirname(__DIR__) + '/routes/').
 *
 * WithMiddleware() is the single authoritative place for:
 *   - The "web" middleware group (global HTTP pipeline)
 *   - Individual middleware aliases (e.g. 'session.admin')
 */
$app = \Illuminate\Foundation\Application::configure(basePath: $base)
    ->withRouting(
        web:      $base . '/routes/web.php',
        commands: $base . '/routes/console.php',
        health:   '/up',
    )
    ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $m) {
        // ── Default "web" pipeline ──────────────────────────────────────
        $m->web(append: [
            App\Http\Middleware\TrustProxies::class,       // proxy/client-ip trust
            // CORS is ignored if not listed in config/cors.php → safe to include
            \Illuminate\Http\Middleware\HandleCors::class,  // CORS headers
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,  // body-size guard
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class, // 503 in maintenance
        ]);

        // ── Custom aliases used inside route() / route-group() ──────────
        $m->alias([
            'session.admin' => App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->create();

/**
 * Register our own ExceptionHandler BEFORE the first $kernel->handle().
 * The FrameworkServiceProvider does NOT guarantee this registration,
 * so we add it pre-emptively to avoid Container->build('handler') crashes.
 */
$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \App\Exceptions\AppExceptionHandler::class
);

/**
 * Resolve the HTTP kernel and dispatch the current request.
 * First making the Kernel triggers $middleware->syncMiddlewareToRouter()
 * which copies the web group and session.admin alias from the
 * withMiddleware() closure onto the Router — so subsequent route()
 * calls can find both 'web' and 'session.admin' by name.
 */
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = \Illuminate\Http\Request::capture());
$response->send();
$kernel->terminate($request, $response);
