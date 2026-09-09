#!/bin/sh
set -e

echo ">>> Clearing Laravel caches..."
rm -rf storage/framework/views/*.php 2>/dev/null || true
php artisan optimize:clear || true

echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

echo ">>> Cek isi database (diagnostik)..." 
php artisan tinker --execute="
echo 'users: ' . \App\Models\User::count() . PHP_EOL;
echo 'jadwal_kelas: ' . \App\Models\JadwalKelas::count() . PHP_EOL;
echo 'pendaftaran: ' . \App\Models\Pendaftaran::count() . PHP_EOL;
echo 'layanan: ' . \App\Models\Layanan::count() . PHP_EOL;
" || true

echo ">>> Backfill umur & rentang_usia dari tanggal_lahir (jika kosong)..." 
php artisan tinker --execute="
\$updated = 0;
foreach (\App\Models\User::whereNotNull('tanggal_lahir')->get() as \$u) {
    \$umur = \Carbon\Carbon::parse(\$u->tanggal_lahir)->age;
    \$kategori = \App\Models\User::kategoriUsia(\$u->tanggal_lahir);
    if (\$u->umur !== \$umur || \$u->rentang_usia !== \$kategori) {
        \$u->update(['umur' => \$umur, 'rentang_usia' => \$kategori]);
        \$updated++;
    }
}
echo 'Backfill umur/rentang_usia: ' . \$updated . ' member.' . PHP_EOL;
" || true

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

echo ">>> Menghapus ikon program kelas (tampilan bersih tanpa ikon)..."
php artisan tinker --execute="
\$n = \App\Models\Layanan::whereNotNull('ikon')->update(['ikon' => null]);
echo 'Ikon dihapus: ' . \$n . ' program.' . PHP_EOL;
" || true

echo ">>> Starting PHP-FPM..."
php-fpm -D

echo ">>> Konfigurasi port nginx (PORT=${PORT:-8080})..."
export NGINX_PORT="${PORT:-8080}"
envsubst '${NGINX_PORT}' < /etc/nginx/conf.d/default.conf > /tmp/nginx-default.conf
cp /tmp/nginx-default.conf /etc/nginx/conf.d/default.conf

echo ">>> Starting nginx on port ${NGINX_PORT}..."
nginx -g 'daemon off;'
