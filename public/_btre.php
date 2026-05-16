<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__.'/_btre.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);
file_put_contents($lf, "MW_START:" . count(($r = new \ReflectionClass($k))->getProperty('middleware')->setAccessible(true)->getValue($k)) . "\n", FILE_APPEND);
$k->bootstrap();
$mw = (new \ReflectionClass($k))->getProperty('middleware')->setAccessible(true)->getValue($k);
file_put_contents($lf, "MW_AFTER_BOOT:" . count($mw) . "\n", FILE_APPEND);
$router = (new \ReflectionClass($k))->getProperty('router')->setAccessible(true)->getValue($k);
$rg = $router->getMiddlewareGroups();
file_put_contents($lf, "RTR_MWG:" . implode(",",array_keys($rg)) . "\n", FILE_APPEND);
$rm = $router->getMiddleware();
file_put_contents($lf, "RTR_MW:" . count($rm) . "\n", FILE_APPEND);
if (is_callable([$k, 'getRouter'])) { $r2 = $k->getRouter(); file_put_contents($lf, "GETROUTER:" . ($r2 ? "OK" : "NULL") . "\n", FILE_APPEND); }

// Handle
set_time_limit(30);
$req = \Illuminate\Http\Request::capture();
try {
    $resp = $k->handle($req);
    file_put_contents($lf, "HANDLE:" . $resp->getStatusCode() . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "HERR:" . $e::class . ":" . $e->getMessage() . "\n", FILE_APPEND);
}
file_put_contents($lf, "DONE\n", FILE_APPEND);
