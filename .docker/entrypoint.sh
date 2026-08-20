#!/bin/sh
set -e

echo ">>> Clearing Laravel caches..."
rm -rf storage/framework/views/*.php 2>/dev/null || true
php artisan optimize:clear || true

echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

echo ">>> Seeding initial data (idempotent)..."
php artisan db:seed --force --no-interaction || true

echo ">>> Starting PHP-FPM..."
php-fpm -D

echo ">>> Starting nginx..."
nginx -g 'daemon off;'
