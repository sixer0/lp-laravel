<?php
error_reporting(E_ALL);
$lf = __DIR__.'/_boot_diag_tr.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);
file_put_contents($lf, "KERNEL_OK:" . get_class($k) . "\n");

// Get middleware via reflection
$ref = new \ReflectionClass($k);
$mwp = $ref->getProperty('middleware'); $mwp->setAccessible(true);
$mw = $mwp->getValue($k);
file_put_contents($lf, "MW_COUNT:" . count($mw) . "\n", FILE_APPEND);

// Bootstrap
set_time_limit(30);
$k->bootstrap();
file_put_contents($lf, "BOOTSTRAP_OK\n", FILE_APPEND);
$mw2 = $mwp->getValue($k);
file_put_contents($lf, "MW_AFTER:" . count($mw2) . "\n", FILE_APPEND);

// Pipeline without final destination - step through global middleware one at a time
$req = \Illuminate\Http\Request::create("/", "GET");
file_put_contents($lf, "PIPE_START\n", FILE_APPEND);
foreach ($mw2 as $i => $pipe) {
    file_put_contents($lf, "M{$i}:" . (string)$pipe . "\n", FILE_APPEND);
    try {
        if (!is_string($pipe)) { file_put_contents($lf, "M{$i}:SKIP_NONSTRING\n", FILE_APPEND); continue; }
        if (!class_exists($pipe)) { file_put_contents($lf, "M{$i}:CLASS_MISSING\n", FILE_APPEND); continue; }
        $inst = $app->make($pipe);
        file_put_contents($lf, "M{$i}:MAKE_OK:" . get_class($inst) . "\n", FILE_APPEND);
        if (!method_exists($inst, 'handle')) { file_put_contents($lf, "M{$i}:NO_HANDLE\n", FILE_APPEND); continue; }
        $out = $inst->handle($req, fn($r) => $r);
        file_put_contents($lf, "M{$i}:OK type=" . get_class($out) . "\n", FILE_APPEND);
        if ($out instanceof \Illuminate\Http\Response) { $req = $out; }
    } catch (\Throwable $e) {
        file_put_contents($lf, "M{$i}:ERR:" . $e::class . ":" . substr($e->getMessage(),0,150) . "\n", FILE_APPEND);
    }
}
file_put_contents($lf, "PIPE_DONE\n", FILE_APPEND);

// Now dispatchToRouter
file_put_contents($lf, "DISPATCH_START\n", FILE_APPEND);
try {
    $resp = $k->handle(\Illuminate\Http\Request::capture());
    file_put_contents($lf, "HANDLE_OK:" . $resp->getStatusCode() . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "HANDLE_ERR:" . $e::class . ":" . $e->getMessage() . "\n", FILE_APPEND);
}
file_put_contents($lf, "FINAL_DONE\n", FILE_APPEND);
