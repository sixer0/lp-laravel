<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title ?? 'CMS' . ' — Sixer0' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold-500: #d4a843; --gold-600: #b8922e; --prussia-700: #162828;
            --prussia-600: #1e3a3a; --prussia-500: #295a5a; --prussia-400: #3d7a7a;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; margin: 0; }
        /* Sidebar */
        .admin-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 250px;
            background: linear-gradient(180deg, var(--prussia-700) 0%, var(--prussia-600) 100%);
            z-index: 100; display: flex; flex-direction: column;
            transition: transform .3s ease;
        }
        .sidebar-brand {
            padding: 1.4rem 1.2rem; border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand a { color: var(--gold-500); font-weight: 800; font-size: 1.35rem;
            text-decoration: none; display: flex; align-items: center; gap: .5rem; }
        .sidebar-brand a i { font-size: 1.5rem; }
        .sidebar-nav { flex: 1; padding: .8rem 0; overflow-y: auto; }
        .sidebar-section { font-size: .7rem; font-weight: 700; color: rgba(255,255,255,.35);
            text-transform: uppercase; letter-spacing: 1.2px; padding: .4rem 1.2rem; margin-top: .4rem; }
        .nav-item {
            display: block; padding: .58rem 1.2rem; color: rgba(255,255,255,.65);
            font-size: .9rem; font-weight: 500; text-decoration: none;
            border-left: 3px solid transparent; transition: all .15s;
        }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,.05); }
        .nav-item.active { color: var(--gold-500); background: rgba(212,168,67,.1);
            border-left-color: var(--gold-500); }
        .sidebar-footer { border-top: 1px solid rgba(255,255,255,.08); padding: 1rem 1.2rem; }
        .sidebar-footer .username { color: rgba(255,255,255,.8); font-size: .82rem; margin-bottom: .3rem; }
        .sidebar-footer a { font-size: .78rem; }
        /* Main content */
        .admin-main { margin-left: 250px; min-height: 100vh; }
        .admin-topbar {
            background: #fff; border-bottom: 1px solid #e2e8f0; padding: .9rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 0 rgba(0,0,0,.04); position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 1rem; font-weight: 700; color: var(--prussia-700); }
        .topbar-actions { display: flex; align-items: center; gap: .75rem; }
        .btn-sidebar-toggle { display: none; background: none; border: 1px solid #e2e8f0;
            border-radius: 8px; padding: .4rem .65rem; color: var(--prussia-600); }
        .btn-logout { font-size: .78rem; padding: .35rem .9rem; border-radius: 8px;
            background: #fef2f2; color: #991b1b; border: none; font-weight: 600; }
        .btn-logout:hover { background: #fee2e2; }
        .admin-content { padding: 1.5rem; }
        /* Stats cards */
        .stat-card { background: #fff; border-radius: 14px; padding: 1.3rem 1.5rem;
            border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
        .stat-icon { font-size: 1.7rem; color: var(--gold-500); }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: var(--prussia-700); margin: .3rem 0 .1rem; }
        .stat-label { font-size: .78rem; color: #64748b; font-weight: 500; }
        /* Table */
        .table-cms { background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; }
        .table-cms thead { background: var(--prussia-600); color: #fff; }
        .table-cms thead th { font-size: .78rem; font-weight: 600; letter-spacing: .5px;
            text-transform: uppercase; padding: .85rem 1rem; border: none; }
        .table-cms tbody td { padding: .85rem 1rem; font-size: .88rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .table-cms tbody tr:last-child td { border-bottom: none; }
        .table-cms tbody tr:hover { background: #f8fafc; }
        /* Badge */
        .badge-gold { background: rgba(212,168,67,.15); color: #8c6e23; font-size: .72rem;
            font-weight: 700; padding: .22rem .6rem; border-radius: 50px; }
        .badge-soft-red { background: rgba(185,28,28,.12); color: #b91c1c; font-size: .72rem;
            font-weight: 700; padding: .22rem .6rem; border-radius: 50px; }
        .badge-green { background: rgba(22,101,52,.12); color: #166534; font-size: .72rem;
            font-weight: 700; padding: .22rem .6rem; border-radius: 50px; }
        /* Form in admin */
        .admin-card { background: #fff; border-radius: 14px; padding: 2rem;
            border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
        .admin-input { border: 1px solid #e2e8f0; border-radius: 8px; padding: .65rem .9rem; width: 100%; }
        .admin-input:focus { border-color: var(--gold-500); box-shadow: 0 0 0 .18rem rgba(212,168,67,.15); outline: none; }
        .admin-label { font-size: .82rem; font-weight: 600; color: var(--prussia-700); margin-bottom: .35rem; }
        .btn-gold { background: var(--gold-500); color: var(--prussia-700); border: none;
            border-radius: 8px; padding: .65rem 1.5rem; font-weight: 600; font-size: .9rem; }
        .btn-gold:hover { background: var(--gold-600); transform: translateY(-1px); }
        .btn-outline-soft { background: transparent; border: 1px solid #e2e8f0; color: #475569;
            border-radius: 8px; padding: .45rem 1rem; font-size: .82rem; font-weight: 600; }
        .btn-outline-soft:hover { border-color: #94a3b8; background: #f8fafc; }
        .btn-sm-danger { color: #dc2626; background: transparent; border: none;
            font-size: .82rem; padding: .25rem; }
        .btn-sm-danger:hover { background: #fef2f2; }
        /* Alert */
        .alert-admin { border-radius: 10px; border-left: 4px solid;
            padding: .85rem 1rem; font-size: .88rem; margin-bottom: 1.2rem; }
        .alert-admin-success { border-color: #22c55e; background: #f0fdf4; color: #166534; }
        .alert-admin-error   { border-color: #ef4444; background: #fef2f2; color: #991b1b; }
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .btn-sidebar-toggle { display: block; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 99; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <a href="/admin"><i class="bi bi-shield-check"></i> Sixer0</a>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section">Overview</div>
        <a href="/admin" class="nav-item {{ (request()->path() === 'admin' || request()->path() === 'admin/') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>

        <div class="sidebar-section">Konten</div>
        <a href="/admin/projects" class="nav-item {{ request()->is('admin/projects*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open me-2"></i>Kelola Proyek
        </a>

        <div class="sidebar-section">Sistem</div>
        <a href="/" target="_blank" class="nav-item">
            <i class="bi bi-eye me-2"></i>Lihat Landing Page
        </a>
        <a href="/admin/logout" class="nav-item text-danger">
            <i class="bi bi-box-arrow-right me-2"></i>Keluar
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="username"><i class="bi bi-person-circle me-1"></i>{{ session('admin_name','Admin') }}</div>
        <a href="/" style="color:rgba(255,255,255,.4);font-size:.78rem;">
            <i class="bi bi-globe me-1"></i>Landing Page
        </a>
    </div>
</aside>

<div class="admin-main">
    <!-- Top Bar -->
    <header class="admin-topbar">
        <div style="display:flex;align-items:center;gap:.75rem;">
            <button class="btn-sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-title">{{ $page_title ?? 'Dashboard' }}</div>
        </div>
        <div class="topbar-actions">
            <a href="/" target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat Situs">
                <i class="bi bi-eye me-1"></i><span class="d-none d-md-inline">Tampilan</span>
            </a>
            <form method="POST" action="/admin/logout" class="d-inline" onsubmit="return confirm('Keluar dari CMS?')">
                @csrf
                <button type="submit" class="btn-logout" title="Keluar">
                    <i class="bi bi-box-arrow-right me-1"></i>Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- Page Content -->
    <main class="admin-content">
        @if(session('admin_msg'))
            <div class="alert-admin alert-admin-success">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('admin_msg') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert-admin alert-admin-error">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif
        @yield('content')
    </main>
</div>

<button onclick="toggleSidebar()" style="display:none;@media(max-width:768px){display:none!important;}"></button>

<script>
function toggleSidebar() {
    var sb = document.getElementById('adminSidebar');
    var ov = document.getElementById('sidebarOverlay');
    sb.classList.toggle('open');
    if (ov) ov.classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
</script>
</body>
</html>
