#!/bin/sh
set -e

echo ">>> Clearing Laravel caches..."
rm -rf storage/framework/views/*.php 2>/dev/null || true
php artisan optimize:clear || true

echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

echo ">>> Membersihkan data duplikat dari seed sebelumnya..."
php artisan tinker --execute="
\$dup = \App\Models\Profil::select('judul')->groupBy('judul')->havingRaw('COUNT(*) > 1')->pluck('judul');
foreach (\$dup as \$judul) {
    \$ids = \App\Models\Profil::where('judul', \$judul)->orderBy('id')->pluck('id');
    \App\Models\Profil::whereIn('id', \$ids->slice(1))->delete();
}
echo 'Duplikat profil dibersihkan: ' . \$dup->count() . ' judul.' . PHP_EOL;
" || true

echo ">>> Seeding initial data (hanya jika tabel layanan kosong)..."
php artisan tinker --execute="
if (\App\Models\Layanan::count() === 0) {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true, '--no-interaction' => true]);
    echo 'Seed selesai.' . PHP_EOL;
} else {
    echo 'Data sudah ada, seed dilewati.' . PHP_EOL;
}
" || true

echo ">>> Starting PHP-FPM..."
php-fpm -D

echo ">>> Starting nginx..."
nginx -g 'daemon off;'
