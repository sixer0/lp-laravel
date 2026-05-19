<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — Sixer0 CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold-500: #d4a843;
            --gold-600: #b8922e;
            --prussia-700: #162828;
            --prussia-600: #1e3a3a;
        }
        body { font-family: 'Inter', sans-serif; background: #0f172a; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-wrap { width: 100%; max-width: 420px; padding: 1.5rem; }
        .login-card {
            background: rgba(22,40,40,.55); border: 1px solid rgba(212,168,67,.2);
            border-radius: 20px; padding: 2.5rem; backdrop-filter: blur(16px);
            box-shadow: 0 24px 80px rgba(0,0,0,.45);
        }
        .login-logo { font-size: 1.6rem; font-weight: 800; color: var(--gold-500); margin-bottom: 2rem; text-align: center; }
        .login-logo i { font-size: 2rem; display: block; margin-bottom: .5rem; }
        .form-label { color: rgba(255,255,255,.75); font-weight: 600; font-size: .82rem; letter-spacing: .3px; }
        .form-control {
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.15);
            color: #fff; border-radius: 10px; padding: .75rem 1rem;
        }
        .form-control:focus {
            background: rgba(255,255,255,.1); border-color: var(--gold-500);
            box-shadow: 0 0 0 .18rem rgba(212,168,67,.2); color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,.28); }
        .btn-login {
            background: var(--gold-500); color: var(--prussia-700); border: none;
            border-radius: 10px; padding: .8rem; font-weight: 700; width: 100%;
            font-size: 1rem; letter-spacing: .3px; cursor: pointer; transition: .2s;
        }
        .btn-login:hover { background: var(--gold-600); transform: translateY(-1px); box-shadow: 0 8px 25px rgba(212,168,67,.3); }
        .login-error {
            background: rgba(185,28,28,.18); border: 1px solid rgba(185,28,28,.4);
            border-radius: 10px; padding: .75rem 1rem; color: #fca5a5; font-size: .85rem; margin-bottom: 1rem;
        }
        .login-help { text-align:center; margin-top:1.2rem; font-size:.8rem; color:rgba(255,255,255,.35); }
        .login-help a { color: var(--gold-500); text-decoration: none; }
        .login-help a:hover { color: var(--gold-600); text-decoration: underline; }
        @media (max-width: 480px) { .login-card { padding: 1.8rem; } }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-shield-lock"></i>
            <span>CMS Login</span>
        </div>

        <?php if($error ?? null): ?>
            <div class="login-error"><i class="bi bi-exclamation-triangle me-1"></i><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" novalidate>
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control"
                       value="<?php echo e(old('username', $old['username'] ?? '')); ?>"
                       placeholder="Masukkan username" required autofocus autocomplete="username">
            </div>
            <div class="mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="Masukkan password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
            </button>
        </form>

        <div class="login-help">
            <a href="/">&larr; Kembali ke Landing Page</a>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH /home/sixq7133/public_html/landing.sixer0-bk.my.id/resources/views/auth/login.blade.php ENDPATH**/ ?>