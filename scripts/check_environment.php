<?php
/**
 * Utility Script: Check Environment
 * 
 * Verifies PHP version, Laravel version, and basic environment setup.
 */

require __DIR__ . '/../vendor/autoload.php';

echo "Checking System Environment...\n";
echo "----------------------------------------------\n";

// 1. Check PHP Version
$phpVersion = PHP_VERSION;
echo "[PHP] Version: $phpVersion ";
if (version_compare($phpVersion, '8.2.0', '>=')) {
    echo "✅ OK\n";
} else {
    echo "❌ FAILED (Minimum 8.2.0 required)\n";
}

// 2. Check Laravel Version
try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    $laravelVersion = $app::VERSION;
    echo "[Laravel] Version: $laravelVersion ";
    if (version_compare($laravelVersion, '11.0.0', '>=')) {
        echo "✅ OK\n";
    } else {
        echo "❌ FAILED (Minimum 11.0.0 required)\n";
    }
} catch (\Exception $e) {
    echo "[Laravel] FAILED: " . $e->getMessage() . "\n";
}

// 3. Check .env file
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    echo "[.env] File: ✅ Found\n";
} else {
    echo "[.env] File: ❌ NOT Found\n";
}

// 4. Check Composer
$composerVersion = shell_exec('composer --version');
if ($composerVersion) {
    echo "[Composer] Status: ✅ Found (" . trim($composerVersion) . ")\n";
} else {
    echo "[Composer] Status: ❌ NOT Found\n";
}

echo "----------------------------------------------\n";
