<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__.'/_mboot_tr.txt';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$ref = new \ReflectionClass($k);
$mwProp = $ref->getProperty('middleware');
$mwProp->setAccessible(true);
$allMw = $mwProp->getValue($k);
file_put_contents($lf, "ALL_MW=" . json_encode($allMw) . "\n");

// Step through each middleware individually
$req = \Illuminate\Http\Request::create("/","GET");
foreach ($allMw as $i => $mwClass) {
    file_put_contents($lf, "STEP{$i}:{$mwClass}\n", FILE_APPEND);
    try {
        if (!class_exists($mwClass) && !str_ends_with($mwClass, ']') && is_string($mwClass)) {
            file_put_contents($lf, "STEP{$i}:CLASS_MISSING\n", FILE_APPEND);
            continue;
        }
        if (is_string($mwClass) && class_exists($mwClass)) {
            $inst = new $mwClass();
        } elseif (is_callable($mwClass)) {
            file_put_contents($lf, "STEP{$i}:CLOSURE\n", FILE_APPEND);
            continue;
        } else {
            file_put_contents($lf, "STEP{$i}:SKIP type=" . gettype($mwClass) . "\n", FILE_APPEND);
            continue;
        }
        if (method_exists($inst, 'handle')) {
            $rm = new \ReflectionMethod($inst, 'handle');
            $n = $rm->getNumberOfParameters();
            $sig = [];
            for ($j=0; $j<$n; $j++) {
                $p = $rm->getParameter($j);
                $sig[] = $p->getName();
            }
            file_put_contents($lf, "STEP{$i}:handle(params=" . implode(",",$sig) . ")\n", FILE_APPEND);
            // Can we call it? Only skip middleware/terminable check
            if (is_subclass_of($mwClass, \Illuminate\Contracts\Http\Kernel::class)) {
                // kernel middleware that expects closure
                file_put_contents($lf, "STEP{$i}:IS_KERNEL_MW skip\n", FILE_APPEND);
            } else {
                // Regular handle
                try {
                    $resp = $inst->handle($req, function($r) { return $r; });
                    file_put_contents($lf, "STEP{$i}:RESPONSE\n", FILE_APPEND);
                } catch (\Throwable $e) {
                    file_put_contents($lf, "STEP{$i}:ERR:" . substr($e->getMessage(),0,80) . "\n", FILE_APPEND);
                }
            }
        } else {
            file_put_contents($lf, "STEP{$i}:NO_HANDLE\n", FILE_APPEND);
        }
    } catch (\Throwable $e) {
        file_put_contents($lf, "STEP{$i}:FATAL:" . $e->getMessage() . "\n", FILE_APPEND);
    }
}
// Pipeline test
file_put_contents($lf, "PIPE_STEP1_START\n", FILE_APPEND);
set_time_limit(10);
try {
    $k2 = new \ReflectionMethod($k, 'sendRequestThroughRouter');
    $k2->setAccessible(true);
    $resp = $k2->invoke($k, $req);
    file_put_contents($lf, "PIPE_OK=" . $resp->getStatusCode() . "\n", FILE_APPEND);
} catch (\Throwable $e) {
    file_put_contents($lf, "PIPE_ERR:" . $e->getMessage() . "\n", FILE_APPEND);
}
file_put_contents($lf, "DONE\n", FILE_APPEND);
