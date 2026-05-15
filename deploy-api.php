<?php
/**
 * deploy-api.php — AJAX endpoint for deploy.php
 * Called by JavaScript to execute shell commands one at a time.
 */
$cmd = $_GET['cmd'] ?? '';

// Safety: only allow artisan + composer commands
$allowed = ['php artisan', 'php composer.phar', 'composer', 'php -v', 'pwd', 'ls -la'];
$safe = false;
foreach ($allowed as $allowedCmd) {
    if (str_starts_with($cmd, $allowedCmd)) {
        $safe = true;
        break;
    }
}

if (!$safe || strlen($cmd) > 300) {
    http_response_code(403);
    echo json_encode(['error' => 'Command not allowed', 'cmd' => $cmd]);
    exit;
}

exec("cd /public_html/devlp/ && " . escapeshellcmd($cmd) . " 2>&1", $output, $code);
header('Content-Type: application/json');
echo json_encode(['cmd' => $cmd, 'code' => $code, 'output' => $output]);
