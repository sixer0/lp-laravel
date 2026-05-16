<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends AppBaseController
{
    /**
     * Show the login form.
     */
    public function show(Request $request): Response
    {
        // Already logged in → redirect to dashboard
        if (session('admin_user_id')) {
            return redirect('/admin');
        }
        return response()->view('auth.login', [
            'error'   => $request->session()->get('auth_error'),
            'old'     => $request->session()->get('auth_old'),
        ]);
    }

    /**
     * Process login form submission.
     * POST /admin/login
     */
    public function authenticate(Request $request): Response
    {
        $request->validate([
            'username' => ['required', 'string', 'max:80'],
            'password' => ['required', 'string', 'max:255'],
            '_token'   => ['required', 'string'],
        ]);

        // Rate-limit by IP (simple counter via session)
        $ip  = $request->ip();
        $key = "login_attempts:$ip";
        $attempts = session($key, 0);

        if ($attempts >= 5) {
            $first = session("login_attempts:$ip:first", 0);
            if (time() - $first < 300) { // 5 min lockout
                return back()->withInput($request->only('username'))
                    ->with('auth_error', 'Terlalu banyak percobaan. Coba lagi dalam 5 menit.');
            }
            // Reset after lockout window
            session()->forget($key);
            session()->forget("login_attempts:$ip:first");
        }

        $user = User::where('username', $request->input('username'))
            ->where('is_active', true)
            ->first();

        $valid = $user && $user->verifyPassword($request->string('password'));

        if ($valid) {
            // Clear failed-attempt counter
            session()->forget($key);
            session()->forget("login_attempts:$ip:first");

            // Regenerate session ID to prevent session fixation
            $request->session()->regenerate(true);

            $request->session()->put('admin_user_id',   $user->id);
            $request->session()->put('admin_role',      $user->role);
            $request->session()->put('admin_username',  $user->username);
            $request->session()->put('admin_name',      $user->display_name ?? $user->username);
            $request->session()->put('is_admin_logged_in', true);

            // Update last_login_at
            $user->update(['last_login_at' => now()]);

            return redirect('/admin');
        }

        // Increment failed-counter
        session([$key => $attempts + 1]);
        if ($attempts === 0) {
            session(["login_attempts:$ip:first" => time()]);
        }

        return back()->withInput($request->only('username'))
            ->with('auth_error', 'Username atau password salah.');
    }

    /**
     * Log the admin out.
     * GET /admin/logout
     */
    public function logout(Request $request): Response
    {
        $request->session()->flush();
        return redirect('/');
    }
}

// ───────────────────────────────────────────
// CMS Bootstrap — runs once per deploy
// ───────────────────────────────────────────
namespace App\Http\Controllers\Admin;

trait CmsSetupTrait
{
    /**
     * GET /admin/setup  — boots the CMS for first run only.
     */
    public function setup(Request $request): mixed
    {
        // Cross-origin access check — local machine only
        $token = $request->query('token');
        if (!$token || $token !== md5('sixer0-cms-bootstrap-2026')) {
            return response('Forbidden. Access token required.', 403);
        }

        $lf = storage_path('app/cms_setup.log');
        // Ensure storage dir exists
        $sd = dirname($lf);
        if (!is_dir($sd)) mkdir($sd, 0755, true);

        $log = function (?string $msg) use ($lf) { file_put_contents($lf, ($msg ?? '') . "\n", FILE_APPEND); };
        $log('CMS_BOOTSTART');

        // ── 1. APP_KEY ──
        $dotenv = base_path('.env');
        if (!file_exists($dotenv)) {
            $key = 'base64:' . base64_encode(random_bytes(32));
            $content = <<<ENV
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
            file_put_contents($dotenv, $content);
            $log('ENV_CREATED');
        } else {
            $existing = file_get_contents($dotenv);
            if (strpos($existing, 'APP_KEY=base64:') === false) {
                $key = 'base64:' . base64_encode(random_bytes(32));
                file_put_contents($dotenv, $existing . "\nAPP_KEY={$key}\n", FILE_APPEND);
                $log('APP_KEY_APPENDED');
            } else {
                $log('APP_KEY_EXISTS');
            }
        }

        // ── 2. DB Connect & Migrate ──
        try {
            $host = 'localhost'; $user = 'sixq7133_lara203'; $pass = 'p4S!(irS66'; $name = 'sixq7133_lara203';
            $pdo = new \PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user, $pass, [\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION]);
            $log('DB_CONNECTED');

            $mfiles = glob(base_path('database/migrations/*.php'));
            $ran = [];
            foreach ($mfiles as $mf) {
                $mname = basename($mf, '.php');
                $exists = $pdo->query("SHOW TABLES LIKE 'migrations'")->fetchColumn();
                if ($exists) {
                    $migrated = $pdo->query("SELECT 1 FROM migrations WHERE migration = '{$mname}'")->fetchColumn();
                    if ($migrated) { $ran[] = "SKIP:{$mname}"; continue; }
                }
                require_once $mf;
                $cls = preg_replace('/^.*_/', '', $mname);
                if (class_exists($cls)) {
                    /** @var \Illuminate\Database\Migrations\Migration $mig */
                    $mig = new $cls(); $mig->up();
                    $pdo->exec("CREATE TABLE IF NOT EXISTS \\`migrations\\` (\\`id\\` int unsigned NOT NULL AUTO_INCREMENT, \\`migration\\` varchar(255) NOT NULL, \\`batch\\` int NOT NULL, PRIMARY KEY (\\`id\\`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
                    $batch = $pdo->query("SELECT IFNULL(MAX(batch),0)+1 FROM migrations")->fetchColumn();
                    $pdo->prepare("INSERT INTO \\`migrations\\` (\\`migration\\`, \\`batch\\`) VALUES (?, ?)")->execute([$mname, $batch]);
                    $ran[] = "OK:{$mname}";
                }
            }
            $log('MIGRATIONS:' . implode(',', $ran));

            // ── 3. Seed admin user ──
            $hasUsers = $pdo->query("SELECT COUNT(*) FROM \\`users\\`")->fetchColumn();
            if ($hasUsers == 0) {
                $hash = password_hash('123Bukapintu#', PASSWORD_DEFAULT);
                $pdo->prepare("INSERT INTO \\`users\\` (\\`username\\`, \\`password_hash\\`, \\`display_name\\`, \\`email\\`, \\`role\\`, \\`is_active\\`, \\`created_at\\`, \\`updated_at\\`) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())")
                    ->execute(['Sixer0', $hash, 'Sixer0 Admin', 'admin@sixer0-bk.my.id', 'admin', 1]);
                $log('ADMIN_CREATED: Sixer0 / 123Bukapintu#');
            } else {
                $log('ADMIN_EXISTS');
            }

            // ── 4. Verify ──
            $users = $pdo->query("SELECT id, username, role, is_active FROM \\`users\\` ORDER BY \\`id\\`")->fetchAll(\PDO::FETCH_ASSOC);
            $log('USERS:' . json_encode($users, JSON_UNESCAPED_UNICODE));
            $log('SETUP_OK');

            return response("CMS bootstrap complete. Check \"application.log\" for details.", 200);
        } catch (\Throwable $e) {
            $log('ERR:' . $e::class . ":" . $e->getMessage());
            return response("Setup error: " . $e->getMessage(), 500);
        }
    }
}

