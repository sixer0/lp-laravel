<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sixer0 - Budi Kusharyanto') }}</title>
    <meta name="description" content="{{ config('app.description', 'Innovative software architecture for every industry.') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #2563eb;
            --color-dark: #1e293b;
            --color-light: #f8fafc;
            --color-text: #334155;
            --color-text-white: #ffffff;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--color-text);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--color-dark) !important;
        }
        
        .nav-link {
            color: var(--color-text) !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--color-primary) !important;
            background: rgba(37, 99, 235, 0.1);
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            border: none;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        }
        
        /* Section styling */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-dark);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto 3rem;
        }
        
        /* Value Cards */
        .value-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }
        
        .value-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        /* Project Cards */
        .project-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: white;
            height: 100%;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .project-card img {
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .project-card:hover img {
            transform: scale(1.05);
        }
        
        .project-title {
            font-weight: 700;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
        }
        
        .project-desc {
            color: #64748b;
            font-size: 0.95rem;
        }
        
        /* Contact Form */
        .contact-form {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--color-dark);
            margin-bottom: 0.5rem;
        }
        
        /* Footer */
        footer {
            background: var(--color-dark);
            color: var(--color-text-white);
            padding: 4rem 0 2rem;
        }
        
        footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: white;
        }
        
        .social-icons a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Dev Badge */
        .dev-badge {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #ef4444;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
            
            .navbar-collapse {
                background: white;
                padding: 1rem;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                margin-top: 1rem;
            }
            
            .contact-form {
                padding: 1.5rem;
            }
        }
        
        /* Scroll animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Bootstrap overrides */
        .text-primary-custom { color: var(--color-primary) !important; }
        .bg-primary-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .rounded-2xl { border-radius: 1rem; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-code-slash text-primary-custom me-2"></i>
                <span class="fw-bold">Sixer0</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">{{ __('Home') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('Values') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#innovation">Innovation</a></li>
                            <li><a class="dropdown-item" href="#integrity">Integrity</a></li>
                            <li><a class="dropdown-item" href="#impact">Impact</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('Services') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#services">Custom Software</a></li>
                            <li><a class="dropdown-item" href="#services">Consulting</a></li>
                            <li><a class="dropdown-item" href="#services">AI Solutions</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modules">Projects</a></li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary-custom text-white ms-2" href="#contact">Get In Touch</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section text-white">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-3">
                        Architecting Digital Solutions<br>
                        <span class="text-warning">Across Every Industry</span>
                    </h1>
                    <p class="lead mb-4" style="opacity: 0.9;">
                        Results-driven technology specialist with 18+ years of experience 
                        delivering business-critical systems, AI automation, web platforms, 
                        and IT transformation projects.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="https://wa.me/6281944335200" class="btn btn-light btn-lg px-4" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Get In Touch
                        </a>
                        <a href="#modules" class="btn btn-outline-light btn-lg px-4">
                            View Projects<i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://sixer0-bk.my.id/images/1024/25608161/Header2-8D4Ou_fknqe_nRavvqa-3w.png" 
                         alt="Budi Kusharyanto" class="img-fluid rounded-3 shadow-lg"
                         style="max-height: 400px; object-fit: contain;">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section id="values" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Hire Me?</h2>
                <p class="section-subtitle">Core principles that drive every project</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="value-card animate-on-scroll">
                        <div class="value-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Innovation</h4>
                        <p class="text-muted mb-0">
                            Pioneering creative solutions that challenge the status quo 
                            and deliver transformative results.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card animate-on-scroll">
                        <div class="value-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Integrity</h4>
                        <p class="text-muted mb-0">
                            Committed to transparency and honesty in all our dealings, 
                            building lasting partnerships.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card animate-on-scroll">
                        <div class="value-icon">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Impact</h4>
                        <p class="text-muted mb-0">
                            Delivering software that not only meets needs but 
                            transforms industries and businesses.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">My Services</h2>
                <p class="section-subtitle">Comprehensive solutions tailored to your needs</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card">
                        <div class="card-body p-4">
                            <div class="text-primary-custom mb-3" style="font-size: 2rem;">
                                <i class="bi bi-code-square"></i>
                            </div>
                            <h5 class="card-title fw-bold">Custom Software Development</h5>
                            <p class="card-text text-muted">
                                Building tailored software solutions from ERP systems to complex web applications.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card">
                        <div class="card-body p-4">
                            <div class="text-primary-custom mb-3" style="font-size: 2rem;">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <h5 class="card-title fw-bold">Consulting & Architecture</h5>
                            <p class="card-text text-muted">
                                System architecture design and technology consulting for enterprise-scale solutions.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card">
                        <div class="card-body p-4">
                            <div class="text-primary-custom mb-3" style="font-size: 2rem;">
                                <i class="bi bi-robot"></i>
                            </div>
                            <h5 class="card-title fw-bold">AI & Automation</h5>
                            <p class="card-text text-muted">
                                Smart automation solutions and AI-driven services for modern businesses.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card">
                        <div class="card-body p-4">
                            <div class="text-primary-custom mb-3" style="font-size: 2rem;">
                                <i class="bi bi-tools"></i>
                            </div>
                            <h5 class="card-title fw-bold">Maintenance & Support</h5>
                            <p class="card-text text-muted">
                                Ongoing application maintenance, bug fixes, and system optimization.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card">
                        <div class="card-body p-4">
                            <div class="text-primary-custom mb-3" style="font-size: 2rem;">
                                <i class="bi bi-globe"></i>
                            </div>
                            <h5 class="card-title fw-bold">Web Development</h5>
                            <p class="card-text text-muted">
                                Full-stack web development with modern frameworks and best practices.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card">
                        <div class="card-body p-4">
                            <div class="text-primary-custom mb-3" style="font-size: 2rem;">
                                <i class="bi bi-phone"></i>
                            </div>
                            <h5 class="card-title fw-bold">Mobile Development</h5>
                            <p class="card-text text-muted">
                                Cross-platform mobile app development for iOS and Android ecosystems.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial / History Section -->
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Project History</h2>
                <p class="section-subtitle">What clients say about working together</p>
            </div>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <div class="display-1 text-primary-custom mb-4">
                                    <i class="bi bi-quote"></i>
                                </div>
                                <h3 class="fw-bold mb-3">Exceptional Software Development Experience!</h3>
                                <p class="lead text-muted mb-4">
                                    "Working with Sixer0 was a game-changer for our project. 
                                    The technical expertise and innovative solutions delivered exceeded our expectations!"
                                </p>
                                <div class="text-primary-custom">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <div class="display-1 text-primary-custom mb-4">
                                    <i class="bi bi-quote"></i>
                                </div>
                                <h3 class="fw-bold mb-3">Transformed Our Business Processes!</h3>
                                <p class="lead text-muted mb-4">
                                    "Thanks to the tailored ERP system created by Budi, our workflow has improved 
                                    significantly. Highly recommended for any business looking to streamline operations."
                                </p>
                                <div class="text-primary-custom">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <div class="display-1 text-primary-custom mb-4">
                                    <i class="bi bi-quote"></i>
                                </div>
                                <h3 class="fw-bold mb-3">Innovative and Professional!</h3>
                                <p class="lead text-muted mb-4">
                                    "Budi's approach to software development is nothing short of inspiring. 
                                    The quality of work and attention to detail stands out in every project."
                                </p>
                                <div class="text-primary-custom">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Prev</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="modules" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Sample Projects</h2>
                <p class="section-subtitle">A selection of recent work</p>
            </div>
            <div class="row g-4">
                @foreach($projects as $project)
                <div class="col-lg-4 col-md-6">
                    <div class="project-card">
                        <div class="overflow-hidden">
                            <img src="{{ $project->image ?? '/images/default.jpg' }}" 
                                 class="card-img-top" alt="{{ $project->name }}">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold project-title">{{ $project->name }}</h5>
                            <p class="card-text text-muted project-desc">
                                {{ Str::limit($project->description ?? 'No description available.', 100) }}
                            </p>
                            <a href="{{ route('project', $project->slug) }}" class="btn btn-outline-primary btn-sm">
                                View Project <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary-custom text-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center mx-auto">
                    <h2 class="display-5 fw-bold mb-3">Ready to Elevate Your Project?</h2>
                    <p class="lead mb-4" style="opacity: 0.9;">
                        Let's build something great together!
                    </p>
                    <a href="https://wa.me/6281944335200" class="btn btn-light btn-lg px-5" target="_blank">
                        <i class="bi bi-chat-dots me-2"></i>Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact" class="py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h2 class="section-title">Get In Touch!</h2>
                        <p class="section-subtitle">Have a project in mind? Let's discuss!</p>
                    </div>
                    <div class="contact-form">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Please fix the errors below.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company" class="form-label">Company <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('company') is-invalid @enderror" 
                                           id="company" name="company" 
                                           value="{{ old('company') }}" required>
                                    @error('company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name"
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone"
                                           value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email"
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="5"
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="privacy" name="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        I have read and agree to the <a href="/privacy" class="text-primary">Privacy Policy</a>.
                                    </label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center">
                                    <span class="text-muted me-2" id="captcha-question">{{ $captcha_question ?? '5 + 3' }}</span>
                                    <input type="text" name="captcha" class="form-control w-auto" 
                                           placeholder="Your answer" style="width: 150px;" required>
                                    <input type="hidden" name="captcha_hash" id="captcha-hash" value="{{ $captcha_hash ?? md5(8) }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3">
                        <i class="bi bi-code-slash me-2"></i>Sixer0
                    </h4>
                    <p class="text-white-50">
                        IT Expert, 18+ Years of experience, specializes in innovative software solutions 
                        across industries. Providing robust systems for businesses and AI Solution services.
                    </p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-3">Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Tangerang, Indonesia</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i>+62 819 4433 5200</li>
                        <li><i class="bi bi-envelope me-2"></i>sixer0.bk@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-3">Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#values">Values</a></li>
                        <li class="mb-2"><a href="#services">Services</a></li>
                        <li class="mb-2"><a href="#modules">Projects</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Social Media</h5>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/" class="text-white" target="_blank" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://x.com/" class="text-white" target="_blank" title="X (Twitter)">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://www.instagram.com/" class="text-white" target="_blank" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/" class="text-white" target="_blank" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="https://github.com/" class="text-white" target="_blank" title="GitHub">
                            <i class="bi bi-github"></i>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="/legal-notice" class="text-white-50 me-3">Legal Notice</a>
                        <a href="/privacy" class="text-white-50">Privacy Policy</a>
                    </div>
                </div>
            </div>
            <hr class="my-4 text-white-50">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; {{ date('Y') }} Budi Kusharyanto. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS + jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#!next') return;
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu if open
                    const navbar = document.querySelector('.navbar-collapse');
                    if (navbar.classList.contains('show')) {
                        bootstrap.Collapse.getInstance(navbar).hide();
                    }
                }
            });
        });

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

        // Activate current nav link
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.scrollY >= sectionTop) current = section.getAttribute('id');
            });
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // captcha: fetch a fresh question from the server
        async function refreshCaptcha() {
            try {
                const r = await fetch('{{ route('contact.captcha') }}'); const d = await r.json();
                document.getElementById('captcha-question').textContent = d.question + ' = ?';
                document.getElementById('captcha-hash').value = d.hash;
            } catch (_) { /* keep defaults on error */ }
        }
        refreshCaptcha();
    </script>

    @if(app('env') === 'local' || config('app.debug'))
    <div class="dev-badge">
        <i class="bi bi-bug-fill me-1"></i> DEV ENVIRONMENT
    </div>
    @endif
</body>
</html>