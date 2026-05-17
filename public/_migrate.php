<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
$base = dirname(dirname(__DIR__));
require $base . '/vendor/autoload.php';
\Dotenv\Dotenv::createImmutable($base)->safeLoad();
$app = \Illuminate\Foundation\Application::configure(basePath: $base)
    ->withRouting(web: $base.'/routes/web.php', commands: $base.'/routes/console.php', health: '/up')
    ->withMiddleware(function ($m) {
        $m->web(append: [App\Http\Middleware\TrustProxies::class]);
    })
    ->create();

$app->singleton(\Illuminate\Contracts\Debug\ExceptionHandler::class, App\Exceptions\AppExceptionHandler::class);
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

echo "MIGRATING...\n";
try {
    $kernel->call('migrate', ['--force' => true]);
    echo "MIGRATE: OK\n";
} catch(Throwable $e) {
    echo "MIGRATE_ERR: " . $e->getMessage() . "\n";
}

echo "SEEDING ProjectSeeder...\n";
try {
    $kernel->call('db:seed', ['--class' => 'ProjectSeeder', '--force' => true]);
    echo "SEED: OK\n";
} catch(Throwable $e) {
    echo "SEED_ERR: " . $e->getMessage() . "\n";
}
