<?php
error_reporting(E_ALL);
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

$lf = __DIR__.'/_btr.txt';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);

file_put_contents($lf, "KERNEL:" . get_class($k) . "\n");

$ref = new \ReflectionClass($k);
$mwp = $ref->getProperty('middleware'); $mwp->setAccessible(true);
file_put_contents($lf, "MW:" . count($mwp->getValue($k)) . "\n", FILE_APPEND);

// Get router via reflection
$rp = $ref->getProperty('router'); $rp->setAccessible(true);
$router = $rp->getValue($k);
file_put_contents($lf, "ROUTER:" . get_class($router) . "\n", FILE_APPEND);

// Call handle() BUT capture better
set_time_limit(30);
$req = \Illuminate\Http\Request::capture();

// Use reflection to call handle(), catch exceptions at each sub-phase
$hRef = $ref->getMethod('handle'); $hRef->setAccessible(true);
try {
    $resp = $hRef->invoke($k, $req);
    file_put_contents($lf, "H=" . $resp->getStatusCode() . "\n", FILE_APPEND);
    $ct = $resp->headers->get('Content-Type');
    file_put_contents($lf, "CT=" . ($ct ?: 'none') . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "HER:" . $e->getMessage() . "\n", FILE_APPEND);
}

file_put_contents($lf, "DONE\n", FILE_APPEND);
