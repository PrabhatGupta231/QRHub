#!/bin/sh
set -e

# ============================================================
# QRHub — Production Docker Entrypoint
# ============================================================

# Fix storage and cache permissions
echo "Setting permissions..."
mkdir -p /var/www/storage/logs \
         /var/www/storage/framework/sessions \
         /var/www/storage/framework/views \
         /var/www/storage/framework/cache/data \
         /var/www/storage/app/public \
         /var/www/bootstrap/cache

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache


# ============================================================
# Run Migrations (safe — skips already-run migrations)
# ============================================================
echo "Running migrations..."
php artisan migrate --force || true

# ============================================================
# Seed on FIRST SETUP only
# Set FIRST_SETUP=true in environment on initial deploy
# Never set it automatically — prevents data duplication
# ============================================================
if [ "${FIRST_SETUP}" = "true" ]; then
    echo "FIRST_SETUP=true: Running database seeders..."
    php artisan db:seed --force
    echo "Seeding complete."
else
    echo "Skipping seeders (set FIRST_SETUP=true to seed on next deploy)."
fi

# ============================================================
# Storage Symlink
# ============================================================
echo "Creating storage symlink..."
php artisan storage:link --force || true

# ============================================================
# Laravel Production Optimisations
# ============================================================
echo "Caching configuration, routes, views, events..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "Application is ready!"

# ============================================================
# Start PHP-FPM
# ============================================================
exec "$@"
