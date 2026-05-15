<?php
/**
 * langsung-jalankan-migrasi.php
 * 
 * Bypass semua cache, langsung migrate dari nol
 * 
 * Jalankan: php langsung-jalankan-migrasi.php
 */

chdir(__DIR__);

echo "=== Langsung Migrasi (bypass cache) ===\n\n";

// 1. Bersihkan OPcache
echo "[1/5] Clear OPcache...\n";
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "  ✓ OPcache reset\n";
} else {
    echo "  - OPcache tidak ada\n";
}

// 2. Hapus cache files
echo "[2/5] Hapus cache files...\n";
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/routes.php',
    'vendor/composer/autoload_classmap.php',
    'vendor/composer/installed.php',
];
foreach ($cacheFiles as $f) {
    if (file_exists($f)) {
        unlink($f);
        echo "  ✓ $f\n";
    }
}

// 3. Bersihkan storage cache
echo "[3/5] Bersihkan storage/...\n";
foreach (glob('storage/framework/cache/*') as $f) @unlink($f);
foreach (glob('storage/framework/views/*') as $f) @unlink($f);
foreach (glob('storage/framework/sessions/*') as $f) @unlink($f);
echo "  ✓ storage/ cache cleared\n";

// 4. Hapus tabel migrasi dan buat ulang
echo "[4/5] Reset database migrasi...\n";
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
use Illuminate\Support\Facades\DB;

try {
    DB::statement('DROP TABLE IF EXISTS migrations');
    DB::statement('DROP TABLE IF EXISTS contact_submissions');
    DB::statement('DROP TABLE IF EXISTS projects');
    echo "  ✓ Old tables dropped\n";
} catch (Throwable $e) {
    echo "  ✗ Error: " . $e->getMessage() . "\n";
}

// 5. Jalankan migrate dengan isolation
echo "\n[5/5] Running migrations...\n\n";
passthru('php artisan migrate --force');

echo "\n\n✅ Selesai! Cek dengan: php artisan migrate:status\n";
echo "Setelah itu: php artisan db:seed --class=ProjectSeeder --force\n";
