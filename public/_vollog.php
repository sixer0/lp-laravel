<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

$k = \Illuminate\Container\Container::getInstance()->make(\Illuminate\Contracts\Http\Kernel::class);
set_time_limit(30);

$req = \Illuminate\Http\Request::capture();
$resp = $k->handle($req);

// Pass through RESPONSE as-is — the 500 response already contains the full exception trace
echo $resp->getContent();
