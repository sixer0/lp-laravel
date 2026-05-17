<?php
$pdo = new PDO('mysql:host=localhost;dbname=sixq7133_lara203',
    'sixq7133_lara203', 'p4S!(irS66',
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$cols = $pdo->query("SHOW COLUMNS FROM `users`")->fetchAll(PDO::FETCH_COLUMN);
$cnt  = (int)$pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
$out  = "COLS:" . json_encode($cols) . "\nCOUNT=$cnt\n";
file_put_contents(__DIR__ . '/_show_users_cols_tr.txt', $out);
