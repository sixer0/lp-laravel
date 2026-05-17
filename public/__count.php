<?php
// __count.php — count errors BEFORE Laravel returns anything
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 0);

$cnt = 0;
set_error_handler(function($errno, $errstr, $errfile, $errline) use (&$cnt) {
    $cnt++;
    $GLOBALS['errors'][] = ['errno'=>$errno,'msg'=>$errstr,'file'=>$errfile,'line'=>$errline];
    return false; // let PHP handle normally
}, E_ALL);

require __DIR__ . '/vendor/autoload.php';

$base = dirname(__DIR__);
try {
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
                \Illuminate\Http\Middleware\AddPathCookies::class,
            ]);
        })
        ->create();

    // BIND1: config
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

    // BIND2: ExceptionHandler
    $app->singleton(
        \Illuminate\Contracts\Debug\ExceptionHandler::class,
        \App\Exceptions\AppExceptionHandler::class
    );

    // BIND3: db singleton
    if (! $app->bound('db')) {
        try {
            if (! \Illuminate\Database\DBAL\Connection::getResolver('sqlite')) {
                \Illuminate\Database\DBAL\Connection::resolverFor('sqlite', function (
                    $conn, $database, $prefix, $cfg
                ) {
                    return new \Illuminate\Database\SQLiteConnection(
                        new \Illuminate\Database\Connectors\SQLiteConnector(),
                        file: $database, database: $database, tablePrefix: $prefix ?: ''
                    );
                });
            }
        } catch (\Throwable $e_) { /* ignore */ }

        $factory = new \Illuminate\Database\Connectors\ConnectionFactory($app);
        $app->instance('db', new \Illuminate\Database\DatabaseManager($app, $factory));
    }

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request = \Illuminate\Http\Request::capture());
    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    http_response_code(200);
    header('Content-Type: text/plain');
    echo "FATAL: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . ":" . $e->getLine() . "\n";
    foreach ($e->getTrace() as $i => $frame) {
        echo sprintf("#%d %s(%s) at %s:%d\n", $i,
            $frame['function'] ?? '?',
            implode(',', array_slice($frame['args'] ?? [], 0, 2)),
            $frame['file'] ?? '?', $frame['line'] ?? '?');
        if ($i > 15) { echo "#...\n"; break; }
    }
    echo "---\n";
    echo "Errors caught by set_error_handler: $cnt\n";
    if (!empty($GLOBALS['errors'])) {
        echo "Errors:\n";
        foreach ($GLOBALS['errors'] as $er) {
            echo "  #{$er['errno']} {$er['msg']} @ {$er['file']}:{$er['line']}\n";
        }
    }
    exit(0);
}

http_response_code(200);
echo "SUCCESS: kernel->handle() returned without throw, {cnt} deprecations\n";
