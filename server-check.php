<?php
/**
 * Server-side syntax check + info
 * Access: https://devlp.sixer0-bk.my.id/server-check.php
 * DELETE after use!
 */
header('Content-Type: text/plain');
echo "=== Server Info ===\n";
echo "PHP: " . PHP_VERSION . "\n\n";

// Check required extensions
echo "=== PHP Extensions ===\n";
$required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext);
    echo ($loaded ? "✓" : "✗") . " $ext\n";
}

echo "\n=== File Existence Check ===\n";
$files = [
    'bootstrap/app.php',
    'config/app.php',
    'config/database.php',
    'routes/web.php',
    'app/Http/Controllers/HomeController.php',
    'app/Http/Controllers/ContactController.php',
    'app/Models/Project.php',
    'app/Models/ContactSubmission.php',
    'database/migrations/2026_05_15_create_contact_submissions_table.php',
    'database/seeders/ProjectSeeder.php',
    'resources/views/layouts/guest.blade.php',
    '.env',
    'composer.json',
];
foreach ($files as $f) {
    echo (file_exists($f) ? "✓" : "✗") . " $f\n";
}

echo "\n=== Laravel Bootstrap Syntax Check ===\n";
try {
    require_once 'bootstrap/app.php';
    echo "✓ bootstrap/app.php loaded successfully\n";
} catch (\Throwable $e) {
    echo "✗ bootstrap/app.php error: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";
