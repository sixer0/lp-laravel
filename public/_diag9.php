<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

$k = \Illuminate\Container\Container::getInstance()->make(\Illuminate\Contracts\Http\Kernel::class);
set_time_limit(30);

$lf = __DIR__.'/_diag9_tr.txt';
file_put_contents($lf, "START\n");

// Read Kernel middleware via reflection
$ref = new \ReflectionClass($k);
$mwp = $ref->getProperty('middleware'); $mwp->setAccessible(true);
$kmw = $mwp->getValue($k);
file_put_contents($lf, "KERNEL_MW:" . count($kmw) . "\n", FILE_APPEND);

$router = $k->getRouter();
$rg = $router->getMiddlewareGroups();
file_put_contents($lf, "RTR_MWG:" . implode(",",array_keys($rg)) . "\n", FILE_APPEND);

$req = \Illuminate\Http\Request::create("/","GET");
$router->getRoutes()->refreshNameLookups();
$router->getRoutes()->refreshActionLookups();

// Find the route for /
$route = $router->getRoutes()->match($req);
file_put_contents($lf, "ROUTE_URI:" . $route->uri() . "\n", FILE_APPEND);
file_put_contents($lf, "ROUTE_ACTION:" . $route->getActionName() . "\n", FILE_APPEND);

// Get route middleware
$mw = $route->gatherMiddleware();
file_put_contents($lf, "ROUTE_MW:" . json_encode($mw) . "\n", FILE_APPEND);

// Resolve middleware
$resolved = $router->resolveMiddleware($mw);
file_put_contents($lf, "RESOLVED:" . json_encode($resolved) . "\n", FILE_APPEND);

// Run through middleware manually
file_put_contents($lf, "RUN_START\n", FILE_APPEND);
foreach ($resolved as $mwClass) {
    file_put_contents($lf, "  -> " . (string)$mwClass . "\n", FILE_APPEND);
}
file_put_contents($lf, "RUN_END\n", FILE_APPEND);

// Invoke just the route action directly
file_put_contents($lf, "ACTION_INVOKE_START\n", FILE_APPEND);
set_time_limit(30);
try {
    $routeResult = $route->run();
    file_put_contents($lf, "ACTION_RUN_OK type=" . get_class($routeResult) . "\n", FILE_APPEND);
    if ($routeResult instanceof \Illuminate\Http\Response) {
        file_put_contents($lf, "ACTION_STATUS=" . $routeResult->getStatusCode() . "\n", FILE_APPEND);
        file_put_contents($lf, "ACTION_LEN=" . strlen($routeResult->getContent()) . "\n", FILE_APPEND);
    }
} catch (\Throwable $e) {
    file_put_contents($lf, "ACTION_ERR:" . $e::class . ":" . $e->getMessage() . "\n", FILE_APPEND);
    file_put_contents($lf, "AT:" . $e->getFile() . ":" . $e->getLine() . "\n", FILE_APPEND);
    foreach ($e->getTrace() as $t) {
        file_put_contents($lf, "TR:" . ($t['class']??'') . ($t['type']??'') . $t['function'] . "\n", FILE_APPEND);
    }
}

// Full handle()
file_put_contents($lf, "FULL_HANDLE_START\n", FILE_APPEND);
$req2 = \Illuminate\Http\Request::capture();
try {
    $resp = $k->handle($req2);
    file_put_contents($lf, "FULL_HANDLE=" . $resp->getStatusCode() . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "FULL_HANDLE_ERR:" . $e::class . ":" . $e->getMessage() . "\n", FILE_APPEND);
}

file_put_contents($lf, "DONE\n", FILE_APPEND);
