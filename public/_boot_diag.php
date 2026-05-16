<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$lf = __DIR__.'/_boot_diag_tr.txt';

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';

file_put_contents($lf, "LINE:" . __LINE__ . " AFTR_REQUIRE\n");

$app = \Illuminate\Container\Container::getInstance();
file_put_contents($lf, "LINE:" . __LINE__ . " INST:" . ($app?"OK":"NULL") . "\n", FILE_APPEND);

$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);
file_put_contents($lf, "LINE:" . __LINE__ . " KERNEL:" . get_class($k) . "\n", FILE_APPEND);

// Check if middleware is defined
$ref = new \ReflectionClass($k);
$mwp = $ref->getProperty('middleware'); $mwp->setAccessible(true);
$mw = $mwp->getValue($k);
file_put_contents($lf, "LINE:" . __LINE__ . " KERNEL_MW_COUNT:" . count($mw) . "\n", FILE_APPEND);

// Call bootstrap() first
set_time_limit(30);
file_put_contents($lf, "LINE:" . __LINE__ . " BEFORE_BOOTSTRAP\n", FILE_APPEND);
$k->bootstrap();
file_put_contents($lf, "LINE:" . __LINE__ . " BOOTSTRAP_OK\n", FILE_APPEND);

// Re-read middleware (bootstrap might change it)
$mw2 = $mwp->getValue($k);
file_put_contents($lf, "LINE:" . __LINE__ . " MW_AFTER_BOOT:" . count($mw2) . "=" . implode(",",array_slice($mw2,0,3)) . "\n", FILE_APPEND);

// Now try just the Pipeline EXCEPT dispatchToRouter - pure middleware stepping
function stepper($passable, $pipes) {
    $lf2 = __DIR__.'/_boot_diag_tr.txt';
    file_put_contents($lf2, "STEP_COUNT:" . count($pipes) . "\n", FILE_APPEND);
    foreach ($pipes as $i => $pipe) {
        file_put_contents($lf2, "STEP{$i}:START:" . $pipe . "\n", FILE_APPEND);
        try {
            if (!is_string($pipe)) { file_put_contents($lf2, "STEP{$i}:SKIP\n", FILE_APPEND); continue; }
            if (!class_exists($pipe)) { file_put_contents($lf2, "STEP{$i}:CLASS_MISSING\n", FILE_APPEND); continue; }
            // Resolve via container to get a proper instance
            $instance = \Illuminate\Container\Container::getInstance()->make($pipe);
            file_put_contents($lf2, "STEP{$i}:RESOLVED:" . get_class($instance) . "\n", FILE_APPEND);
            if (!method_exists($instance, 'handle')) { file_put_contents($lf2, "STEP{$i}:NO_HANDLE\n", FILE_APPEND); continue; }
            // Call handle with a throwaway closure
            $resp = $instance->handle($passable, fn($r) => $r);
            file_put_contents($lf2, "STEP{$i}:RESPONSE_TYPE:" . get_class($resp) . "\n", FILE_APPEND);
            $passable = $resp;
        } catch (\Throwable $e) {
            file_put_contents($lf2, "STEP{$i}:ERR:" . $e::class . ":" . substr($e->getMessage(),0,100) . "\n", FILE_APPEND);
        }
    }
    file_put_contents($lf2, "STEP:END\n", FILE_APPEND);
    return $passable;
}

$req = \Illuminate\Http\Request::create("/","GET");
file_put_contents($lf, "LINE:" . __LINE__ . " STEP_START\n", FILE_APPEND);
$result = stepper($req, $mw);

if ($result instanceof \Illuminate\Http\Response) {
    file_put_contents($lf, "FINAL_RESPONSE:" . $result->getStatusCode() . ":" . substr($result->getContent(),0,100) . "\n", FILE_APPEND);
} else {
    file_put_contents($lf, "FINAL_TYPE:" . get_class($result) . "\n", FILE_APPEND);
}

file_put_contents($lf, "LINE:" . __LINE() . " DONE\n", FILE_APPEND);
