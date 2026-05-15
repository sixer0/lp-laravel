# Laravel + Bootstrap Landing Page

## Stack
- **Laravel 12** - Framework PHP
- **Bootstrap 5.3** - CSS Framework
- **jQuery 3.7** - DOM manipulation
- **Bootstrap Icons** - Icon set

## Structure
```
landing-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   └── ContactController.php
│   │   └── Middleware/
│   ├── Models/
│   │   └── ContactSubmission.php
│   ├── Mail/
│   │   └── ContactNotification.php
│   └── Providers/
├── bootstrap/
│   └── app.php
├── config/
│   └── app.php
├── database/
│   └── migrations/
├── public/               # ← Web root
│   ├── index.php
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── modules-1/        # Sitejet XML
│   └── storage/          # Logs & cache
├── resources/views/
│   ├── layouts/
│   │   └── guest.blade.php
│   └── legal/
├── routes/
│   ├── web.php
│   └── console.php
├── storage/
│   └── logs/
├── .env.example
├── artisan
└── composer.json
```

## Requirement
- PHP >= 8.2
- MySQL / PostgreSQL / SQLite
- Composer 2.x

## Local Setup
```bash
cd landing-laravel

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database (SQLite for quick start)
touch database/database.sqlite

# Run migration
php artisan migrate

# Serve locally
php artisan serve --host=0.0.0.0 --port=8000
```

## Routes
| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Landing page |
| `/contact` | POST | Contact form submission |
| `/legal-notice` | GET | Legal notice page |
| `/privacy` | GET | Privacy policy |
| `/project/{slug}` | GET | Project detail page |

## Bootstrap 5 Features Used
- ↓ Responsive grid system (container → row → col-*)
- ↓ Navbar (fixed-top, collapse on mobile)
- ↓ Cards (project cards, value cards)
- ↓ Buttons (primary, outline, size variants)
- ↓ Forms (floating labels, validation styles)
- ↓ Carousel (testimonials)
- ↓ Utilities (text-color, bg-color, spacing)
- ↓ Icons (Bootstrap Icons)

## PHP Features
- Blade templating
- CSRF protection
- Form validation
- SQLite/MYSQL contact storage
- Environment detection
- Project auto-loading from Sitejet XML

## Deployment to cPanel
1. Upload `public/` → `/public_html/devlp/`
2. Upload `landing-laravel/` (everything except `public/`) → `/public_html/devlp/vendor/` 
   (Or: `composer install --no-dev --optimize-autoloader` on server via SSH/Terminal)
3. Update `.env` with live credentials
4. Run `php artisan migrate --force`

## Features vs HTML version
| Feature | Landing Page HTML | Laravel + Bootstrap |
|---------|-----------------|---------------------|
| Edit content | via FTP HTML | @yield/@include Blade |
| Contact form | None | ✅ Validation + DB |
| Project storage | Hardcoded | ✅ Eloquent DB |
| SEO | Static | ✅ Dynamic meta |
| Auth | None | ✅ Laravel内置 |
| Maintenance | Manual | ✅ `php artisan down` |
