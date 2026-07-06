# 📘 Panduan Pengembangan Website Rumah Bahasa Surabaya

> Dibuat untuk: Dinas Perpustakaan dan Kearsipan Kota Surabaya
> Stack: **Laravel 12 + PostgreSQL + Tailwind CSS v4**
> Tujuan: Website profil & informasi Rumah Bahasa Surabaya yang muncul di pencarian Google

---

## 📌 Daftar Isi

1. [Apa itu Rumah Bahasa Surabaya?](#-1-apa-itu-rumah-bahasa-surabaya)
2. [Persiapan Lingkungan Development](#-2-persiapan-lingkungan-development)
3. [Ganti Database ke PostgreSQL](#-3-ganti-database-ke-postgresql)
4. [Struktur Halaman Website](#-4-struktur-halaman-website)
5. [Desain & Tampilan](#-5-desain--tampilan)
6. [Bikin Database (Migration)](#-6-bikin-database-migration)
7. [Bikin Halaman (Route + Controller + View)](#-7-bikin-halaman-route--controller--view)
8. [SEO Biar Muncul di Google](#-8-seo-biar-muncul-di-google)
9. [Admin Panel (Kelola Konten)](#-9-admin-panel-kelola-konten)
10. [Deployment ke Production](#-10-deployment-ke-production)
11. [Ceklis Final](#-11-ceklis-final)

---

## 🧭 1. Apa itu Rumah Bahasa Surabaya?

Rumah Bahasa Surabaya adalah **program/kegiatan di bawah Dinas Perpustakaan dan Kearsipan Kota Surabaya** yang berfokus pada pengembangan literasi kebahasaan — bisa berupa:

- **Perpustakaan mini / pojok baca**
- **Kelas literasi & bahasa asing**
- **Lomba bercerita, menulis, dll**
- **Pelestarian bahasa daerah (Jawa Suroboyoan)**
- **Pojok literasi digital**

> **Catatan penting:** Tanyakan ke pembimbing atau pimpinanmu untuk konten detail yang akurat.

---

## ⚙️ 2. Persiapan Lingkungan Development

### Yang harus sudah terinstall:

| Software | Versi Minimal | Cek Install |
|----------|--------------|-------------|
| PHP | 8.2+ | `php -v` |
| Composer | 2.x | `composer -v` |
| Node.js | 18+ | `node -v` |
| PostgreSQL | 15+ | `psql --version` |
| Git | any | `git --version` |

### Clone & install project:

```bash
cd C:\rumah-bahasa
composer install
npm install
```

### Generate app key (coba dulu):

```bash
php artisan key:generate
```

### Jalanin dev server (cek apakah Laravel berjalan):

```bash
php artisan serve
```

Buka `http://localhost:8000` — harusnya muncul halaman Laravel default.

> **Tips:** Biarkan `php artisan serve` jalan di satu terminal, buka terminal baru untuk perintah lainnya.

---

## 🐘 3. Ganti Database ke PostgreSQL

### 3.1. Buat database di PostgreSQL

Buka `psql` atau pakai **pgAdmin**:

```sql
CREATE DATABASE rumah_bahasa;
CREATE USER rumah_bahasa_user WITH PASSWORD 'password123';
GRANT ALL PRIVILEGES ON DATABASE rumah_bahasa TO rumah_bahasa_user;
```

### 3.2. Update file `.env`

Ubah bagian database di `.env` menjadi:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rumah_bahasa
DB_USERNAME=rumah_bahasa_user
DB_PASSWORD=password123
```

> **Keamanan:** Jangan pake password di atas ini di production! Ganti dengan password yang aman.

### 3.3. Uncomment driver PostgreSQL di `config/database.php`

Buka `config/database.php`, cari bagian ini dan pastikan **tidak dikomentari**:

```php
'pgsql' => [
    'driver' => 'pgsql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => 'prefer',
],
```

### 3.4. Test koneksi

```bash
php artisan migrate
```

Kalau sukses tanpa error, berarti koneksi PostgreSQL sudah jalan ✅

---

## 🏗️ 4. Struktur Halaman Website

Berdasarkan website umum milik pemerintah, halaman yang wajib ada:

| No | Halaman | Slug | Fungsi |
|----|---------|------|--------|
| 1 | **Beranda** | `/` | Sambutan, highlight kegiatan, slider |
| 2 | **Profil** | `/profil` | Visi, misi, sejarah Rumah Bahasa |
| 3 | **Layanan** | `/layanan` | Daftar program/layanan yang tersedia |
| 4 | **Berita / Kegiatan** | `/berita` | Artikel kegiatan Rumah Bahasa |
| 5 | **Detail Berita** | `/berita/{slug}` | Isi lengkap artikel |
| 6 | **Galeri** | `/galeri` | Foto & video kegiatan |
| 7 | **Kontak** | `/kontak` | Alamat, maps, form pesan |
| 8 | **Dashboard Admin** | `/admin` | Kelola konten website |

---

## 🎨 5. Desain & Tampilan

### Palet Warna (soft & nyaman di mata)

| Warna | Kode Hex | Penggunaan |
|-------|----------|------------|
| Putih bersih | `#FFFFFF` | Background utama |
| Biru soft | `#E8F4F8` | Background section alternatif |
| Hijau kalem | `#F0F7F0` | Background aksen lainnya |
| Biru tua | `#1A56DB` | Tombol, link, header |
| Hijau tosca | `#0E9F6E` | Aksen, badge |
| Abu terang | `#F3F4F6` | Card background |
| Abu teks | `#4B5563` | Teks paragraf |
| Hitam soft | `#111827` | Judul / heading |

> **Tips:** Warna-warna di atas punya kontras tinggi untuk aksesibilitas tapi ngga nyilauin. Hindari warna neon atau terlalu cerah.

### Font

Untuk website pemerintah, pilih font yang profesional dan mudah dibaca. Di Tailwind v4, font dikonfigurasi di `resources/css/app.css`:

```css
/* Ganti dengan font yang sesuai */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

@theme {
    --font-sans: 'Inter', 'Plus Jakarta Sans', sans-serif;
    --font-heading: 'Plus Jakarta Sans', sans-serif;
}
```

**Rekomendasi font alternatif:**
- **Inter** — profesional, banyak dipakai website pemerintah
- **Plus Jakarta Sans** — modern dan friendly
- **Merriweather** (untuk artikel/berita aja)

### Struktur Layout Halaman

Setiap halaman menggunakan struktur layout yang konsisten:

```
┌──────────────────────────────┐
│          HEADER              │
│  [Logo]  Nav: Beranda Profil │
│          Layanan Berita       │
├──────────────────────────────┤
│                              │
│      KONTEN UTAMA            │
│      (per halaman)           │
│                              │
├──────────────────────────────┤
│          FOOTER              │
│  Alamat | Sosmed | Kontak   │
│  © Dispusip Surabaya 2025   │
└──────────────────────────────┘
```

---

## 🗄️ 6. Bikin Database (Migration)

### 6.1. Migration untuk tabel-tabel yang dibutuhkan

Jalankan perintah berikut satu per satu:

```bash
# Tabel profil (visi, misi, sejarah)
php artisan make:migration create_profil_table

# Tabel layanan
php artisan make:migration create_layanan_table

# Tabel berita/kegiatan
php artisan make:migration create_berita_table

# Tabel galeri
php artisan make:migration create_galeri_table

# Tabel kontak/pesan masuk
php artisan make:migration create_kontak_table

# Tabel pengaturan website
php artisan make:migration create_pengaturan_table
```

### 6.2. Struktur tiap tabel

Edit file migration yang baru dibuat di `database/migrations/`.

#### `create_profil_table.php`

```php
Schema::create('profil', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->text('deskripsi');
    $table->string('gambar')->nullable();
    $table->enum('kategori', ['sejarah', 'visi_misi', 'tugas_fungsi', 'struktur']);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### `create_berita_table.php`

```php
Schema::create('berita', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->string('slug')->unique();
    $table->text('ringkasan')->nullable();
    $table->text('isi');
    $table->string('gambar')->nullable();
    $table->string('penulis')->nullable();
    $table->date('tanggal');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### `create_layanan_table.php`

```php
Schema::create('layanan', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->text('deskripsi');
    $table->string('ikon')->nullable();   // Nama ikon Font Awesome / SVG
    $table->string('gambar')->nullable();
    $table->integer('urutan')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### `create_galeri_table.php`

```php
Schema::create('galeri', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->string('gambar');
    $table->text('deskripsi')->nullable();
    $table->enum('kategori', ['foto', 'video']);
    $table->date('tanggal')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### `create_kontak_table.php`

```php
Schema::create('kontak', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('email');
    $table->string('subjek')->nullable();
    $table->text('pesan');
    $table->boolean('sudah_dibaca')->default(false);
    $table->timestamps();
});
```

### 6.3. Jalankan migrasi

```bash
php artisan migrate
```

---

## 🧩 7. Bikin Halaman (Route + Controller + View)

### 7.1. Struktur file yang perlu dibuat

```
routes/
  └── web.php              → Daftar semua route

app/Http/Controllers/
  ├── HomeController.php       → Halaman beranda
  ├── ProfilController.php     → Halaman profil
  ├── LayananController.php    → Halaman layanan
  ├── BeritaController.php     → Halaman berita & detail
  ├── GaleriController.php     → Halaman galeri
  └── KontakController.php     → Halaman kontak & kirim pesan

resources/views/
  ├── layouts/
  │   ├── app.blade.php        → Layout utama (header + footer)
  │   └── admin.blade.php      → Layout admin panel
  ├── home/
  │   └── index.blade.php      → Halaman beranda
  ├── profil/
  │   └── index.blade.php      → Halaman profil
  ├── layanan/
  │   └── index.blade.php      → Halaman layanan
  ├── berita/
  │   ├── index.blade.php      → Daftar berita
  │   └── show.blade.php       → Detail berita
  ├── galeri/
  │   └── index.blade.php      → Halaman galeri
  └── kontak/
      └── index.blade.php      → Halaman kontak
```

### 7.2. Bikin Controllers

Generate semua controller sekaligus:

```bash
php artisan make:controller HomeController
php artisan make:controller ProfilController
php artisan make:controller LayananController
php artisan make:controller BeritaController --resource
php artisan make:controller GaleriController
php artisan make:controller KontakController
```

### 7.3. Bikin Views

Buat folder di `resources/views/`:

```bash
mkdir -p resources/views/layouts
mkdir -p resources/views/home
mkdir -p resources/views/profil
mkdir -p resources/views/layanan
mkdir -p resources/views/berita
mkdir -p resources/views/galeri
mkdir -p resources/views/kontak
```

### 7.4. Route untuk halaman publik

Di `routes/web.php`:

```php
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'kirim'])->name('kontak.kirim');
```

---

## 🔍 8. SEO Biar Muncul di Google

Website pemerintah harus **SEO-friendly** supaya muncul di pencarian. Langkah-langkahnya:

### 8.1. Meta tags di layout

Di `resources/views/layouts/app.blade.php`, di dalam `<head>`:

```html
<!-- Primary Meta Tags -->
<title>@yield('title', 'Rumah Bahasa Surabaya - Dinas Perpustakaan dan Kearsipan Kota Surabaya')</title>
<meta name="title" content="@yield('title', 'Rumah Bahasa Surabaya')">
<meta name="description" content="@yield('description', 'Rumah Bahasa Surabaya — program literasi bahasa di Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
<meta name="keywords" content="rumah bahasa surabaya, perpustakaan surabaya, kearsipan surabaya, literasi surabaya, bahasa jawa surabaya">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
<meta property="og:description" content="@yield('description', 'Rumah Bahasa Surabaya — program literasi bahasa.')">
<meta property="og:image" content="@yield('image', asset('images/og-default.jpg'))">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
<meta property="twitter:description" content="@yield('description', 'Rumah Bahasa Surabaya')">
<meta property="twitter:image" content="@yield('image', asset('images/og-default.jpg'))">
```

### 8.2. Google Search Console & Sitemap

Pasang packagenya:

```bash
composer require spatie/laravel-sitemap
```

Buat sitemap:

```bash
php artisan make:sitemap
```

Aktifkan fitur sitemap di route atau jadwalkan.

### 8.3. Pastikan setiap halaman punya meta title unik

Di setiap view, kasih:

```blade
@extends('layouts.app')

@section('title', 'Profil - Rumah Bahasa Surabaya')
@section('description', 'Profil lengkap Rumah Bahasa Surabaya, visi misi, sejarah, dan struktur organisasi.')
```

### 8.4. Google Analytics (opsional)

Kalau diminta pasang tracking, daftar di Google Analytics lalu tambahkan kode tracking ke `<head>` di layout.

---

## 🔐 9. Admin Panel (Kelola Konten)

### 9.1. Pakai Laravel Breeze (authentication)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

Ini akan bikin:
- Halaman login & register
- Middleware auth
- Dashboard admin

### 9.2. Bikin route admin

Di `routes/web.php`, tambah:

```php
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('berita', AdminBeritaController::class);
    Route::resource('layanan', AdminLayananController::class);
    Route::resource('galeri', AdminGaleriController::class);
    Route::resource('profil', AdminProfilController::class);
    Route::get('kontak-masuk', [AdminKontakController::class, 'index'])->name('admin.kontak');
});
```

### 9.3. Bikin admin controllers

```bash
php artisan make:controller AdminController
php artisan make:controller AdminBeritaController --resource
php artisan make:controller AdminLayananController --resource
php artisan make:controller AdminGaleriController --resource
php artisan make:controller AdminProfilController --resource
php artisan make:controller AdminKontakController
```

### 9.4. Fitur CRUD di admin panel minimal:

- **Berita:** Tambah, edit, hapus, upload gambar
- **Layanan:** Atur urutan tampilan
- **Galeri:** Upload foto/video
- **Profil:** Edit teks profil
- **Kontak Masuk:** Lihat pesan dari pengunjung

---

## 🚀 10. Deployment ke Production

### 10.1. Siapkan production server

| Layanan | Cocok Untuk |
|---------|-------------|
| **VPS** (DigitalOcean, Linode, Vultr) | Production serius |
| **Hosting biasa** (Niagahoster, IDCloudHost) | Budget minimal |
| **Railway / Render** | Prototype / testing |

Persyaratan server:
- PHP 8.2+
- PostgreSQL 15+
- Composer
- Node.js & NPM
- Nginx / Apache

### 10.2. Langkah deployment

```bash
# 1. Clone repo di server
git clone https://github.com/... rumah-bahasa
cd rumah-bahasa

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate
# Edit .env — isi database production

# 4. Migrate database
php artisan migrate --force

# 5. Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set permission
chmod -R 775 storage bootstrap/cache
```

### 10.3. Setup Nginx

```
server {
    listen 80;
    server_name rumah-bahasa-surabaya.go.id;
    root /var/www/rumah-bahasa/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## ✅ 11. Ceklis Final

Sebelum website dinyatakan selesai, pastikan semua di bawah ini sudah:

### Fungsional
- [ ] Semua halaman bisa diakses (tidak 404)
- [ ] Form kontak bisa mengirim pesan
- [ ] Admin bisa login & logout
- [ ] Admin bisa CRUD berita
- [ ] Admin bisa CRUD layanan
- [ ] Admin bisa upload galeri
- [ ] Upload gambar berfungsi
- [ ] Database PostgreSQL terkoneksi

### Tampilan & UX
- [ ] Tampilan responsif di HP, tablet, desktop
- [ ] Warna soft dan nyaman dilihat
- [ ] Loading tidak lambat
- [ ] Navigasi mudah dipahami
- [ ] Footer lengkap (alamat, kontak, medsos)

### SEO
- [ ] Setiap halaman punya title & description unik
- [ ] Sitemap.xml terpasang
- [ ] Google Search Console terdaftar
- [ ] robots.txt sudah benar
- [ ] URL menggunakan slug (bukan ID)

### Keamanan
- [ ] CSRF protection aktif (default Laravel)
- [ ] SQL injection aman (pakai Eloquent)
- [ ] XSS protection (pakai Blade {{ }})
- [ ] Halaman admin hanya bisa diakses yang punya akun
- [ ] .env ngga ikut ke git

### Sebelum diserahkan
- [ ] Semua konten sudah diisi (bukan dummy/lorem ipsum)
- [ ] Logo & gambar sudah final
- [ ] Domain sudah siap
- [ ] SSL/HTTPS sudah aktif
- [ ] Backup database sudah diatur

---

## 🛠️ Command Cepat (Cheat Sheet)

```bash
# Dev server
php artisan serve

# Buat file baru
php artisan make:controller NamaController
php artisan make:model NamaModel -m
php artisan make:migration create_nama_table

# Database
php artisan migrate
php artisan migrate:fresh
php artisan db:seed

# Build frontend
npm run build
npm run dev
```

---

## 💡 Tips Tambahan

1. **Commit often:** Setiap selesai bikin fitur, `git add .` lalu `git commit`
2. **Backup database:** Sebelum `migrate:fresh`, backup dulu
3. **Test di HP:** Fitur "Toggle Device Toolbar" di Chrome DevTools (F12)
4. **Kalau stuck:** Google error message atau tanya ChatGPT — jangan malu
5. **Diskusi dengan pembimbing:** Pastikan konten, warna, dan logo sesuai keinginan dinas

---

Selamat ngoding! 🚀 Kalau ada yang bingung tinggal tanya aja.
