<?php
/**
 * _p9.php — full-smoke probe: basePath=__, 3 binds + try/catch + trace to _p9log.txt
 * landing.sixer0-bk.my.id / LSPHP 8.5.5 / Laravel 11.51
 * =========================================================
 * 1.   opcache_invalidate + opcache_reset  (first line!)
 * 2.   vendor/autoload
 * 3.   config  BIND
 * 4.   ExceptionHandler BIND
 * 5.   db BIND  (force SQLite always)
 * 6.   Kernel → handle() inside try/catch
 * 7.   Write full trace to _p9log.txt on any exception
 * =========================================================
 */
error_reporting(E_ALL); ini_set('display_errors', 0); ini_set('log_errors', 0);

$LOG = __DIR__ . '/_p9log.txt';
$w = function ($s) use ($LOG) { @file_put_contents($LOG, '['.date('H:i:s').'] '.$s."\n", FILE_APPEND); };
$w('P9 START');

if (function_exists('opcache_invalidate')) @opcache_invalidate(__FILE__, true);
if (function_exists('opcache_reset'))      { @opcache_reset(); $w('opcache_reset done'); }

require __DIR__ . '/vendor/autoload.php';
$w('autoloaded');

try {
    $app = \Illuminate\Foundation\Application::configure(basePath: __DIR__)
        ->withRouting(
            web: __DIR__ . '/routes/web.php',
            commands: __DIR__ . '/routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function ($m) {
            $m->web(append: [
                \App\Http\Middleware\TrustProxies::class,
                \Illuminate\Http\Middleware\HandleCors::class,
                \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
                \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
                \Illuminate\Http\Middleware\AddPathCookies::class,
            ]);
        })
        ->create();
    $w('app->basePath = ' . $app->basePath());
    $w('app->version()  = ' . $app->version());

    // BIND 1 — config
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
            'default'         => 'sqlite',
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
    $w('config bound');

    // BIND 2 — ExceptionHandler
    $app->singleton(
        \Illuminate\Contracts\Debug\ExceptionHandler::class,
        \App\Exceptions\AppExceptionHandler::class
    );
    $w('ExceptionHandler bound');

    // BIND 3 — db
    if (! $app->bound('db')) {
        $factory = new \Illuminate\Database\Connectors\ConnectionFactory($app);
        $app->instance('db', new \Illuminate\Database\DatabaseManager($app, $factory));
    }
    $w('db bound');

    // Kernel
    $w('resolving Kernel...');
    $kernel    = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $w('Kernel resolved: ' . get_class($kernel));

    $w('calling handle()...');
    $response  = $kernel->handle($request = \Illuminate\Http\Request::capture());
    $code      = $response->getStatusCode();
    $w('handle() status: ' . $code);
    $response->send();
    $kernel->terminate($request, $response);
    $w('DONE OK - status ' . $code);

} catch (\Throwable $e) {
    $w('CAUGHT: ' . get_class($e) . ' :: ' . $e->getMessage());
    $w('FILE: ' . $e->getFile() . ':' . $e->getLine());
    foreach ($e->getTrace() as $i => $f) {
        $w(sprintf('#%d %s() at %s:%d', $i, $f['function'] ?? '?', $f['file'] ?? '?', $f['line'] ?? '?'));
        if ($i > 50) { $w('#...too many frames'); break; }
    }
    $w('DONE exception');
    // Fall through — return 200 so curl sees our status_code
}

// Respond with log existence
@header('Content-Type: text/plain');
echo "P9 probe complete — check _p9log.txt\n";
