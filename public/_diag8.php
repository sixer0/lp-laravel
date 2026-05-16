<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/bootstrap/app.php";

$lf = __DIR__."/_diag8_tr.txt";
file_put_contents($lf, "DIAG8:START\n");

$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);

file_put_contents($lf, "KERNEL_CLASS=" . get_class($k) . "\n", FILE_APPEND);
file_put_contents($lf, "MW_GROUPS=" . implode(",", array_keys($k->getMiddlewareGroups())) . "\n", FILE_APPEND);

// 1) Can we call handle() and get a response?
$req = \Illuminate\Http\Request::create("/", "GET");
try {
    $resp = @$k->handle($req);
    file_put_contents($lf, "HANDLE_OK=" . $resp->getStatusCode() . "\n", FILE_APPEND);
    // Check if handler rendered the exception
    $body = $resp->getContent();
    if ($body && strlen($body) < 500 && stripos($body, "BindingResolutionException") !== false) {
        file_put_contents($lf, "HANDLE_BODY: " . substr(strip_tags($body), 0, 200) . "\n", FILE_APPEND);
    }
} catch (\Throwable $e) {
    file_put_contents($lf, "HANDLE_EXCEPT:" . $e->getMessage() . "\n", FILE_APPEND);
}

file_put_contents($lf, "DIAG8:DONE\n", FILE_APPEND);
