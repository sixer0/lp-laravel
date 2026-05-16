<?php
/**
 * CMS Bootstrap — run once per deploy.
 *
 * 1. Ensures APP_KEY exists (generates if missing)
 * 2. Creates .env if absent
 * 3. Runs all pending migrations (users table, etc.)
 * 4. Seeds the default admin account
 *
 * Visit:  GET /admin/setup
 * Delete after first successful run.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__ . '/_cms_setup_tr.txt';
file_put_contents($lf, "CMS_BOOTSTART\n");

$base = dirname(__DIR__);
$envFile = $base . '/.env';

// ── APP_KEY ──
if (!file_exists($envFile)) {
    $key = 'base64:' . base64_encode(random_bytes(32));
    $envContent = <<<ENV
APP_NAME="Sixer0"
APP_ENV=production
APP_KEY={$key}
APP_DEBUG=false
APP_URL=https://landing.sixer0-bk.my.id

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sixq7133_lara203
DB_USERNAME=sixq7133_lara203
DB_PASSWORD=p4S!(irS66

SESSION_DRIVER=file
SESSION_LIFETIME=120
ENV;
    file_put_contents($envFile, $envContent);
    file_put_contents($lf, "ENV_CREATED\n", FILE_APPEND);
} else {
    $env = file_get_contents($envFile);
    if (strpos($env, 'APP_KEY=') === false || strpos($env, 'APP_KEY=base64:') === false) {
        $key = 'base64:' . base64_encode(random_bytes(32));
        file_put_contents($envFile, $env . "\nAPP_KEY=base64:" . $key . "\n", FILE_APPEND);
        file_put_contents($lf, "APP_KEY_APPENDED\n", FILE_APPEND);
    } else {
        file_put_contents($lf, "APP_KEY_EXISTS\n", FILE_APPEND);
    }
}

// ── DB Connection ──
$host = 'localhost';
$user = 'sixq7133_lara203';
$pass = 'p4S!(irS66';
$name = 'sixq7133_lara203';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$name};charset=utf8mb4",
        $user, $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
    file_put_contents($lf, "DB_CONNECTED\n", FILE_APPEND);
} catch (Throwable $e) {
    file_put_contents($lf, "DB_ERR:" . $e->getMessage() . "\n", FILE_APPEND);
    echo "DB Error: " . $e->getMessage();
    exit(1);
}

// ── Run migrations ──
$migrationPath = dirname(__DIR__) . '/database/migrations';
$files = glob($migrationPath . '/*.php');
$ran  = [];
foreach ($files as $mfile) {
    $name   = basename($mfile, '.php');
    $exists = $pdo->query("SHOW TABLES LIKE 'migrations'")->fetchColumn();
    if ($exists) {
        $migrated = $pdo->query("SELECT 1 FROM migrations WHERE migration = '{$name}'")->fetchColumn();
        if ($migrated) {
            $ran[] = "SKIP:{$name}";
            continue;
        }
    }

    require_once $mfile;
    $migration = new (preg_replace('/^.*_/', '', $name));
    if ($migration instanceof Migration) {
        $migration->up();
        $pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` ( `id` int unsigned NOT NULL AUTO_INCREMENT, `migration` varchar(255) NOT NULL, `batch` int NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        $pdo->prepare("INSERT INTO `migrations` (`migration`, `batch`) VALUES (?, (SELECT IFNULL(MAX(batch),0)+1 FROM migrations))")->execute([$name]);
        $ran[] = "OK:{$name}";
    }
}
file_put_contents($lf, "MIGRATIONS:" . implode(',', $ran) . "\n", FILE_APPEND);

// ── Seed / verify admin user ──
$hash = password_hash('123Bukapintu#', PASSWORD_DEFAULT);
$hasUsers = $pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
if ($hasUsers == 0) {
    $pdo->prepare("INSERT INTO `users` (`username`, `password_hash`, `display_name`, `email`, `role`, `is_active`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())")
        ->execute(['Sixer0', $hash, 'Sixer0 Admin', 'admin@sixer0-bk.my.id', 'admin', 1]);
    file_put_contents($lf, "ADMIN_CREATED\n", FILE_APPEND);
} else {
    file_put_contents($lf, "ADMIN_EXISTS\n", FILE_APPEND);
}

// ── Verify ──
$users = $pdo->query("SELECT id, username, role, is_active FROM `users` ORDER BY `id`")->fetchAll(PDO::FETCH_ASSOC);
file_put_contents($lf, "USERS:" . json_encode($users, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);

// Index page check
$indexCount = $pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='{$name}' AND TABLE_NAME = 'users'")->fetchColumn();
file_put_contents($lf, "USERS_TABLE_EXISTS:" . ($indexCount ? 'YES' : 'NO') . "\n", FILE_APPEND);

echo "CMS setup complete. Trace in _cms_setup_tr.txt\n";
