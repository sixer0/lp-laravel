<?php
// Minimal probe: read the exception from the 500 response
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

$k = \Illuminate\Container\Container::getInstance()->make(\Illuminate\Contracts\Http\Kernel::class);
set_time_limit(30);
$req = \Illuminate\Http\Request::capture();

// Capture any ERROR_LOG PHP might write to via error_log()
$lf = __DIR__.'/_vollog2_tr.txt';
file_put_contents($lf, "START\n");

$resp = $k->handle($req);
file_put_contents($lf, "STATUS:" . $resp->getStatusCode() . "\n", FILE_APPEND);
file_put_contents($lf, "CT:" . $resp->headers->get('Content-Type') . "\n", FILE_APPEND);
$body = $resp->getContent();
// Save to file directly
file_put_contents(__DIR__.'/_vollog_bdy.txt', $body);
file_put_contents($lf, "BODY_LEN:" . strlen($body) . " SNIP:" . substr($body,0,300) . "\n", FILE_APPEND);
file_put_contents($lf, "END\n", FILE_APPEND);
