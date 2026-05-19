<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sixer0 — Solusi Teknologi & Kreatif'); ?></title>
    <meta name="description" content="Sixer0: konsultan IT dan kreatif web, aplikasi, dan solusi digital untuk bisnis modern.">
    <meta name="keywords" content="sixer0, web development, aplikasi, solusi digital, konsultan IT, IT consultant">
    <meta name="author" content="Sixer0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold-500: #d4a843;
            --gold-600: #b8922e;
            --gold-700: #8c6e23;
            --prussia-700: #162828;
            --prussia-600: #1e3a3a;
            --prussia-500: #295a5a;
            --prussia-400: #3d7a7a;
            --prussia-200: #8eb5b5;
            --prussia-100: #cde8e8;
            --prussia-50:  #f0fbff;
            --text-dark:   #0f172a;
            --text-mid:    #475569;
            --text-light:  #94a3b8;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--prussia-50);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display','Georgia',serif; font-weight:700; color:var(--prussia-700); line-height:1.2; }

        /* NAVBAR */
        .navbar-custom {
            background: rgba(18,28,44,0.95);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 40px rgba(0,0,0,0.18);
            position: fixed; top: 0; width: 100%; z-index: 1000;
            padding: 0.9rem 0; transition: background .3s;
        }
        .navbar-brand { color: var(--gold-500) !important; font-weight:800; font-size:1.45rem; letter-spacing:-.5px; }
        .nav-link { color:rgba(255,255,255,0.72)!important; font-weight:500; padding:.5rem 1.1rem!important; border-radius:6px; transition:.2s; }
        .nav-link:hover { color:#fff!important; background:rgba(212,168,67,.12); }
        .nav-link.active  { color:var(--gold-500)!important; background:rgba(212,168,67,.1); }
        .navbar-toggler { border-color:rgba(212,168,67,.35); }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%23d4a843' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E"); }

        /* HERO */
        .hero-section {
            position: relative;
            background: linear-gradient(135deg, var(--prussia-700) 0%, #0d1f2d 60%, #1a1a2e 100%);
            min-height: 100vh; display: flex; align-items: center; overflow: hidden;
        }
        .hero-section::before {
            content:''; position:absolute; inset:0;
            background: radial-gradient(circle at 18% 52%, rgba(212,168,67,.14) 0%, transparent 50%),
                        radial-gradient(circle at 82% 28%, rgba(212,168,67,.07) 0%, transparent 50%);
        }
        .hero-badge {
            display:inline-flex; align-items:center; gap:.5rem;
            background:rgba(212,168,67,.12); border:1px solid rgba(212,168,67,.3);
            color:var(--gold-500); font-size:.78rem; font-weight:600;
            text-transform:uppercase; letter-spacing:1.2px;
            padding:.35rem 1rem; border-radius:50px; margin-bottom:1.5rem;
        }
        .hero-title { font-size:clamp(2.4rem,5.2vw,4rem); font-weight:800; color:#fff; line-height:1.1; margin-bottom:1.5rem; }
        .hero-title em { font-style:normal; color:var(--gold-500); }
        .hero-subtitle { font-size:clamp(1rem,1.5vw,1.18rem); color:rgba(255,255,255,.65); line-height:1.75; max-width:620px; margin-bottom:2.2rem; }
        .hero-cta { display:flex; gap:1rem; flex-wrap:wrap; }
        .btn-hero { display:inline-flex; align-items:center; gap:.6rem; padding:.85rem 2.2rem; border-radius:12px; font-weight:600; font-size:1rem; transition:.25s; text-decoration:none; }
        .btn-hero-primary { background:var(--gold-500); color:var(--prussia-700); border:none; }
        .btn-hero-primary:hover { background:var(--gold-600); transform:translateY(-2px); box-shadow:0 8px 25px rgba(212,168,67,.35); }
        .btn-hero-ghost { background:transparent; color:#fff; border:2px solid rgba(255,255,255,.25); }
        .btn-hero-ghost:hover { border-color:var(--gold-500); color:var(--gold-500); transform:translateY(-2px); }
        .hero-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.2rem; }
        .stat-card {
            background:rgba(255,255,255,.05); border:1px solid rgba(212,168,67,.18);
            border-radius:16px; padding:1.5rem; text-align:center; transition:.3s;
        }
        .stat-card:hover { transform:translateY(-4px); border-color:rgba(212,168,67,.5); }
        .stat-icon { font-size:2.2rem; color:var(--gold-500); margin-bottom:.6rem; }
        .stat-number { font-family:'Playfair Display',serif; font-size:2.4rem; font-weight:800; color:#fff; }
        .stat-label { font-size:.82rem; color:rgba(255,255,255,.55); text-transform:uppercase; letter-spacing:.6px; }

        /* SECTIONS */
        section { padding:6rem 0; }
        .section-eyebrow { display:inline-flex; align-items:center; gap:.5rem; font-size:.78rem; font-weight:700; text-transform:uppercase; letter-spacing:1.8px; color:var(--gold-600); margin-bottom:.75rem; }
        .section-eyebrow::before { content:''; width:28px; height:2px; background:var(--gold-600); display:inline-block; }
        .section-title { margin-bottom:1rem; }

        /* ABOUT */
        .about-card { background:#fff; border:1px solid rgba(0,0,0,.06); border-radius:18px; padding:2.2rem; height:100%; box-shadow:0 4px 30px rgba(0,0,0,.04); transition:.3s; }
        .about-card:hover { box-shadow:0 12px 45px rgba(0,0,0,.08); transform:translateY(-3px); }
        .about-card .icon-circle { width:52px; height:52px; border-radius:14px; background:linear-gradient(135deg,var(--prussia-500),var(--prussia-400)); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.3rem; margin-bottom:1rem; }

        /* SERVICES */
        .service-card { background:#fff; border-radius:18px; padding:2rem; height:100%; border:1px solid rgba(0,0,0,.06); box-shadow:0 4px 30px rgba(0,0,0,.04); transition:.3s; }
        .service-card:hover { transform:translateY(-4px); box-shadow:0 16px 50px rgba(0,0,0,.08); }
        .service-icon { font-size:2rem; color:var(--gold-500); margin-bottom:.9rem; }
        .service-tags { margin-top:1rem; }
        .service-tags span { display:inline-block; background:rgba(22,40,40,.07); color:var(--prussia-600); font-size:.76rem; font-weight:600; padding:.22rem .7rem; border-radius:50px; margin:.18rem; }

        /* ADVANTAGES */
        .advantage-item { display:flex; gap:1.2rem; align-items:flex-start; padding:1.8rem; border-radius:16px; transition:.3s; }
        .advantage-item:hover { background:rgba(212,168,67,.05); }
        .adv-icon { width:44px; height:44px; border-radius:50%; background:rgba(212,168,67,.12); display:flex; align-items:center; justify-content:center; color:var(--gold-600); font-size:1.1rem; flex-shrink:0; }

        /* PROJECTS */
        .project-card { border:none; border-radius:18px; overflow:hidden; box-shadow:0 4px 30px rgba(0,0,0,.06); transition:.3s height:100%; }
        .project-card:hover { transform:translateY(-5px); box-shadow:0 16px 50px rgba(0,0,0,.1); }
        .project-img { width:100%; height:210px; background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400)); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.25); font-size:3.5rem; }
        .project-card .card-body { padding:1.5rem; }
        .project-hours { font-size:.78rem; color:var(--text-light); }

        /* VISION */
        .vision-box { background:linear-gradient(135deg,var(--prussia-700),var(--prussia-600)); border-radius:20px; padding:3rem; color:#fff; }
        .vision-box h2 { color:#fff; }
        .vision-box p { color:rgba(255,255,255,.75); }

        /* RESULTS */
        .result-stat { text-align:center; padding:2rem; }
        .result-stat .num { font-family:'Playfair Display',serif; font-size:3.2rem; font-weight:800; color:var(--gold-500); }
        .result-stat .lbl { font-size:.9rem; color:var(--text-mid); margin-top:.3rem; }

        /* TEAM */
        .team-card { text-align:center; padding:1.8rem; }
        .team-avatar { width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400)); margin:0 auto 1rem; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.8rem; }
        .team-role { font-size:.82rem; color:var(--text-light); }

        /* CONTACT */
        .contact-form-card { background:#fff; border-radius:20px; padding:2.5rem; box-shadow:0 4px 30px rgba(0,0,0,.05); }
        .form-control:focus { border-color:var(--gold-500); box-shadow:0 0 0 .2rem rgba(212,168,67,.15); }
        .form-label { font-weight:600; font-size:.88rem; color:var(--text-mid); }
        .btn-submit { background:var(--gold-500); color:var(--prussia-700); border:none; padding:.75rem 2rem; border-radius:10px; font-weight:600; }
        .btn-submit:hover { background:var(--gold-600); }

        /* FOOTER */
        footer { background:var(--prussia-700); color:rgba(255,255,255,.65); padding:3.5rem 0 2rem; }
        footer h5 { color:var(--gold-500); font-weight:700; margin-bottom:1rem; }
        footer a { color:rgba(255,255,255,.5); text-decoration:none; transition:.2s; }
        footer a:hover { color:var(--gold-500); }
        .footer-brand { font-size:1.4rem; color:var(--gold-500)!important; font-weight:800; }
        .footer-social a { display:inline-flex; width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.07); align-items:center; justify-content:center; margin-right:.5rem; color:rgba(255,255,255,.65); transition:.2s; }
        .footer-social a:hover { background:var(--gold-500); color:var(--prussia-700); }

        /* ADMIN MODAL */
        #admin-login { visibility:hidden; opacity:0; transition:opacity .4s; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.55); display:flex; align-items:center; justify-content:center; z-index:2000; }
        #admin-logx { visibility:hidden; opacity:0; transition:opacity .4s; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.55); display:flex; align-items:center; justify-content:center; z-index:2001; }
        .admin-box { background:#fff; border-radius:18px; padding:2.2rem; width:100%; max-width:400px; box-shadow:0 20px 60px rgba(0,0,0,.2); }
        .admin-close { position:absolute; top:.8rem; right:1rem; background:none; border:none; font-size:1.4rem; color:var(--text-light); cursor:pointer; }

        /* DEV BADGE */
        .dev-badge { position:fixed; bottom:.5rem; left:.5rem; background:rgba(180,40,40,.9); color:#fff; font-size:.72rem; font-weight:700; padding:.25rem .7rem; border-radius:50px; z-index:9999; letter-spacing:.4px; }

        /* ANIM */
        .anim { opacity:0; transform:translateY(22px); transition:opacity .5s ease-out, transform .5s ease-out; }
        .anim.in { opacity:1; transform:translateY(0); }

        /* RESPONSIVE */
        @media (max-width:992px) { .about-grid{grid-template-columns:1fr;gap:2.5rem;} .hero-grid{grid-template-columns:1fr 1fr;} }
        @media (max-width:768px) { .hero-grid{grid-template-columns:1fr;} .navbar-collapse{background:var(--prussia-700);padding:1rem;border-radius:10px;margin-top:.6rem;} .contact-form-card{padding:1.5rem;} .section-title{font-size:2rem!important;} .hero-title{font-size:2.2rem!important;} }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="bi bi-shield-check me-2"></i>Sixer0</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#proyek">Proyek</a></li>
                    <li class="nav-item"><a class="nav-link" href="#visi">Visi &amp; Misi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tim">Tim</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link btn btn-hero-primary text-white ms-2 px-3 py-1" href="#">Mari Berbicara</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/login" style="font-size:.8rem;opacity:.75;"><i class="bi bi-terminal me-1"></i>Login CMS</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- NAV ANCHOR for admin -->
    <div id="admin-logx" onclick="this.style.opacity='0';setTimeout(()=>this.style.visibility='hidden',400)">
        <div class="admin-box">
            <button class="admin-close" onclick="this.closest('#admin-logx').style.opacity='0';setTimeout(()=>this.closest('#admin-logx').style.visibility='hidden',400)">&times;</button>
            <h5 class="mb-3">Admin</h5>
            <form method="POST" action="/admin/login">
                <?php echo csrf_field(); ?>
                <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                <button type="submit" class="btn btn-submit w-100">Masuk</button>
            </form>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="footer-brand"><i class="bi bi-shield-check me-2"></i>Sixer0</h5>
                    <p style="color:rgba(255,255,255,.6);line-height:1.8;margin-top:.7rem;">Konsultan IT dan kreatif berbasis Indonesia, menghadirkan solusi digital yang aman, andal, dan berkelanjutan untuk bisnis modern.</p>
                    <div class="footer-social mt-3">
                        <a href="#" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
                        <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Navigasi</h6>
                    <ul class="list-unstyled" style="line-height:2.2;">
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#proyek">Proyek</a></li>
                        <li><a href="#visi">Visi &amp; Misi</a></li>
                        <li><a href="#tim">Tim Kami</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Informasi</h6>
                    <ul class="list-unstyled" style="line-height:2.2;">
                        <li><a href="#visi">Visi &amp; Misi</a></li>
                        <li><a href="#pengembangan">Pencapaian</a></li>
                        <li><a href="#tim">Tim Kami</a></li>
                        <li><a href="#" onclick="openLegal('privacy');return false">Kebijakan Privasi</a></li>
                        <li><a href="#" onclick="openLegal('notice');return false">Catatan Hukum</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Kantor</h6>
                    <ul class="list-unstyled" style="line-height:2.2;">
                        <li>Tangerang, Indonesia</li>
                        <li><a href="mailto:info@sixer0-bk.my.id">info@sixer0-bk.my.id</a></li>
                        <li><a href="https://sixer0-bk.my.id">sixer0-bk.my.id</a></li>
                        <li><a href="https://github.com/sixer0">github.com/sixer0</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color:rgba(255,255,255,.1);">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="mb-0" style="color:rgba(255,255,255,.45);font-size:.85rem;">&copy; <?php echo e(date('Y')); ?> Sixer0. Hak Cipta Dilindungi.</p>
                <div style="color:rgba(255,255,255,.4);font-size:.8rem;">Rancang &amp; Build by <a href="https://sixer0-bk.my.id" style="color:var(--gold-500);">Sixer0</a></div>
            </div>
            <div class="text-end mt-3">
                <a href="#admin-logx" id="admin-link" style="color:rgba(212,168,67,.3);font-size:.78rem;transition:color .2s;" onmouseover="this.style.color='rgba(212,168,67,.8)'" onmouseout="this.style.color='rgba(212,168,67,.3)'">Admin ▸</a>
            </div>
        </div>
    </footer>

    <?php if(app('env') === 'local' || config('app.debug')): ?>
    <div class="dev-badge"><i class="bi bi-bug-fill me-1"></i> DEV — <?php echo e(config('app.name','Sixer0')); ?></div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const hero = document.querySelector('.hero-section');
            if (hero) hero.style.backgroundPositionY = (window.scrollY * 0.3) + 'px';
        });

        const _io = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); _io.unobserve(e.target); } });
        }, { threshold: 0.12 });
        document.querySelectorAll('.anim').forEach(el => _io.observe(el));

        const _sects = document.querySelectorAll('section[id]');
        function _navHL() {
            let cur = '';
            _sects.forEach(s => { if (window.scrollY >= (s.offsetTop - 90)) cur = s.getAttribute('id'); });
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.querySelectorAll('.nav-link[href="#'+cur+'"]').forEach(l => l.classList.add('active'));
        }
        window.addEventListener('scroll', _navHL); _navHL();

        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('[type=submit]');
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i>Mengirim…'; btn.disabled = true;
            fetch(this.action, { method:'POST', body:new FormData(this), headers:{'X-Requested-With':'XMLHttpRequest'} })
            .then(() => { btn.innerHTML='<i class="bi bi-check-circle me-2"></i>Terima Kasih! Pesan Terkirim.'; btn.style.background='#166534'; setTimeout(()=>{ btn.innerHTML=orig; btn.disabled=false; btn.style.background=''; this.reset(); refreshCaptcha(); }, 3500); })
            .catch(() => { btn.innerHTML='<i class="bi bi-exclamation-circle me-2"></i>Gagal, coba lagi.'; btn.style.background='#991b1b'; setTimeout(()=>{ btn.innerHTML=orig; btn.disabled=false; btn.style.background=''; }, 2000); });
        });

        async function refreshCaptcha() {
            try { const r = await fetch('<?php echo e(route("contact.captcha")); ?>'); const d = await r.json(); document.getElementById('captcha-question').textContent = d.question + ' = ?'; document.getElementById('captcha-hash').value = d.hash; } catch(_){}
        }
        refreshCaptcha();

        // Admin login modal toggle
        document.getElementById('admin-link').addEventListener('click', function(e) {
            e.preventDefault();
            const mx = document.getElementById('admin-logx');
            if (mx.style.visibility === 'hidden') { mx.style.opacity='0'; mx.style.visibility='visible'; requestAnimationFrame(()=>requestAnimationFrame(()=>{ mx.style.opacity='1'; })); }
            else { mx.style.opacity='0'; setTimeout(()=>{ mx.style.visibility='hidden'; }, 500); }
        });
    </script>

    


