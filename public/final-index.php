<?php
/**
 * MAIN SITE final-index.php
 * landing.sixer0-bk.my.id  —  Laravel 11 / LSPHP 8.5.5 / cPanel shared
 *
 * Two manual pre-bootstrap bindings that Laravel 11.52 container
 * does not create automatically after Application::configure()->create():
 *   1. 'config' singleton  (registerCoreContainerAliases only aliases, doesn't bind)
 *   2. ExceptionHandler    (FrameworkServiceProvider may not fire first)
 *
 * Both must be present before $kernel->handle() to avoid BindingResolutionException.
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

// ── Binding fix 1: config ──────────────────────────────────────────────
// registerCoreContainerAliases() on 11.52 only calls alias(), not singleton().
// $app->make('config') inside RegisterProviders fails with "Target class [config] does not exist".
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

// ── Binding fix 2: ExceptionHandler ───────────────────────────────────
// FrameworkServiceProvider must register this; server vendor may miss it.
$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    \App\Exceptions\AppExceptionHandler::class
);

// ── Kernel lifecycle ──────────────────────────────────────────────────
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle($request = \Illuminate\Http\Request::capture());

$response->send();

$kernel->terminate($request, $response);
