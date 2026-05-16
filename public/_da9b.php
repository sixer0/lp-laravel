<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__.'/_da9b_tr.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);

file_put_contents($lf, "MW=" . implode(",", array_keys($k->getMiddlewareGroups())) . "\n");

// Use reflection to access protected $router
$ref = new \ReflectionClass($k);
$routerProp = $ref->getProperty('router');
$routerProp->setAccessible(true);
$router = $routerProp->getValue($k);
file_put_contents($lf, "ROUTER_CLASS=" . get_class($router) . "\n", FILE_APPEND);

$rg = $router->getMiddlewareGroups();
file_put_contents($lf, "ROUTER_MWG=" . implode(",",array_keys($rg)) . "\n", FILE_APPEND);
$rm = $router->getMiddleware();
file_put_contents($lf, "ROUTER_MW_COUNT=" . count($rm) . "\n", FILE_APPEND);

// Test resolveMiddleware for ['web']
try {
    $resolved = $router->resolveMiddleware(['web']);
    file_put_contents($lf, "RESOLVE_WEB=" . json_encode($resolved) . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "RESOLVE_ERR:" . $e->getMessage() . "|" . $e->getFile() . ":" . $e->getLine() . "\n", FILE_APPEND);
}

// Test Kernel::gatherRouteMiddleware
$req = \Illuminate\Http\Request::create("/","GET");
try {
    $gRef = $ref->getMethod('gatherRouteMiddleware');
    $gRef->setAccessible(true);
    $gathered = $gRef->invoke($k, $req);
    file_put_contents($lf, "GATHER=" . json_encode($gathered) . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "GATHER_ERR:" . $e->getMessage() . "\n", FILE_APPEND);
}

// Test sendRequestThroughRouter pipeline with timeout
file_put_contents($lf, "PIPELINE_START\n", FILE_APPEND);
$req2 = \Illuminate\Http\Request::create("/","GET");
try {
    $sendRef = $ref->getMethod('sendRequestThroughRouter');
    $sendRef->setAccessible(true);
    set_time_limit(5);
    $resp = $sendRef->invoke($k, $req2);
    file_put_contents($lf, "PIPELINE_OK=" . $resp->getStatusCode() . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "PIPELINE_ERR:" . $e->getMessage() . "|" . $e->getFile() . ":" . $e->getLine() . "\n", FILE_APPEND);
}

file_put_contents($lf, "DONE\n", FILE_APPEND);
