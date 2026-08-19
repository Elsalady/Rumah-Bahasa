#!/bin/sh
set -e

echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

echo ">>> Starting PHP-FPM..."
php-fpm -D

echo ">>> Starting nginx..."
nginx -g 'daemon off;'
