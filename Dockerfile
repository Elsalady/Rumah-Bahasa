# ============================================
# Dockerfile — Rumah Bahasa Surabaya (Laravel)
# Dipakai Render (runtime: docker) + bisa dipakai lokal
# ============================================

# ---------- STAGE 1: Composer ----------
FROM composer:2 AS composer-stage
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist

# ---------- STAGE 2: Build frontend assets (Vite + Tailwind) ----------
FROM node:20-alpine AS node-stage
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---------- STAGE 3: Build app ----------
FROM php:8.3-fpm AS app-stage
WORKDIR /app

# Install ekstensi yang dibutuhkan Laravel + PostgreSQL
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libzip-dev \
        unzip \
        nginx \
        gettext-base \
        git \
        curl \
    && docker-php-ext-install pdo_pgsql pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && rm -f /etc/nginx/sites-enabled/default

# Salin composer dari stage 1
COPY --from=composer-stage /app/vendor /app/vendor

# Salin kode aplikasi
COPY . /app

# Salin hasil build asset (CSS/JS) dari stage node
COPY --from=node-stage /app/public/build /app/public/build

# Konfigurasi Nginx (Laravel entry: public/index.php)
COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf

# Entrypoint: migrasi + envsubst port + start PHP-FPM & Nginx
# Pakai ENTRYPOINT (bukan CMD) biar Start Command Railway tidak bisa meng-override
COPY .docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Storage link & cache — set ownership ke www-data biar PHP-FPM bisa nulis
RUN mkdir -p /app/storage/framework/{cache,sessions,views} \
    && rm -rf /app/storage/framework/views/* \
    && php artisan view:clear || true \
    && php artisan config:clear || true \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache \
    && php artisan storage:link || true

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]