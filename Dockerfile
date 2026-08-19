# ============================================
# Dockerfile — Rumah Bahasa Surabaya (Laravel)
# Dipakai Render (runtime: docker) + bisa dipakai lokal
# ============================================

# ---------- STAGE 1: Composer ----------
FROM composer:2 AS composer-stage
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# ---------- STAGE 2: Build app ----------
FROM php:8.3-fpm AS app-stage
WORKDIR /app

# Install ekstensi yang dibutuhkan Laravel + PostgreSQL
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libzip-dev \
        unzip \
        nginx \
        git \
        curl \
    && docker-php-ext-install pdo_pgsql pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && rm -f /etc/nginx/sites-enabled/default

# Salin composer dari stage 1
COPY --from=composer-stage /app/vendor /app/vendor

# Salin kode aplikasi
COPY . /app

# Generate autoloader (karena tadi --no-autoloader)
RUN composer dump-autoload --optimize --no-dev

# Konfigurasi Nginx (Laravel entry: public/index.php)
COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf

# Storage link & cache
RUN mkdir -p /app/storage/framework/{cache,sessions,views} \
    && chmod -R 775 /app/storage /app/bootstrap/cache \
    && php artisan storage:link || true

EXPOSE 80

# Jalankan PHP-FPM + Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]