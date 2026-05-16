<?php
/**
 * _smp.php — direct Laravel probe: __DIR__ as basePath, inline binds
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 0);

$logf = __DIR__ . '/smp.log';
function plog($m) { file_put_contents($logf, "[".date('H:i:s')."] $m\n", FILE_APPEND); }
plog('=== SMP START ===');

require __DIR__ . '/vendor/autoload.php';

try {
    $base = __DIR__;
    $app  = \Illuminate\Foundation\Application::configure(basePath: $base)
        ->withRouting(
            web: $base . '/routes/web.php',
            commands: $base . '/routes/console.php',
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

    plog('basePath: ' . $app->basePath());
    plog('creating config singleton...');

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
    plog('config singleton bound');

    $app->singleton(
        \Illuminate\Contracts\Debug\ExceptionHandler::class,
        \App\Exceptions\AppExceptionHandler::class
    );
    plog('ExceptionHandler singleton bound');

    // db singleton
    if (! $app->bound('db')) {
        $factory = new \Illuminate\Database\Connectors\ConnectionFactory($app);
        $app->instance('db', new \Illuminate\Database\DatabaseManager($app, $factory));
    }
    plog('db singleton bound');

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    plog('Kernel resolved');
    $response = $kernel->handle($request = \Illuminate\Http\Request::capture());
    $code = $response->getStatusCode();
    plog("handle() -> status=$code");
    $response->send();
    $kernel->terminate($request, $response);
    plog('DONE OK');
} catch (\Throwable $e) {
    plog('EXCEPTION: ' . get_class($e) . ' :: ' . $e->getMessage());
    plog('FILE: ' . $e->getFile() . ':' . $e->getLine());
    foreach ($e->getTrace() as $i => $f) {
        plog(sprintf("#%d %s() at %s:%d",
            $i, $f['function'] ?? '?', $f['file'] ?? '?', $f['line'] ?? '?'));
        if ($i > 30) { plog('#...'); break; }
    }
    plog('DONE (with exception)');
}
