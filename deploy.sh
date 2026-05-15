#!/bin/bash
# Laravel 11.51 Deployment Script for cPanel
# Run: bash deploy.sh

set -e

echo "=========================================="
echo "  Laravel 11.51 Deployment - Sixer0.devlp"
echo "=========================================="
echo ""

cd /public_html/devlp/ || { echo "ERROR: Cannot cd to /public_html/devlp/"; exit 1; }

# 1. PHP Version Check
echo "[1/7] Checking PHP version..."
php -v
echo ""

# 2. Install Composer
echo "[2/7] Installing Composer (if needed)..."
if ! command -v composer &> /dev/null; then
    echo "  Composer not found, installing..."
    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer 2>/dev/null || echo "  Composer installed locally as composer.phar"
else
    echo "  Composer already installed: $(composer --version)"
fi
echo ""

# 3. Install Dependencies
echo "[3/7] Installing Laravel dependencies..."
php composer.phar install --no-dev --optimize-autoloader --no-interaction --prefer-dist
echo ""

# 4. Generate APP_KEY
echo "[4/7] Generating APP_KEY..."
php artisan key:generate --force
echo ""

# 5. Migrations
echo "[5/7] Running migrations..."
php artisan migrate --force
echo ""

# 6. Seeders
echo "[6/7] Seeding projects..."
php artisan db:seed --class=ProjectSeeder --force
echo ""

# 7. Cache Clear
echo "[7/7] Clearing caches..."
php artisan view:clear
php artisan cache:clear
php artisan route:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
echo ""

echo "=========================================="
echo "  ✅ Deployment Complete!"
echo "=========================================="
echo ""
echo "PHP:      $(php -v | head -1)"
echo "Laravel:  $(php artisan --version)"
echo "DB:       $(grep DB_DATABASE .env | cut -d= -f2)"
echo "URL:      http://devlp.sixer0-bk.my.id"
echo ""
echo "Routes:"
php artisan route:list --columns=uri
