<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__ . '/_dbclean_tr.txt';

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

    $updates = [
        1 => 'Solusi keamanan siber end-to-end untuk sektor industri dan bisnis korporat.',
        2 => 'Layanan konsultasi strategis untuk transformasi digital organisasi bisnis.',
        3 => 'Audit kepatuhan ISO 27001 dan penilaian risiko siber komprehensif.',
        4 => 'Program pelatihan kesadaran keamanan siber untuk seluruh organisasi.',
        5 => 'Metodologi sistematis untuk mengidentifikasi poin kegagalan secara proaktif.',
        6 => 'Solusi dashboard dan monitoring situasional untuk operasional bisnis dan layanan pelanggan.',
    ];

    foreach ($updates as $id => $desc) {
        $stmt = $pdo->prepare('UPDATE `projects` SET `description` = :d WHERE `id` = :id');
        $stmt->execute([':d' => $desc, ':id' => $id]);
    }

    $bad = $pdo->query("SELECT COUNT(*) FROM `projects` WHERE `description` LIKE '%militer%' OR `description` LIKE '%pertahanan%' OR `name` LIKE '%militer%' OR `name` LIKE '%pertahanan%' OR `name` LIKE '%Saudi%' OR `name` LIKE '%pertahanan nasional%'")->fetchColumn();

    file_put_contents($lf, "UPDATED:6 rows, REMAINING_BAD:$bad\n");

    // Show all projects
    $rows = $pdo->query('SELECT id, name, description FROM `projects` ORDER BY `id`')->fetchAll(PDO::FETCH_ASSOC);
    file_put_contents($lf, "PROJECTS:\n", FILE_APPEND);
    foreach ($rows as $r) {
        file_put_contents($lf, "  [{$r['id']}] {$r['name']}: {$r['description']}\n", FILE_APPEND);
    }

} catch (Throwable $e) {
    file_put_contents($lf, "ERR:" . $e::class . ":" . $e->getMessage() . "\n");
}
