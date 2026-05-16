<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organisasi Industri Militer Saudi — OIMS</title>
    <meta name="description" content="Organisasi Industri Militer Saudi (OIMS): pilar pertahanan nasional, inovasi teknologi pertahanan, dan kemandirian industri militer.">
    <meta name="keywords" content="Industri militer Saudi, OIMS, pertahanan nasional, teknologi pertahanan, kemandirian industri">
    <meta name="author" content="Organisasi Industri Militer Saudi">
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
        .section-subtitle { font-size:1.05rem; color:var(--text-mid); max-width:600px; line-height:1.8; }
        .section-alt { background:#fff; }
        .divider-gold { width:55px; height:3px; background:var(--gold-500); border-radius:2px; margin:1rem 0 2.5rem; }

        /* ABOUT BULLETS */
        .about-bullets { list-style:none; padding:0; margin:0; }
        .about-bullets li { display:flex; align-items:flex-start; gap:.9rem; padding:1.1rem 0; border-bottom:1px solid var(--prussia-100); }
        .about-bullets li:last-child { border-bottom:none; }
        .about-bullets .check { flex-shrink:0; width:26px; height:26px; border-radius:50%; background:rgba(212,168,67,.12); color:var(--gold-600); display:flex; align-items:center; justify-content:center; font-size:.7rem; margin-top:.1rem; }
        .about-bullets strong { display:block; color:var(--prussia-700); margin-bottom:.15rem; }

        /* VALUE CARD */
        .value-card { background:#fff; border-radius:20px; padding:2.5rem 2rem; box-shadow:0 4px 30px rgba(18,28,44,.07); border:1px solid var(--prussia-100); transition:.3s; height:100%; }
        .value-card:hover { transform:translateY(-5px); box-shadow:0 20px 50px rgba(18,28,44,.12); border-color:rgba(212,168,67,.4); }
        .value-icon { width:72px; height:72px; border-radius:18px; background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400)); display:flex; align-items:center; justify-content:center; font-size:1.9rem; color:var(--gold-500); margin-bottom:1.4rem; }
        .value-card h4 { font-size:1.15rem; font-weight:700; color:var(--prussia-700); margin-bottom:.75rem; }
        .value-card p { color:var(--text-mid); font-size:.95rem; line-height:1.7; }

        /* SERVICE CARD */
        .service-card { background:#fff; border-radius:20px; padding:2.2rem; box-shadow:0 4px 24px rgba(18,28,44,.06); border-left:4px solid var(--gold-500); transition:.3s; height:100%; }
        .service-card:hover { transform:translateY(-4px); box-shadow:0 16px 40px rgba(18,28,44,.12); }

        /* PROJECT CARD */
        .project-card { border-radius:16px; overflow:hidden; border:1px solid var(--prussia-100); box-shadow:0 4px 20px rgba(18,28,44,.06); transition:.3s; background:#fff; height:100%; }
        .project-card:hover { transform:translateY(-5px); box-shadow:0 16px 40px rgba(18,28,44,.12); }
        .project-card .img-wrap { height:210px; overflow:hidden; background:var(--prussia-100); position:relative; }
        .project-card .img-wrap img { width:100%; height:100%; object-fit:cover; transition:.4s; }
        .project-card:hover .img-wrap img { transform:scale(1.05); }

        /* CONTACT */
        .contact-section { background:linear-gradient(135deg,var(--prussia-700),var(--prussia-600)); color:#fff; padding:6rem 0; }
        .contact-form-card { background:rgba(255,255,255,.95); border-radius:22px; padding:3rem; box-shadow:0 20px 60px rgba(0,0,0,.15); backdrop-filter:blur(10px); }
        .form-control, .form-select { border:2px solid var(--prussia-200); border-radius:12px; padding:.78rem 1rem; font-size:.97rem; transition:.2s; }
        .form-control:focus, .form-select:focus { border-color:var(--gold-500); box-shadow:0 0 0 4px rgba(212,168,67,.12); outline:none; }
        .form-label { font-weight:600; color:var(--prussia-700); font-size:.88rem; margin-bottom:.4rem; }
        .btn-send { background:var(--prussia-700); color:var(--gold-500); border:none; border-radius:12px; padding:.9rem 2.2rem; font-weight:600; font-size:1rem; width:100%; transition:.3s; cursor:pointer; }
        .btn-send:hover { background:var(--prussia-600); transform:translateY(-2px); }

        /* FOOTER */
        footer { background:var(--prussia-700); color:rgba(255,255,255,.7); font-size:.9rem; }
        footer h5, footer h6 { color:var(--gold-500); font-family:'Playfair Display',serif; margin-bottom:1rem; }
        footer a { color:rgba(255,255,255,.65); text-decoration:none; transition:color .2s; }
        footer a:hover { color:var(--gold-500); }
        .footer-social a { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.07); margin-right:.65rem; font-size:1.15rem; color:#fff; transition:.2s; }
        .footer-social a:hover { background:var(--gold-500); color:var(--prussia-700); }

        /* DEV BADGE */
        .dev-badge { position:fixed; bottom:18px; right:18px; background:var(--gold-600); color:var(--prussia-700); padding:8px 16px; border-radius:10px; font-size:.82rem; font-weight:700; z-index:9999; box-shadow:0 4px 15px rgba(140,110,35,.3); text-decoration:none; transition:.2s; cursor:pointer; }
        .dev-badge:hover { background:var(--gold-500); transform:translateY(-2px); }

        /* ANIMATIONS */
        .anim { opacity:0; transform:translateY(28px); transition:opacity .65s ease, transform .65s ease; }
        .anim.in { opacity:1; transform:none; }

        @media (max-width:992px) { .about-grid{grid-template-columns:1fr;gap:2.5rem;} .hero-grid{grid-template-columns:1fr 1fr;} }
        @media (max-width:768px) { .hero-grid{grid-template-columns:1fr;} .navbar-collapse{background:var(--prussia-700);padding:1rem;border-radius:10px;margin-top:.6rem;} .contact-form-card{padding:1.5rem;} .section-title{font-size:2rem!important;} .hero-title{font-size:2.2rem!important;} }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="bi bi-shield-check me-2"></i>OIMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#proyek">Proyek</a></li>
                    <li class="nav-item"><a class="nav-link" href="#visi">Visi &amp; Misi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-hero-primary text-white ms-2 px-3 py-1" href="#kontak">Mari Bicara</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="tentang" class="hero-section">
        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="hero-badge"><i class="bi bi-star-fill"></i> Industri Pertahanan Terdepan</div>
                    <h1 class="hero-title">
                        Organisasi<br><em>Industri Militer</em> Saudi
                    </h1>
                    <p class="hero-subtitle">
                        Sejak 2014, OIMS menjadi pilar pertahanan nasional Arab Saudi — mengonsolidasikan industri pertahanan dalam negeri, merancang dan memproduksi sistem persenjataan canggih, serta menjalin kemitraan strategis lintas benua untuk menjaga kedaulatan negara.
                    </p>
                    <div class="hero-cta">
                        <a class="btn-hero btn-hero-primary" href="#layanan"><i class="bi bi-tools"></i> Lihat Layanan</a>
                        <a class="btn-hero btn-hero-ghost" href="#visi"><i class="bi bi-play-circle"></i> Tonton Profil</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-grid">
                        <div class="stat-card"><div class="stat-icon"><i class="bi bi-bar-chart-line"></i></div><div class="stat-number">250+</div><div class="stat-label">Proyek Strategis</div></div>
                        <div class="stat-card"><div class="stat-icon"><i class="bi bi-globe"></i></div><div class="stat-number">35+</div><div class="stat-label">Negara Mitra</div></div>
                        <div class="stat-card"><div class="stat-icon"><i class="bi bi-people"></i></div><div class="stat-number">15K+</div><div class="stat-label">Profesional Ahli</div></div>
                        <div class="stat-card"><div class="stat-icon"><i class="bi bi-trophy"></i></div><div class="stat-number">95%</div><div class="stat-label">Promil &amp; Kelengkapan</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section-alt">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0 anim">
                    <div class="section-eyebrow">Tentang Kami</div>
                    <h2 class="section-title">Membangun <em>Pertahanan</em><br>Dari Dalam Negeri</h2>
                    <p style="color:var(--text-mid);line-height:1.8;margin-bottom:1.5rem;">
                        Organisasi Industri Militer Saudi (OIMS — <em>General Organization for Military Industries</em>) didirikan pada tahun 2014 dengan amanah khusus memenuhi kebutuhan pertahanan nasional Arab Saudi secara mandiri. Sejak pembentukannya, OIMS telah bertransformasi menjadi pusat integrasi industri pertahanan, menggandeng swasta nasional, mitra internasional, dan lembaga riset dalam satu ekosistem inovatif.
                    </p>
                    <p style="color:var(--text-mid);line-height:1.8;">
                        Visi OIMS adalah mewujudkan kemandirian industri pertahanan Arab Saudi sebesar 50% pada tahun 2030, dengan menyelenggarakan pabrik-pabrik pemurni logam, pengolahan polimer, perakitan sistem elektronika, dan tes balistik secara end-to-end di wilayah negeri sendiri.
                    </p>
                    <ul class="about-bullets">
                        <li><span class="check"><i class="bi bi-check"></i></span><div><strong>Gagasan Berdikari</strong><small style="color:var(--text-mid);display:block;">Mendorong inovasi dan R&amp;D dalam negeri untuk produk-produk strategis.</small></div></li>
                        <li><span class="check"><i class="bi bi-check"></i></span><div><strong>Kemitraan Global</strong><small style="color:var(--text-mid);display:block;">Aliansi strategis dengan AS, Eropa, dan Asia untuk transfer teknologi.</small></div></li>
                        <li><span class="check"><i class="bi bi-check"></i></span><div><strong>Pembangunan SDM</strong><small style="color:var(--text-mid);display:block;">15.000+ profesional terlatih di bidang strategi, rekayasa, dan manufaktur.</small></div></li>
                    </ul>
                </div>
                <div class="col-lg-6 anim">
                    <div class="bg-white rounded-4 shadow-lg p-4" style="border:1px solid var(--prussia-100);">
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden mb-4" style="background:linear-gradient(135deg,var(--prussia-200),var(--prussia-400));">
                            <div class="d-flex align-items-center justify-content-center" style="min-height:220px">
                                <div class="text-center" style="color:var(--prussia-600)">
                                    <i class="bi bi-display" style="font-size:3.5rem;display:block;margin-bottom:.75rem"></i>
                                    <strong>Sistem Komando &amp; Kendali</strong><br>
                                    <small>Infrastruktur digital terintegrasi OIMS</small>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background:var(--prussia-50);border:1px solid var(--prussia-100)">
                                    <small style="color:var(--text-mid);font-size:.75rem;text-transform:uppercase;letter-spacing:.5px">Didirikan</small>
                                    <div style="font-weight:700;color:var(--prussia-700);font-size:1.2rem;margin-top:.2rem">2014</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background:var(--prussia-50);border:1px solid var(--prussia-100)">
                                    <small style="color:var(--text-mid);font-size:.75rem;text-transform:uppercase;letter-spacing:.5px">Kantor Pusat</small>
                                    <div style="font-weight:700;color:var(--prussia-700);font-size:1.2rem;margin-top:.2rem">Riyadh, KSA</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background:var(--prussia-50);border:1px solid var(--prussia-100)">
                                    <small style="color:var(--text-mid);font-size:.75rem;text-transform:uppercase;letter-spacing:.5px">Tujuan 2030</small>
                                    <div style="font-weight:700;color:var(--prussia-700);font-size:1.2rem;margin-top:.2rem">50% Kemandirian Industri Pertahanan Nasional</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LAYANAN -->
    <section id="layanan">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto anim">
                    <div class="section-eyebrow mx-auto">Layanan Utama</div>
                    <h2 class="section-title">Laporan Strategis &amp; Operasional</h2>
                    <div class="divider-gold mx-auto"></div>
                    <p class="section-subtitle mx-auto">OIMS menyelenggarakan berbagai layanan strategis untuk mendukung ekosistem industri pertahanan nasional — dari pengendalian kualitas hingga pertahanan siber.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 anim">
                    <div class="service-card">
                        <div class="value-icon mb-3"><i class="bi bi-shield-lock"></i></div>
                        <h4>Teknologi &amp; Pertahanan</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.7;">Pengembangan sistem persenjataan, radar, sistem kendali, dan sensor canggih serta IoT untuk keamanan nasional.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3" style="border-radius:8px;">Pelajari Lebih &rarr;</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 anim">
                    <div class="service-card">
                        <div class="value-icon mb-3"><i class="bi bi-bar-chart"></i></div>
                        <h4>Manufaktur Taktis</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.7;">Produksi suku cadang, komponen respon, &amp; sistem pertahanan secara massal — didukung rantai pasok terintegrasi dan QS-9000.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3" style="border-radius:8px;">Pelajari Lebih &rarr;</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 anim">
                    <div class="service-card">
                        <div class="value-icon mb-3"><i class="bi bi-cpu"></i></div>
                        <h4>Pertahanan Siber</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.7;">Security Operations Center (SOC), threat intelligence, defensif siber, dan respons insiden untuk melindungi infrastruktur pertahanan digital.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3" style="border-radius:8px;">Pelajari Lebih &rarr;</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 anim">
                    <div class="service-card">
                        <div class="value-icon mb-3"><i class="bi bi-building"></i></div>
                        <h4>Kemitraan &amp; Investasi</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.7;">Jembatan antara investor global, produsen pertahanan, dan perusahaan dalam negeri untuk proyek-proyek strategis sektor pertahanan.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3" style="border-radius:8px;">Pelajari Lebih &rarr;</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 anim">
                    <div class="service-card">
                        <div class="value-icon mb-3"><i class="bi bi-book"></i></div>
                        <h4>Standarisasi &amp; Sertifikasi</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.7;">Audit, verifikasi, dan sertifikasi produk pertahanan sesuai standar NATO dan standar nasional KSA.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3" style="border-radius:8px;">Pelajari Lebih &rarr;</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 anim">
                    <div class="service-card">
                        <div class="value-icon mb-3"><i class="bi bi-graph-up-arrow"></i></div>
                        <h4>Pengendalian &amp; Evaluasi</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.7;">Sistem evaluasi kinerja, pelaporan strategis, dan intelligence untuk memastikan yang mendukungnya mengikuti misi nasional pertahanan.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3" style="border-radius:8px;">Pelajari Lebih &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN -->
    <section id="keunggulan" style="background:#fff;">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto anim">
                    <div class="section-eyebrow mx-auto">Mengapa OIMS</div>
                    <h2 class="section-title">Keunggulan Kompetitif</h2>
                    <div class="divider-gold mx-auto"></div>
                    <p class="section-subtitle mx-auto">Lebih dari sekadar produsen — OIMS adalah ekosistem integrasi penuh yang menghubungkan inovasi, kualitas, dan kedaulatan nasional.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 anim">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto"><i class="bi bi-lightning-charge"></i></div>
                        <h4>Inovasi Cepat</h4>
                        <p>R&amp;D in-house yang lepas dari konsep ke prototipe hingga massal dalam hitungan bulan, bukan tahun.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 anim">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto"><i class="bi bi-building-gear"></i></div>
                        <h4>Manufaktur Lokal</h4>
                        <p>Pabrik-pabrik OIMS di seluruh wilayah KSA memastikan rantai pasok aman, terjamin kualitas dan keamanan data.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 anim">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto"><i class="bi bi-shield-check"></i></div>
                        <h4>Standar Global</h4>
                        <p>Setiap produk lulus audit NATO dan ISO — memastikan ekspor dan interoperabilitas dengan sekutu strategis.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 anim">
                    <div class="value-card text-center">
                        <div class="value-icon mx-auto"><i class="bi bi-people"></i></div>
                        <h4>Tim Ahli</h4>
                        <p>15.000+ profesional dari 40+ negara, dipersiapkan melalui program magang dan pelatihan khusus OIMS.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROYEK -->
    <section id="proyek" class="section-alt">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto anim">
                    <div class="section-eyebrow mx-auto">Portofolio</div>
                    <h2 class="section-title">Proyek Unggulan</h2>
                    <div class="divider-gold mx-auto"></div>
                    <p class="section-subtitle mx-auto">Dari sistem alutsista hingga platform digital — pilihan proyek strategis yang telah diselesaikan OIMS untuk memenuhi kebutuhan pertahanan nasional.</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($projects as $project)
                <div class="col-lg-4 col-md-6 anim">
                    <div class="project-card">
                        <div class="img-wrap">
                            @if($project->image)
                            <img src="{{ $project->image }}" alt="{{ $project->name }}" loading="lazy">
                            @else
                            <div class="d-flex align-items-center justify-content-center" style="height:100%;background:linear-gradient(135deg,var(--prussia-200),var(--prussia-400))">
                                <i class="bi bi-folder2-open" style="font-size:3rem;color:var(--prussia-600)"></i>
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h5 class="project-title" style="font-family:'Playfair Display',serif;font-weight:700;color:var(--prussia-700);">{{ $project->name }}</h5>
                            <p class="project-desc">{{ $project->description }}</p>
                            @if($project->project_url)
                            <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary" style="border-color:var(--prussia-200);border-radius:8px;">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                @if($projects->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="bi bi-box" style="font-size:3rem;color:var(--prussia-200)"></i>
                    <p class="mt-3" style="color:var(--text-mid)">Proyek akan ditampilkan di sini.</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- VISI & MISI -->
    <section id="visi" style="background:var(--prussia-700);color:#fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0 anim">
                    <div class="section-eyebrow" style="color:var(--gold-500);">Visi &amp; Misi</div>
                    <h2 style="color:#fff;margin-bottom:1.5rem;">Mewujudkan <em>Kedaulatan</em><br>Pertahanan Nasional</h2>
                    <p style="color:rgba(255,255,255,.7);line-height:1.8;">Di tengah lanskap geostrategi yang terus bergerak, OIMS berkomitmen penuh menghadirkan kemandirian industri pertahanan Arab Saudi minimal 50% pada tahun 2030 — dengan tetap menjaga interoperabilitas dengan sekutu strategis global.</p>
                    <a class="btn btn-hero btn-hero-primary mt-3" href="#kontak">Mulai Kolaborasi</a>
                </div>
                <div class="col-lg-7 anim">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-4" style="background:rgba(255,255,255,.07);border:1px solid rgba(212,168,67,.22);">
                                <i class="bi bi-bullseye" style="font-size:1.8rem;color:var(--gold-500);display:block;margin-bottom:.75rem;"></i>
                                <h5 style="color:#fff;font-family:'Playfair Display',serif;">Misi</h5>
                                <p style="color:rgba(255,255,255,.68);font-size:.93rem;line-height:1.75;">Mengembangkan, memproduksi, dan memelihara sistem pertahanan terpadu; mengembangkan ekosistem industri nasional; dan memastikan pasokan logistik pertahanan yang andal, aman, dan berkelanjutan.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-4" style="background:rgba(255,255,255,.07);border:1px solid rgba(212,168,67,.22);">
                                <i class="bi bi-lightbulb" style="font-size:1.8rem;color:var(--gold-500);display:block;margin-bottom:.75rem;"></i>
                                <h5 style="color:#fff;font-family:'Playfair Display',serif;">Nilai Inti</h5>
                                <ul style="color:rgba(255,255,255,.68);font-size:.93rem;line-height:1.75;list-style:none;padding:0;">
                                    <li style="padding:.35rem 0;">&#9989; Kedaulatan &amp; Kemandirian</li>
                                    <li style="padding:.35rem 0;">&#9989; Keunggulan Teknis</li>
                                    <li style="padding:.35rem 0;">&#9989; Integritas &amp; Transparansi</li>
                                    <li style="padding:.35rem 0;">&#9989; Kolaborasi Internasional</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-4" style="background:rgba(255,255,255,.07);border:1px solid rgba(212,168,67,.22);">
                                <i class="bi bi-heart" style="font-size:1.8rem;color:var(--gold-500);display:block;margin-bottom:.75rem;"></i>
                                <h5 style="color:#fff;font-family:'Playfair Display',serif;">Visi</h5>
                                <p style="color:rgba(255,255,255,.68);font-size:.93rem;line-height:1.75;">Menjadi pusat industri pertahanan terdepan di Timur Tengah — inovatif, berkelanjutan, dan menjadi aset strategis bagi keamanan regional.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-4" style="background:rgba(255,255,255,.07);border:1px solid rgba(212,168,67,.22);">
                                <i class="bi bi-flag" style="font-size:1.8rem;color:var(--gold-500);display:block;margin-bottom:.75rem;"></i>
                                <h5 style="color:#fff;font-family:'Playfair Display',serif;">Tujuan Jangka Pendek</h5>
                                <p style="color:rgba(255,255,255,.68);font-size:.93rem;line-height:1.75;">Meningkatkan jumlah proyek strategis; meningkatkan kompetensi SDM dengan kerja sama internasional; dan memperkuat ekosistem industri pertahanan nasional.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEJARAH & KEPEMIMPINAN -->
    <section id="pengembangan" class="section-alt">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto anim">
                    <div class="section-eyebrow mx-auto">Pengembangan</div>
                    <h2 class="section-title">Perjalanan &amp; Kebijakan</h2>
                    <div class="divider-gold mx-auto"></div>
                </div>
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 anim">
                    <div class="value-card h-100">
                        <div class="value-icon mb-3"><i class="bi bi-book"></i></div>
                        <h4>Sejarah &amp; Modal Dasar</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.75;">Berdasarkan Keputusan Menteri Pertahanan Arab Saudi No. 2014/35, OIMS dirintis untuk menjadi tulang punggung kemandirian industri pertahanan. Modal awal dibentuk dari perpaduan saham pemerintah, kontribusi swasta nasional, dan kerja sama internasional yang mengalirkan teknologi produksi berkualitas.</p>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.75;">Hingga saat ini, total aset OIMS mencapai lebih dari USD 40 miliar dengan lebih dari 250 proyek strategis yang sedang beroperasi di seluruh wilayah Arab Saudi, mencakup pabrik-pabrik pemurni logam, pengolahan polimer, perakitan sistem elektronika, dan tes balistik.</p>
                    </div>
                </div>
                <div class="col-lg-6 anim">
                    <div class="value-card h-100">
                        <div class="value-icon mb-3"><i class="bi bi-people-gear"></i></div>
                        <h4>Tim &amp; Struktur Kepemimpinan</h4>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.75;">Dipimpin oleh CEO HRH Prince Khaled bin Salman Al Saud, tim kepemimpinan OIMS terdiri dari mantan pejabat tinggi pertahanan, ahli strategi militer, dan engineers sains komputer dengan pelatihan khusus AS dan Eropa.</p>
                        <p style="color:var(--text-mid);font-size:.95rem;line-height:1.75;">Dewan Penasihat mencakup mantan Menteri Pertahanan, mantan komandan NATO, dan tokoh bisnis global. Dewan Pengawas — yang menangani keuangan, audit, dan kepatuhan — memastikan tata kelola yang transparan dan akuntabilitas penuh.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TIM -->
    <section id="tim">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto anim">
                    <div class="section-eyebrow mx-auto">Personel &amp; Tim</div>
                    <h2 class="section-title">Tim Ahli OIMS</h2>
                    <div class="divider-gold mx-auto"></div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 anim">
                    <div class="text-center p-4 rounded-4" style="background:#fff;border:1px solid var(--prussia-100);box-shadow:0 4px 20px rgba(18,28,44,.06);">
                        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400));margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill" style="font-size:2rem;color:var(--gold-500)"></i>
                        </div>
                        <h5 style="color:var(--prussia-700);margin-bottom:.2rem;">HRH Prince Khaled bin Salman Al Saud</h5>
                        <small style="color:var(--gold-600);font-weight:600;">Ketua Umum &amp; CEO</small>
                        <p style="color:var(--text-mid);font-size:.85rem;line-height:1.6;margin-top:.75rem;">Putra Menteri Pertahanan KSA, menjembatani visi "Vision 2030" dengan eksekusi strategis OIMS.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 anim">
                    <div class="text-center p-4 rounded-4" style="background:#fff;border:1px solid var(--prussia-100);box-shadow:0 4px 20px rgba(18,28,44,.06);">
                        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400));margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill" style="font-size:2rem;color:var(--gold-500)"></i>
                        </div>
                        <h5 style="color:var(--prussia-700);margin-bottom:.2rem;">Eng. Ahmed Al-Mutairi</h5>
                        <small style="color:var(--gold-600);font-weight:600;">Direktur Teknik &amp; Teknologi</small>
                        <p style="color:var(--text-mid);font-size:.85rem;line-height:1.6;margin-top:.75rem;">Senior researcher dengan 18 tahun pengalaman di industri pertahanan dan aerospace.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 anim">
                    <div class="text-center p-4 rounded-4" style="background:#fff;border:1px solid var(--prussia-100);box-shadow:0 4px 20px rgba(18,28,44,.06);">
                        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400));margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill" style="font-size:2rem;color:var(--gold-500)"></i>
                        </div>
                        <h5 style="color:var(--prussia-700);margin-bottom:.2rem;">Dr. Sarah Al-Rashoud</h5>
                        <small style="color:var(--gold-600);font-weight:600;">Direktur Kebijakan &amp; Hub. Internasional</small>
                        <p style="color:var(--text-mid);font-size:.85rem;line-height:1.6;margin-top:.75rem;">Mantan diplomat dan ahli hubungan internasional, memimpin perundingan dengan mitra global.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 anim">
                    <div class="text-center p-4 rounded-4" style="background:#fff;border:1px solid var(--prussia-100);box-shadow:0 4px 20px rgba(18,28,44,.06);">
                        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--prussia-600),var(--prussia-400));margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill" style="font-size:2rem;color:var(--gold-500)"></i>
                        </div>
                        <h5 style="color:var(--prussia-700);margin-bottom:.2rem;">Lt. Col. Omar Al-Fahad (Ret.)</h5>
                        <small style="color:var(--gold-600);font-weight:600;">Direktur Operasional &amp; Logistik</small>
                        <p style="color:var(--text-mid);font-size:.85rem;line-height:1.6;margin-top:.75rem;">Veteran 20 tahun Royal Saudi Air Force, bertanggung jawab atas keseluruhan rantai pasok.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HUBUNGI KAMI -->
    <section id="kontak" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0 anim">
                    <div class="section-eyebrow" style="color:var(--gold-500);">Kontak</div>
                    <h2 style="color:#fff;font-size:2.5rem;margin-bottom:1rem;">Silakan Hubungi Kami</h2>
                    <div class="divider-gold"></div>
                    <p style="color:rgba(255,255,255,.7);line-height:1.8;margin-bottom:2rem;">Apakah Anda adalah mitra potensial, reporter, atau peneliti? Tim OIMS siap menjawab setiap pertanyaan Anda dalam 2x24 jam kerja.</p>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:46px;height:46px;border-radius:12px;background:rgba(212,168,67,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-geo-alt" style="color:var(--gold-500);font-size:1.1rem;"></i></div>
                            <div><small style="color:rgba(255,255,255,.5);font-size:.78rem;">Kantor Pusat</small><div style="color:#fff;font-weight:500;">Olaya Street, Riyadh, Saudi Arabia</div></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:46px;height:46px;border-radius:12px;background:rgba(212,168,67,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-telephone" style="color:var(--gold-500);font-size:1.1rem;"></i></div>
                            <div><small style="color:rgba(255,255,255,.5);font-size:.78rem;">Telepon</small><div style="color:#fff;font-weight:500;">+966 11 463 3000</div></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:46px;height:46px;border-radius:12px;background:rgba(212,168,67,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-envelope" style="color:var(--gold-500);font-size:1.1rem;"></i></div>
                            <div><small style="color:rgba(255,255,255,.5);font-size:.78rem;">Email</small><div style="color:#fff;font-weight:500;">info@oims.gov.sa</div></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 anim">
                    <div class="contact-form-card">
                        <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="nama@perusahaan.com" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Subjek</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Subjek pesan Anda">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Pesan</label>
                                    <textarea name="message" class="form-control" rows="5" placeholder="Tulis pesan atau pertanyaan Anda di sini..." required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kode Keamanan</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="form-control text-center fw-bold" style="min-width:80px;background:var(--prussia-50);"><span id="captcha-question">{{ $captcha_question }} = ?</span></div>
                                        <input type="hidden" id="captcha-hash" name="captcha_hash" value="{{ $captcha_hash }}">
                                        <input type="text" name="captcha" class="form-control" placeholder="Hasil" maxlength="3" style="max-width:90px;">
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-send w-100"><i class="bi bi-send me-2"></i>Kirim Pesan</button>
                                </div>
                                <div class="col-12">
                                    <small style="color:var(--text-mid);"><i class="bi bi-shield-lock me-1"></i>Data Anda dilindungi dan tidak akan dibagikan kepada pihak ketiga.</small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h5 style="font-family:'Playfair Display',serif;"><i class="bi bi-shield-check me-2"></i>OIMS</h5>
                    <p style="color:rgba(255,255,255,.6);line-height:1.75;margin-bottom:1.2rem;">Organisasi Industri Militer Saudi — pilar pertahanan nasional Arab Saudi yang didirikan pada tahun 2014 untuk mewujudkan kemandirian industri pertahanan sepenuhnya.</p>
                    <div class="footer-social">
                        <a href="#" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Navigasi</h6>
                    <ul class="list-unstyled" style="line-height:2;">
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        <li><a href="#proyek">Proyek</a></li>
                        <li><a href="#visi">Visi &amp; Misi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Informasi</h6>
                    <ul class="list-unstyled" style="line-height:2;">
                        <li><a href="#visi">Visi &amp; Misi</a></li>
                        <li><a href="#pengembangan">Sejarah &amp; Catatan</a></li>
                        <li><a href="#tim">Tim Kami</a></li>
                        <li><a href="#kontak">Hubungi Kami</a></li>
                        <li><a href="/privacy">Kebijakan Privasi</a></li>
                        <li><a href="/legal-notice">Catatan Hukum</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Catatan &amp; Visi</h6>
                    <ul class="list-unstyled" style="line-height:2;">
                        <li><a href="#visi">Pedoman Visi</a></li>
                        <li><a href="#pengembangan">Catatan Pembuat</a></li>
                        <li><a href="#keunggulan">Peta Emosi</a></li>
                        <li><a href="#about">Resume Nilai</a></li>
                        <li><a href="#kontak">Kontak Darurat</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color:rgba(255,255,255,.1);">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="mb-0" style="color:rgba(255,255,255,.45);font-size:.85rem;">&copy; {{ date('Y') }} Organisasi Industri Militer Saudi. Hak Cipta Dilindungi.</p>
                <div style="color:rgba(255,255,255,.4);font-size:.8rem;">Made with <i class="bi bi-heart-fill" style="color:var(--gold-500);"></i> in Riyadh</div>
            </div>
            <div class="text-end mt-3">
                <a href="#admin-login" id="admin-link" style="color:rgba(212,168,67,.3);font-size:.78rem;transition:color .2s;" onmouseover="this.style.color='rgba(212,168,67,.8)'" onmouseout="this.style.color='rgba(212,168,67,.3)'">Admin ▸</a>
            </div>
        </div>
    </footer>

    @if(app('env') === 'local' || config('app.debug'))
    <div class="dev-badge"><i class="bi bi-bug-fill me-1"></i> DEV — {{ config('app.name','OIMS') }}</div>
    @endif

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
            try { const r = await fetch('{{ route("contact.captcha") }}'); const d = await r.json(); document.getElementById('captcha-question').textContent = d.question + ' = ?'; document.getElementById('captcha-hash').value = d.hash; } catch(_){}
        }
        refreshCaptcha();

        // Admin login modal toggle
        document.getElementById('admin-link').addEventListener('click', function(e) {
            e.preventDefault();
            const mx = document.getElementById('admin-login');
            if (mx.style.visibility === 'hidden') { mx.style.opacity='0'; mx.style.visibility='visible'; requestAnimationFrame(()=>requestAnimationFrame(()=>{ mx.style.opacity='1'; })); }
            else { mx.style.opacity='0'; setTimeout(()=>{ mx.style.visibility='hidden'; }, 500); }
        });
    </script>

    @include('legal.notice')
    @include('legal.privacy')

</body>
</html>
