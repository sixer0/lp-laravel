<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__.'/_da9a_tr.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);

file_put_contents($lf, "KERNEL=" . get_class($k) . "\n");
file_put_contents($lf, "MW=" . implode(",", array_keys($k->getMiddlewareGroups())) . "\n", FILE_APPEND);

$router = property_exists($k, 'router') ? $k->router : null;
if (!$router && method_exists($k, 'getRouter')) { $router = $k->getRouter(); }
file_put_contents($lf, "ROUTER=" . ($router ? get_class($router) : "NULL") . "\n", FILE_APPEND);

if ($router) {
    $rg = $router->getMiddlewareGroups();
    file_put_contents($lf, "ROUTER_MWG=" . implode(",", array_keys($rg)) . "\n", FILE_APPEND);
    $rm = $router->getMiddleware();
    file_put_contents($lf, "ROUTER_MW=" . implode(",", $rm) . "\n", FILE_APPEND);
}

$req = \Illuminate\Http\Request::create("/", "GET");
$router?->getRoutes()->refreshNameLookups();
$router?->getRoutes()->refreshActionLookups();

if ($router) {
    try {
        $route = $router->getRoutes()->match($req);
        file_put_contents($lf, "MATCH_URI=" . $route->uri() . "\n", FILE_APPEND);
        $rmw = $route->gatherMiddleware();
        file_put_contents($lf, "ROUTE_MW=" . json_encode($rmw) . "\n", FILE_APPEND);
        $resolved = $router->resolveMiddleware($rmw);
        file_put_contents($lf, "RESOLVED=" . json_encode($resolved) . "\n", FILE_APPEND);
    } catch (\Throwable $e) {
        file_put_contents($lf, "MATCH_ERR:" . $e->getMessage() . "|" . $e->getFile() . ":" . $e->getLine() . "\n", FILE_APPEND);
    }
}

file_put_contents($lf, "DONE\n", FILE_APPEND);
