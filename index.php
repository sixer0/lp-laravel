<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Tell Laravel that public/ is actually the root here
// (needed to override helper functions like public_path())
if (method_exists($app, 'bind')) {
    $app->bind('path.public', fn() => __DIR__);
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
