<?php
/**
 * Utility Script: Check Database Connection
 * 
 * Verifies database connection and presence of essential tables.
 * Uses .env file for credentials.
 */

require __DIR__ . '/../vendor/autoload.php';

// Load .env
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

echo "Checking Database Connection...\n";
echo "----------------------------------------------\n";

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_DATABASE'] ?? '';
$user = $_ENV['DB_USERNAME'] ?? '';
$pass = $_ENV['DB_PASSWORD'] ?? '';
$port = $_ENV['DB_PORT'] ?? '3306';

if (empty($dbname) || empty($user)) {
    echo "❌ ERROR: Database configuration missing in .env (DB_DATABASE or DB_USERNAME).\n";
    exit(1);
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "[Connection] Status: ✅ Connected to $dbname at $host:$port\n";

    // Check for essential tables
    $essentialTables = ['users', 'migrations', 'sessions'];
    echo "[Tables] Checking essential tables...\n";
    
    foreach ($essentialTables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->fetch()) {
            echo "  - $table: ✅ Found\n";
        } else {
            echo "  - $table: ❌ MISSING\n";
        }
    }
    
    echo "----------------------------------------------\n";
    echo "✅ Database check completed successfully.\n";
    exit(0);

} catch (PDOException $e) {
    echo "❌ DATABASE CONNECTION FAILED!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "----------------------------------------------\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ AN UNEXPECTED ERROR OCCURRED!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "----------------------------------------------\n";
    exit(1);
}
