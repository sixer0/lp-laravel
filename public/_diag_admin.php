<?php
// _diag_admin.php — diagnose /admin 500 error
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);

echo "=== _diag_admin.php ===\n";

require __DIR__ . '/../sixer0-laravel/vendor/autoload.php';
$app = require __DIR__ . '/../sixer0-laravel/bootstrap/app.php';

try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    echo "STATUS: " . $response->getStatusCode() . "\n";
    echo "Content-Type: " . $response->headers->get('Content-Type') . "\n";
    echo "BODY: " . substr($response->getContent(), 0, 300) . "\n";
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
