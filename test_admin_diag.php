<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

require '/root/.openclaw/workspace/sixer0-laravel/vendor/autoload.php';
$app = require '/root/.openclaw/workspace/sixer0-laravel/bootstrap/app.php';

try {
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $request = \Illuminate\Http\Request::create('/admin', 'GET');
    $_COOKIE['lara_cookie'] = 'bypass';

    // Simulate logged-in admin session
    $request->cookies->set('laravel_session', 'simulated');
    $request->server->set('REQUEST_URI', '/admin');
    $request->server->set('PATH_INFO', '/admin');

    $response = $kernel->handle($request);
    echo "STATUS: " . $response->getStatusCode() . "\n";
    echo "BODY (first 500): " . substr($response->getContent(), 0, 500) . "\n";
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    echo "EXCEPTION: " . get_class($e) . "\n";
    echo "MSG: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "TRACE:\n";
    foreach ($e->getTrace() as $i => $f) {
        echo sprintf("#%d %s() at %s:%d\n", $i, $f['function'] ?? '?', $f['file'] ?? '?', $f['line'] ?? '?');
        if ($i > 30) { echo "...\n"; break; }
    }
}
