# Rumah Bahasa Surabaya

Website profil & pendaftaran program **Rumah Bahasa Surabaya** — program literasi dan pembelajaran bahasa di bawah Dinas Perpustakaan dan Kearsipan Kota Surabaya.

## Teknologi

- **Laravel 12** (PHP 8.2+)
- **PostgreSQL** 15+
- **Tailwind CSS v4** (via Vite)
- MySQL / SQLite juga didukung via konfigurasi `.env`

## Fitur

### Publik
- Beranda dengan hero slider, lingkup pelatihan, dan berita terkini
- Profil (sejarah, visi misi, tugas & fungsi, gambaran umum, sasaran)
- Daftar program & kelas bahasa, detail per program
- Jadwal kelas mingguan
- Berita & detail berita
- Form kontak (pesan masuk tersimpan + notifikasi email ke admin)
- Sitemap.xml & robots.txt untuk SEO

### Member
- Register dengan upload dokumen (KTP / Surat Domisili / KTM / KK)
- Persetujuan admin sebelum akun aktif
- Dashboard, edit profil, notifikasi
- Daftar program kelas (hanya bisa jika jadwal minggu ini tersedia)
- Jadwal kelas minggu ini

### Admin
- Dashboard statistik
- Kelola berita, profil, program, jadwal kelas (mingguan)
- Approve / reject member (dengan catatan)
- Lihat pendaftar program & export data member
- Kelola pesan kontak masuk

## Instalasi

```bash
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
# Edit .env — isi kredensial PostgreSQL

# Migrate & seed
php artisan migrate
php artisan db:seed

# Storage link (untuk upload gambar & dokumen)
php artisan storage:link

# Build assets
npm run build
```

## Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@rumahbahasa.com` | dari env `ADMIN_PASSWORD` (fallback: acak 16 karakter) |
| Member | `member@example.com` | `member123` |

> **Wajib** ganti password admin di production:
> ```bash
> php artisan admin:reset-password admin@rumahbahasa.com password-baru
> ```

## Perintah Penting

```bash
# Dev server
php artisan serve

# Reset jadwal kelas mingguan (otomatis tiap Minggu 00:00 via scheduler)
php artisan jadwal:reset-mingguan

# Reset password admin
php artisan admin:reset-password [email] [password]

# Scheduler (production) — tambahkan ke crontab:
# * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Panduan Lengkap

Lihat **[PANDUAN-DEVELOPMENT.md](PANDUAN-DEVELOPMENT.md)** untuk panduan pengembangan, struktur halaman, dan langkah deployment lengkap (Nginx, cron, keamanan).
