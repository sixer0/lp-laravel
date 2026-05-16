<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__ . '/_full_handler_tr.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

$app = \Illuminate\Container\Container::getInstance();

// Measure elapsed time for each phase
$phases = [];

// Phase 1: make Kernel
$t = microtime(true);
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$phases['make_kernel'] = round((microtime(true)-$t)*1000, 2);

// Phase 2: create request  
$t = microtime(true);
$req = \Illuminate\Http\Request::capture();
$phases['create_req'] = round((microtime(true)-$t)*1000, 2);

// Phase 3: handle
$t = microtime(true);
set_time_limit(30);
$resp = $k->handle($req);
$phases['handle'] = round((microtime(true)-$t)*1000, 2);

$t = microtime(true);
$k->terminate($req, $resp);
$phases['terminate'] = round((microtime(true)-$t)*1000, 2);

file_put_contents($lf, "STATUS:" . $resp->getStatusCode() . "\n");
file_put_contents($lf, "CT:" . ($resp->headers->get('Content-Type') ?? 'none') . "\n", FILE_APPEND);
$body = $resp->getContent();
file_put_contents($lf, "BODY:" . $body . "\n", FILE_APPEND);
