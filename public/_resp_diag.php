<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__.'/_resp_diag_tr.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);
set_time_limit(30);

$req = \Illuminate\Http\Request::capture();
$response = $k->handle($req);
$k->terminate($req, $response);

file_put_contents($lf, "STATUS:" . $response->getStatusCode() . "\n");
file_put_contents($lf, "CT:" . ($response->headers->get('Content-Type') ?? 'none') . "\n", FILE_APPEND);
$body = $response->getContent();
file_put_contents($lf, "BODY_LEN:" . strlen($body) . "\n", FILE_APPEND);
// Save full body
file_put_contents(__DIR__.'/_resp_body.txt', $body);
file_put_contents($lf, "BODY_SNIP:" . substr($body,0,400) . "\n", FILE_APPEND);
file_put_contents($lf, "DONE\n", FILE_APPEND);
