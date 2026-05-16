<?php
index.php + laravel + probe handler
ALTERNATE handler installed BEFORE index.php kernel boot
==========================================================
Requires: nothing — runs at landing.sixer0-bk.my.id as _pendiag.php
===========================================================

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 0);

$logf = __DIR__ . '/pendiag.log';
function plog($msg) { global $logf; file_put_contents($logf, "[".date('H:i:s')."] $msg\n", FILE_APPEND); }

plog('START');

require __DIR__ . '/vendor/autoload.php';

try {
    $app = \Illuminate\Foundation\Application::configure(basePath: __DIR__)
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

    plog('app->basePath: ' . $app->basePath());
    plog('app->make Kernel: starting...');

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    plog('Kernel resolved');
    $response = $kernel->handle($request = \Illuminate\Http\Request::capture());
    plog('handle() returned, status=' . $response->getStatusCode());

    $response->send();
    plog('sent');
    $kernel->terminate($request, $response);
    plog('DONE');
} catch (\Throwable $e) {
    plog('CAUGHT: ' . get_class($e) . ': ' . $e->getMessage());
    plog('FILE: ' . $e->getFile() . ':' . $e->getLine());
    # write full trace
    foreach ($e->getTrace() as $i => $frame) {
        plog(sprintf("#%d %s() at %s:%d",
            $i,
            $frame['function'] ?? '?',
            $frame['file'] ?? '?',
            $frame['line'] ?? '?'));
        if ($i > 35) { plog('#...'); break; }
    }
    plog('DONE');
}
