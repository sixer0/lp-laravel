# Laravel 11.51 + Bootstrap 5 Landing Page

**Last updated:** 2026-05-15 | **Compatible with:** Laravel 11.x

## 📦 Stack

| Component | Version | Notes |
|-----------|---------|-------|
| PHP | >= 8.1 | cPanel default (11.51) |
| Laravel | 11.51 | Latest available on server |
| Bootstrap | 5.3 | Via CDN (jsdelivr) |
| jQuery | 3.7 | Via CDN |
| Icons | Bootstrap Icons 1.11 | Via CDN |
| Database | SQLite (default) / MySQL | Automatic migration |

---

## 📁 Structure

```
lp-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── ContactController.php   # Form handler + validation
│   │   └── HomeController.php     # Landing + Project detail
│   ├── Http/Middleware/
│   │   └── TrustProxies.php       # cPanel load balancer support
│   ├── Mail/
│   │   └── ContactNotification.php
│   ├── Models/
│   │   ├── ContactSubmission.php  # DB model
│   │   └── Project.php           # Project model + XML loader
│   └── Providers/                 # App, Auth, Route
├── bootstrap/app.php              # Laravel 11 bootstrap
├── config/app.php                 # App config (timezone, locale, etc.)
├── database/
│   └── migrations/                # Schema
├── public/                        # ← Web root
│   ├── index.php                  # Laravel entry point
│   ├── .htaccess                  # Apache mod_rewrite
│   ├── css/ js/ images/           # Static assets
│   └── modules-1/                 # Sitejet XML collection
├── resources/views/
│   ├── layouts/guest.blade.php    # Main Bootstrap 5 layout
│   ├── legal/notice.blade.php     # Legal notice page
│   ├── legal/privacy.blade.php    # Privacy policy
│   └── emails/contact-notification.blade.php
├── routes/web.php                 # All routes
├── storage/logs/                  # visit.log + laravel.log
├── .env.example                   # Environment template
├── server.php                     # Laravel 11 entry
└── composer.json                  # Dependencies
```

---

## 🔧 Quick Setup

```bash
# 1. Clone / extract to server
cd landing.sixer0-bk.my.id/
tar xzf lp-laravel.tar.gz

# 2. Install dependencies (if SSH/Terminal available)
composer install --no-dev --optimize-autoloader

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Setup database
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=ProjectSeeder

# 5. Clear cache
php artisan view:clear
php artisan cache:clear
```

---

## 📋 Routes

| Route | Method | Description |
|-------|--------|-------------|
| `GET /` | Landing page | Bootstrap layout + Sitejet projects |
| `GET /project/{slug}` | Project detail | Individual project page |
| `POST /contact` | Form submit | Validation + DB + email |
| `GET /legal-notice` | Legal | Static legal page |
| `GET /privacy` | Privacy | Static privacy policy |
| `*` fallback | 404 | Custom error page |

---

## 🎨 Bootstrap 5 Components

| Section | Features |
|---------|----------|
| **Navbar** | Fixed-top, collapsible on mobile, dropdown |
| **Hero** | Gradient background, CTA buttons, responsive text |
| **Values** | 3-col card grid, hover animation |
| **Services** | 6 cards (icon + title + description) |
| **Testimonials** | Bootstrap carousel slider |
| **Projects** | Sitejet XML → Bootstrap cards, image lazy-load |
| **CTA Banner** | Full-width gradient, WhatsApp button |
| **Contact Form** | Floating-label form, CSRF, CAPTCHA, validation |
| **Footer** | 4-col responsive, social icons |
| **Animations** | IntersectionObserver scroll reveal |

---

## 🔌 Laravel 11 Highlights

```php
// Bootstrap.app.php uses ->configure() (⚠️ NOT 12 syntax)
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(...)
    ->withMiddleware(...)
    ->create();

// Config/app.php stores all app settings
// No separate config files for database/mail by default in this minimal install

// Only Web middleware group
Route::middleware('web')->group(...)

// TrustProxies for cPanel load balancer
$proxies = '*';
$headers = Request::HEADER_X_FORWARDED_ALL;
```

---

## 🔐 Security Notes

- ✅ CSRF tokens on all forms
- ✅ Input validation (length, type, required)
- ✅ CAPTCHA (math-based) to prevent spam
- ✅ SQL injection protected (Eloquent)
- ✅ XSS protected (Blade `{{ }}` escaping)
- ✅ Error pages hide stack traces in production

---

## 📊 Database Schema

```sql
-- Projects auto-loaded from Sitejet XML
projects: id | name | slug | description | image | hours_tag | price_tag | order | is_active | timestamps

-- Contact submissions
contact_submissions: id | company | name | phone | email | message | ip | user_agent | status | timestamps
```

---

## 🚀 Deploy to cPanel

### Prerequisites on Server
```bash
# Check PHP version
php -v  # Should show 8.1+

# Composer (install if missing)
curl -sS https://getcomposer.org/installer | php
```

### Full Deploy
```bash
cd landing.sixer0-bk.my.id/
tar xzf lp-laravel.tar.gz

# Install Composer deps
php composer.phar install --no-dev --optimize-autoloader

# Setup env
cp .env.example .env
php artisan key:generate

# Setup database
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=ProjectSeeder

# Permissions
chmod -R 775 storage bootstrap/cache
```

### Production Checklist
```bash
# 1. Set APP_DEBUG=false in .env
# 2. Generate optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
# 3. Enable OPcache in cPanel PHP settings
```

---

## 📝 Changelog

### v1.0 — 2026-05-15
- Laravel 11.51 + Bootstrap 5.3
- Landing page, contact form, legal pages
- Sitejet XML auto-loader for projects
- Email notifications + error logging

## 🌐 Environment Details

- **Current time:** 2026-05-18T12:10:07+07:00
- **Working directory:** D:\Portfolio\lp-laravel
- **Workspace root folder:** D:\Portfolio\lp-laravel
