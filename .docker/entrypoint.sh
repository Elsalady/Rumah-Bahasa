#!/bin/sh
set -e

echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

echo ">>> Configuring nginx port..."
export PORT="${PORT:-80}"
envsubst '$PORT' < /etc/nginx/conf.d/default.conf > /tmp/nginx.conf
mv /tmp/nginx.conf /etc/nginx/conf.d/default.conf

echo ">>> Starting PHP-FPM..."
php-fpm -D

echo ">>> Starting nginx on port $PORT..."
nginx -g 'daemon off;'
