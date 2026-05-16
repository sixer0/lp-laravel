<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__ . '/_dbclean2_tr.txt';

$host = 'localhost';
$port = 3306;
$user = 'sixq7133_lara203';
$pass = 'p4S!(irS66';
$name = 'sixq7133_lara203';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$name};charset=utf8mb4",
        $user, $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Update project names that carry defense/military connotations
    $pdo->prepare("UPDATE `projects` SET `name`='Dashboard Situasi Operasional' WHERE `id`=6")->execute();

    // Final safety scan: check EVERY field in projects
    $bad_count = 0;
    $rows = $pdo->query('SELECT * FROM `projects`')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        $all = json_encode($r, JSON_UNESCAPED_UNICODE);
        if (preg_match('/militer|pertahanan|Saudi|Riyadh|Arab Saudi|OIMS|Organisasi Industri Militer|pertahanan nasional/i', $all)) {
            $bad_count++;
            file_put_contents($lf, "BAD_ROW:{$r['id']}\n", FILE_APPEND);
        }
    }
    file_put_contents($lf, "FINAL_BAD_ROWS:$bad_count\n", FILE_APPEND);

    // Show final state
    file_put_contents($lf, "FINAL_PROJECTS:\n", FILE_APPEND);
    foreach ($rows as $r) {
        file_put_contents($lf, "  [{$r['id']}] {$r['name']}\n", FILE_APPEND);
        file_put_contents($lf, "       desc: {$r['description']}\n", FILE_APPEND);
    }

} catch (Throwable $e) {
    file_put_contents($lf, "ERR:" . $e::class . ":" . $e->getMessage() . "\n");
}
