<?php
/**
 * One-Click Laravel Deploy Script
 * Access via browser: https://devlp.sixer0-bk.my.id/deploy.php
 * 
 * ⚠️ DELETE THIS FILE AFTER DEPLOYMENT!
 */

$commands = [
    'title' => 'Deploying Laravel 11.51...',
    'steps' => [
        'cd /public_html/devlp/',
        'php -v',
        'which php',
        'php artisan --version',
        'php composer.phar install --no-dev --optimize-autoloader --no-interaction || composer install --no-dev --optimize-autoloader --no-interaction',
        'php artisan key:generate --force',
        'php artisan migrate --force',
        'php artisan db:seed --class=ProjectSeeder --force',
        'php artisan view:clear',
        'php artisan cache:clear',
        'php artisan route:list',
    ],
];

function run_cmd($cmd, $cwd = '/public_html/devlp/') {
    $escaped = escapeshellcmd($cmd);
    $full = "cd " . escapeshellarg($cwd) . " 2>/dev/null && $escaped 2>&1";
    $output = [];
    $return = 0;
    exec($full, $output, $return);
    return ['output' => $output, 'code' => $return];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Laravel Deploy | devlp.sixer0-bk.my.id</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; background: #0f172a; color: #e2e8f0; padding: 2rem; }
        .header { background: linear-gradient(135deg, #2563eb, #6366f1); color: white; padding: 1.5rem 2rem; border-radius: 12px; margin-bottom: 2rem; }
        .header h1 { font-size: 1.5rem; }
        .header p { opacity: 0.85; font-size: 0.8rem; }
        .card { background: #1e293b; border-radius: 8px; margin-bottom: 1rem; overflow: hidden; }
        .card-header { background: #334155; padding: 0.75rem 1rem; font-weight: bold; font-size: 0.8rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .card-body { padding: 1rem; }
        .cmd { color: #86efac; font-size: 0.9rem; margin-bottom: 0.5rem; }
        .output { background: #0f172a; padding: 0.75rem; border-radius: 6px; font-size: 0.8rem; color: #e2e8f0; white-space: pre-wrap; max-height: 600px; overflow-y: auto; }
        .success { color: #86efac; }
        .error { color: #f87171; }
        .step { color: #60a5fa; font-weight: bold; }
        .badge { display: inline-block; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.7rem; font-weight: bold; margin-left: 0.5rem; }
        .badge-ok { background: #166534; color: #86efac; }
        .badge-fail { background: #991b1b; color: #fca5a5; }
        .badge-progress { background: #854d0e; color: #fde047; }
        .actions { margin: 1.5rem 0; }
        button { background: linear-gradient(135deg, #2563eb, #6366f1); color: white; border: none; padding: 0.75rem 2rem; border-radius: 8px; font-family: inherit; font-size: 0.9rem; cursor: pointer; }
        button:hover { opacity: 0.9; }
        button:disabled { background: #475569; cursor: not-allowed; }
        .warning { background: #451a03; border: 1px solid #92400e; color: #fde68a; padding: 1rem; border-radius: 8px; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 Laravel 11.51 — One-Click Deploy</h1>
        <p>deploy.php | devlp.sixer0-bk.my.id | Server: cPanel (FTP)</p>
    </div>

    <div class="card">
        <div class="card-header">Pre-Flight</div>
        <div class="card-body">
            <p class="cmd"> cd /public_html/devlp/</p>
            <?php $r = run_cmd('pwd'); echo '<div class="output">' . htmlspecialchars(implode("\n", $r['output'])) . '</div>'; ?>
        </div>
    </div>

    <div class="actions">
        <button onclick="runDeploy()" id="deployBtn">▶ Start Deployment</button>
    </div>

    <div id="results"></div>

    <div class="warning">
        ⚠️ <strong>IMPORTANT:</strong> After deployment completes, delete this file (deploy.php) from the server!<br>
        It exposes server paths and could be a security risk if left accessible.
    </div>

    <script>
    const steps = [
        { cmd: 'php artisan --version', label: 'Check Laravel' },
        { cmd: 'php composer.phar install --no-dev --optimize-autoloader --no-interaction || composer install --no-dev --optimize-autoloader --no-interaction', label: 'Composer Install' },
        { cmd: 'php artisan key:generate --force', label: 'Generate App Key' },
        { cmd: 'php artisan migrate --force', label: 'Run Migrations' },
        { cmd: 'php artisan db:seed --class=ProjectSeeder --force', label: 'Seed Projects' },
        { cmd: 'php artisan view:clear && php artisan cache:clear', label: 'Clear Cache' },
        { cmd: 'php artisan route:list', label: 'Route List' },
    ];

    async function runDeploy() {
        const btn = document.getElementById('deployBtn');
        btn.disabled = true;
        btn.textContent = '⏳ Running...';

        for (let i = 0; i < steps.length; i++) {
            const step = steps[i];
            const resultId = 'step-' + i;
            
            // Render step header
            let html = `<div class="card"><div class="card-header">
                <span class="step">Step ${i+1}/${steps.length}</span> ${step.label}
                <span class="badge badge-progress" id="badge-${i}">RUNNING</span>
                </div><div class="card-body"><p class="cmd"> $ ${step.cmd}</p><div class="output" id="${resultId}">Running...</div></div></div>`;
            document.getElementById('results').insertAdjacentHTML('beforeend', html);

            // Execute via AJAX
            try {
                const resp = await fetch('deploy-api.php?cmd=' + encodeURIComponent(step.cmd.replace(/'/g, "\\'")), { signal: AbortSignal.timeout(120000) });
                const data = await resp.json();
                
                const outputEl = document.getElementById(resultId);
                let outputText = data.output.join("\n");
                
                // Colorize
                if (data.code === 0) {
                    outputText = '<span class="success">' + outputText.replace(/\n/g, '&#10;') + '</span>';
                    document.getElementById('badge-' + i).className = 'badge badge-ok';
                    document.getElementById('badge-' + i).textContent = 'OK';
                } else {
                    outputText = '<span class="error">' + outputText.replace(/\n/g, '&#10;') + '</span>';
                    document.getElementById('badge-' + i).className = 'badge badge-fail';
                    document.getElementById('badge-' + i).textContent = 'FAIL (' + data.code + ')';
                }
                outputEl.innerHTML = outputText;
            } catch (e) {
                document.getElementById(resultId).innerHTML = '<span class="error">Error: ' + e.message + '</span>';
                document.getElementById('badge-' + i).className = 'badge badge-fail';
                document.getElementById('badge-' + i).textContent = 'FAIL';
            }
        }

        btn.disabled = false;
        btn.textContent = '↻ Run Again';
    }
    </script>
</body>
</html>