<script src="/public/js/chat-widget.js"></script>

    <!-- LEGAL MODALS -->
    <div id="legal-modal" style="display:none;position:fixed;inset:0;z-index:2005;background:rgba(0,0,0,.6);align-items:center;justify-content:center;overflow-y:auto;" onclick="if(event.target===this)closeLegal()">
        <div class="container" style="padding:2rem 1rem;display:flex;justify-content:center;">
            <div class="card border-0 shadow-lg" style="width:100%;max-width:780px;position:relative;">
                <button onclick="closeLegal()" style="position:absolute;top:.8rem;right:1rem;background:none;border:none;font-size:1.4rem;color:var(--text-light);cursor:pointer;">&times;</button>
                <div id="modal-body" class="card-body p-5"></div>
            </div>
        </div>
    </div>

    <script>
    var _LEGAL = {
        privacy: { title: "Kebijakan Privasi",
            body: '<div style="max-height:65vh;overflow-y:auto;"><h1 class="fw-bold mb-4">Kebijakan Privasi</h1><p class="text-muted mb-4">Terakhir diperbarui: '+new Date().toLocaleDateString("en",{year:"numeric",month:"long",day:"numeric"})+'</p><h5 class="mt-4">1. Informasi yang Kami Kumpulkan</h5><p>Kami mengumpulkan informasi yang Anda berikan secara langsung, seperti nama, email, dan nomor telepon ketika Anda mengisi formulir kontak di situs ini.</p><h5 class="mt-4">2. Penggunaan Informasi</h5><p>Informasi yang dikumpulkan digunakan hanya untuk menanggapi pertanyaan dan permintaan Anda. Kami tidak menjual atau menyewakan data pribadi Anda kepada pihak ketiga.</p><h5 class="mt-4">3. Formulir Kontak</h5><p>Saat mengirim pesan melalui formulir kontak, kami mengumpulkan dan memproses:</p><ul><li>Nama lengkap</li><li>Alamat email</li><li>Nomor telepon</li><li>Nama perusahaan (opsional)</li><li>Isi pesan</li></ul><h5 class="mt-4">4. Cookies</h5><p>Situs ini menggunakan cookie untuk meningkatkan pengalaman pengguna. Anda dapat menonaktifkan cookie kapan saja melalui pengaturan browser Anda.</p><h5 class="mt-4">5. Hak Anda</h5><p>Anda berhak untuk mengetahui data pribadi apa saja yang kami simpan, meminta perbaikannya, pemblokiran, atau penghapusan data tersebut.</p></div>' },
        notice:  { title: "Catatan Hukum",
            body: '<div style="max-height:65vh;overflow-y:auto;"><h1 class="fw-bold mb-4">Legal Notice</h1><h5 class="mt-4">Informasi sesuai Undang-Undang</h5><p><strong>Budi Kusharyanto</strong><br>IT Consultant &amp; Software Developer<br>Tangerang, Indonesia<br>Email: info@sixer0-bk.my.id</p><h5 class="mt-4">Tanggung Jawab Konten</h5><p>Budi Kusharyanto</p><h5 class="mt-4">Batasan Tanggung Jawab</h5><p>Konten di situs ini disusun dengan sebaik mungkin. Namun, kami tidak menjamin kelengkapan, ketepatan, atau keakuratan informasi yang disajikan.</p><h5 class="mt-4">Hak Cipta</h5><p>Semua konten milik Sixer0 hak cipta dilindungi undang-undang. Diakses dan digunakan hanya untuk keperluan pribadi. Dilarang menggandakan, mendistribusikan, atau memanfaatkan konten ini untuk tujuan komersial tanpa izin tertulis.</p><h5 class="mt-4">Hukum yang Berlaku</h5><p>Situs ini dijalankan sesuai hukum yang berlaku di Indonesia.</p></div>' }
    };
    function openLegal(type) {
        var d = _LEGAL[type]; if (!d) return;
        document.getElementById('modal-body').innerHTML = d.body;
        document.getElementById('legal-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        history.pushState({_legalModal:type}, '', '#legal-'+type);
    }
    function closeLegal() {
        document.getElementById('legal-modal').style.display = 'none';
        document.body.style.overflow = '';
        if (history.state && history.state._legalModal) history.back();
    }
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeLegal(); });
    </script>

</body>
</html>
<?php /**PATH /home/sixq7133/public_html/landing.sixer0-bk.my.id/resources/views/layouts/guest.blade.php ENDPATH**/ ?>