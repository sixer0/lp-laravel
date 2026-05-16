<?php
/**
 * _migrate.php  —  Create projects + contact_submissions tables on MySQL
 * Run once by visiting https://landing.sixer0-bk.my.id/_migrate.php
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
$lf = __DIR__ . '/_migrate_tr.txt';
file_put_contents($lf, "MIGRATE_START\n");

$creds = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'sixq7133_lara203',
    'DB_USERNAME' => 'sixq7133_lara203',
    'DB_PASSWORD' => 'p4S!(irS66',
];

try {
    $pdo = new PDO(
        "mysql:host={$creds['DB_HOST']};dbname={$creds['DB_DATABASE']};charset=utf8mb4",
        $creds['DB_USERNAME'],
        $creds['DB_PASSWORD'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    file_put_contents($lf, "DB_CONNECTED\n", FILE_APPEND);

    // ---- projects table ----
    $exists_projects = $pdo->query("SHOW TABLES LIKE 'projects'")->fetchColumn();
    if ($exists_projects) {
        file_put_contents($lf, "projects: EXISTS\n", FILE_APPEND);
    } else {
        $pdo->exec("
            CREATE TABLE `projects` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `slug` VARCHAR(255) NOT NULL UNIQUE,
                `description` TEXT NULL,
                `image` VARCHAR(255) NULL,
                `image_alt` VARCHAR(255) NULL,
                `hours_tag` VARCHAR(50) NULL,
                `price_tag` VARCHAR(50) NULL,
                `project_url` VARCHAR(255) NULL,
                `order` INT DEFAULT 0 NOT NULL,
                `is_active` TINYINT(1) DEFAULT 1 NOT NULL,
                `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `proj_active_order_idx` (`is_active`, `order`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        file_put_contents($lf, "projects: CREATED\n", FILE_APPEND);
    }

    // ---- contact_submissions table ----
    $exists_contact = $pdo->query("SHOW TABLES LIKE 'contact_submissions'")->fetchColumn();
    if ($exists_contact) {
        file_put_contents($lf, "contact_submissions: EXISTS\n", FILE_APPEND);
    } else {
        $pdo->exec("
            CREATE TABLE `contact_submissions` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `company` VARCHAR(255) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `phone` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `message` TEXT NOT NULL,
                `ip` VARCHAR(45) NULL,
                `user_agent` TEXT NULL,
                `user_agent_short` VARCHAR(255) NULL,
                `status` ENUM('new','read','responded','archived') DEFAULT 'new' NOT NULL,
                `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `contact_status_created_idx` (`status`, `created_at`),
                INDEX `contact_email_idx` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        file_put_contents($lf, "contact_submissions: CREATED\n", FILE_APPEND);
    }

    // ---- seed 6 sample projects ----
    $cnt = $pdo->query("SELECT COUNT(*) FROM `projects`")->fetchColumn();
    if ((int)$cnt === 0) {
        $seedSql = <<<'SEED'
INSERT INTO `projects` (`name`, `slug`, `description`, `image`, `image_alt`, `hours_tag`, `price_tag`, `project_url`, `order`, `is_active`, `created_at`) VALUES
('Solusi Siber untuk Industri','solusi-siber-industri','Platform keamanan siber end-to-end untuk sektor industri dan militer.','https://sixer0-bk.my.id/assets/project1.jpg','Desain sistem keamanan siber','48 Jam','$12,000','https://www.sixer0.org/security-solutions/',1,1,'2026-05-15 00:00:00'),
('Konsultasi Strategis IT','konsultasi-strategis-it','Layanan konsultasi strategis untuk transformasi digital organisasi.','https://sixer0-bk.my.id/assets/project2.jpg','Konsultasi IT strategis','72 Jam','$8,500','https://www.sixer0.org/strategy/',2,1,'2026-05-15 00:00:00'),
('Audit kepatuhan','audit-kepatuhan','Audit kepatuhan ISO 27001 dan penilaian risiko siber komprehensif.','https://sixer0-bk.my.id/assets/project3.jpg','Audit kepatuhan ISO 27001','40 Jam','$6,000','https://www.sixer0.org/compliance/',3,1,'2026-05-15 00:00:00'),
('Pelatihan Keamanan Sumber Daya Manusia','pelatihan-keamanan-sdm','Program pelatihan kesadaran keamanan siber untuk seluruh organisasi.','https://sixer0-bk.my.id/assets/project4.jpg','Program Pelatihan Keamanan Sumber Daya Manusia','24 Jam','$3,500','https://www.sixer0.org/training-sdm/',4,1,'2026-05-15 00:00:00'),
('Identifikasi Poin Kegagalan','identifikasi-poin-kegagalan','Metodologi pinball untuk mengidentifikasi poin kegagalan secara proaktif.','https://sixer0-bk.my.id/assets/project5.jpg','Metodologi identifikasi poin kegagalan','16 Jam','$2,000','https://www.sixer0.org/failure-points/',5,1,'2026-05-15 00:00:00'),
('Cyber Situational Awareness','cyber-situational-awareness','Membangun kesadaran situasional siber untuk elemen pertahanan dan keamanan.','https://sixer0-bk.my.id/assets/project6.jpg','Kesadaran situasional siber','32 Jam','$4,500','https://www.sixer0.org/csa/',6,1,'2026-05-15 00:00:00');
SEED;
        $pdo->exec($seedSql);
        file_put_contents($lf, "PROJECTS_SEEDED:6\n", FILE_APPEND);
    } else {
        file_put_contents($lf, "PROJECTS_EXIST:" . $cnt . "\n", FILE_APPEND);
    }

    file_put_contents($lf, "MIGRATE_OK\n", FILE_APPEND);

} catch (\Throwable $e) {
    file_put_contents($lf, "MIGRATE_ERR:" . $e::class . ":" . $e->getMessage() . "\n", FILE_APPEND);
    file_put_contents($lf, $e->getTraceAsString() . "\n", FILE_APPEND);
}
