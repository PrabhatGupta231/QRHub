#!/bin/sh
set -e

# Wait for MySQL connection to boot
echo "Checking database connection..."
until mysqladmin ping -h"$DB_HOST" --silent; do
    echo "Database server is unavailable - sleeping..."
    sleep 2
done

echo "Database connection is active!"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database
echo "Running seeders..."
php artisan db:seed --force

# Create storage symlink
echo "Creating storage symlink..."
php artisan storage:link

# Cache config, routes, and views for production performance
echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute CMD (which is php-fpm)
exec "$@"
