<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

$lf = '/tmp/_vollog_resp.txt';
$k = \Illuminate\Container\Container::getInstance()->make(\Illuminate\Contracts\Http\Kernel::class);
set_time_limit(30);
$req = \Illuminate\Http\Request::capture();
$resp = $k->handle($req);

try {
    file_put_contents($lf, $resp->getContent());
} catch (\Throwable $e) {
    file_put_contents($lf, "WRITE_ERR:" . $e->getMessage() . "\n");
}
