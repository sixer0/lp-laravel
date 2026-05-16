<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/app.php';
$lf = __DIR__.'/_errapel_tr.txt';

$app = \Illuminate\Container\Container::getInstance();
$k = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$ref = new \ReflectionClass($k);

// Read protected $middleware
$mwp = $ref->getProperty('middleware'); $mwp->setAccessible(true);
$mw = $mwp->getValue($k);
file_put_contents($lf, "MW_COUNT:" . count($mw) . "\n");
$mw2 = $mwp->getValue($k);
file_put_contents($lf, "BEFORE:" . count($mw2) . "\n", FILE_APPEND);
$k->bootstrap();
$mw2 = $mwp->getValue($k);
file_put_contents($lf, "AFTER_BOOT:" . count($mw2) . "\n", FILE_APPEND);

// Invoke handle
$req = \Illuminate\Http\Request::capture();
$resp = $k->handle($req);
file_put_contents($lf, "STATUS:" . $resp->getStatusCode() . "\n", FILE_APPEND);
file_put_contents($lf, "CT:" . $resp->headers->get('Content-Type') . "\n", FILE_APPEND);
$content = $resp->getContent();
file_put_contents($lf, "IS_STRING:" . (is_string($content)?"Y":"N") . "\n", FILE_APPEND);
file_put_contents($lf, "CONTENT_LEN:" . strlen($content) . "\n", FILE_APPEND);

// Look for specific markers in content
$checks = ['BindingResolution','Target class','web','Language','lang=','DOCTYPE','Laravel','SQLSTATE','Unknown column','Table doesn'];
foreach ($checks as $marker) {
    $found = stripos($content, $marker);
    file_put_contents($lf, "MARKER[" . $marker . "]:" . ($found !== false ? "YES@$found" : "NO") . "\n", FILE_APPEND);
}
file_put_contents($lf, "CONTENT_SNIP:" . substr($content, 0, 500) . "\n", FILE_APPEND);
file_put_contents($lf, "DONE\n", FILE_APPEND);
