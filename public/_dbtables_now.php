<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__ . '/_dbtables_now_tr.txt';

$host = 'localhost';
$port = 3306;
$user = 'sixq7133_lara203';
$pass = 'p4S!(irS66';
$name = 'sixq7133_lara203';

try {
    $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    file_put_contents($lf, "TABLES:" . json_encode($tables) . "\n");
    foreach ($tables as $tbl) {
        $cnt = $pdo->query('SELECT COUNT(*) FROM `' . $tbl . '`')->fetchColumn();
        file_put_contents($lf, "  " . $tbl . "=" . $cnt . "\n", FILE_APPEND);
    }
    $cols = $pdo->query('SHOW COLUMNS FROM `projects`')->fetchAll(PDO::FETCH_ASSOC);
    file_put_contents($lf, "COLS:" . json_encode(array_column($cols, 'Field')) . "\n", FILE_APPEND);
} catch (Throwable $e) {
    file_put_contents($lf, "ERR:" . $e::class . ":" . $e->getMessage() . "\n");
}
