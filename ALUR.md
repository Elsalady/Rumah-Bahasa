# 🗺️ Alur Website Rumah Bahasa Surabaya

Dokumentasi alur lengkap website **Rumah Bahasa Surabaya** untuk seluruh pengguna: **Pengunjung (Publik)**, **Member**, dan **Admin**.

Dibangun dengan: Laravel 12 (PHP 8.2+) · PostgreSQL · Tailwind CSS v4

---

## Daftar Isi

1. [Ringkasan 3 Peran](#1-ringkasan-3-peran)
2. [Alur Pengunjung (Publik)](#2-alur-pengunjung-publik)
3. [Alur Autentikasi (Login / Register)](#3-alur-autentikasi-login--register)
4. [Alur Member (Terdaftar & Terverifikasi)](#4-alur-member-terdaftar--terverifikasi)
5. [Alur Pendaftaran Program (Daftar Kelas)](#5-alur-pendaftaran-program-daftar-kelas)
6. [Alur Admin](#6-alur-admin)
7. [Alur Keseluruhan (End-to-End)](#7-alur-keseluruhan-end-to-end)
8. [Diagram Status Member & Pendaftaran](#8-diagram-status-member--pendaftaran)
9. [Alur Otomatis / Scheduler](#9-alur-otomatis--scheduler)
10. [Rute Utama (Route Map)](#10-rute-utama-route-map)
11. [Batasan Sistem Saat Ini](#11-batasan-sistem-saat-ini)

---

## 1. Ringkasan 3 Peran

| Peran | Siapa | Akses | Setelah Login ke |
|-------|-------|-------|------------------|
| **Pengunjung** (guest) | Semua orang tanpa login | Halaman publik + form kontak | — (tidak login) |
| **Member** | User yang terdaftar & disetujui admin | Dashboard member, daftar program, jadwal | `/member/dashboard` |
| **Admin** | Staff/pegawai Dispusip | Panel admin lengkap (CRUD konten, kelola member) | `/admin` |

Pemisahan role dipaksa oleh middleware:
- `member.auth` → wajib login **dan** role = `member` (`app/Http/Middleware/MemberAuth.php`)
- `admin.auth` → wajib login **dan** role = `admin` (`app/Http/Middleware/AdminAuth.php`)

---

## 2. Alur Pengunjung (Publik)

Siapa pun tanpa login bisa mengakses halaman publik berikut:

```
Beranda  (/)                       → hero slider, lingkup pelatihan, 3 berita terbaru
│
├── Profil  (/profil)              → sejarah, visi misi, tugas & fungsi, sasaran
│     └── /profil/{id}             → detail salah satu konten profil
│
├── Berita  (/berita)              → daftar semua berita, klik → detail
│     └── /berita/{slug}           → isi lengkap satu berita
│
├── Layanan  (/layanan)            → daftar program/kelas bahasa
│     └── /layanan/{nama}          → detail satu program
│
├── Jadwal  (/jadwal)              → jadwal kelas mingguan untuk umum
│
├── Tata Cara  (/tata-cara/{jenis?}) → panduan pendaftaran/administrasi
│
├── Kontak  (/kontak)              → info alamat + form kirim pesan
│     └── POST /kontak             → simpan pesan ke DB + notif email ke admin
│
├── Contoh Surat  (/contoh-surat-domisili) → contoh template surat domisili
│
└── Registrasi  (/register)        → mulai jadi member (lihat alur #3)
```

**Alur form kontak (pengunjung → admin):**

1. Pengunjung membuka `/kontak`.
2. Mengisi nama, email, subjek, pesan → klik kirim.
3. Data tersimpan di tabel `kontak` (status `sudah_dibaca = false`).
4. Notifikasi email dikirim ke admin (`MAIL_MAILER`; jika `log`, tertulis ke `storage/logs`).
5. Admin melihat pesan baru di panel Admin → **Kontak**, klik untuk menandai "sudah dibaca".

---

## 3. Alur Autentikasi (Login / Register)

### 3.1. Register (Calon Member)

```
/register
  │
  ├─ Isi form:
  │    nama, email (unik), password + konfirmasi, telepon, alamat,
  │    NIK (unik, wajib), tempat & tanggal lahir (wajib), jenis pekerjaan (wajib),
  │    foto profil (wajib),
  │    scan/foto KTP (WAJIB — kolom tersendiri),
  │    dokumen pendukung LAINNYA opsional (surat domisili / KTM / KK)
  │
  ├─ Validasi (AuthController@register):
  │    email.unique → "Email ini sudah terdaftar"
  │    nik.unique   → "NIK ini sudah terdaftar" (1 NIK = 1 akun, termasuk pending/rejected)
  │    tanggal_lahir otomatis hitung umur & rentang usia (di server)
  │    foto profil & KTP wajib, mimes:jpeg,png,jpg, max 2MB
  │
  ├─ Data disimpan ke users:
  │    role   = 'member'
  │    status = 'pending'      ← MENUNGGU PERSETUJUAN ADMIN
  │
  ├─ File upload → storage/public/member-dokumen
  │
  └─ Otomatis login → redirect ke /member/dashboard
```

> ⚠️ Setelah register, akun **masih `pending`**. Member belum bisa daftar program sampai admin menyetujui.

### 3.2. Login

```
/login  →  POST /login
  ├─ email + password
  ├─ berhasil + role admin  → redirect /admin
  ├─ berhasil + role member → redirect /member/dashboard
  └─ gagal → kembali ke /login dengan pesan error
```

### 3.3. Logout

`POST /logout` → hapus session → kembali ke `/`.

---

## 4. Alur Member (Terdaftar & Terverifikasi)

Semua rute member dibungkus middleware `['auth','member.auth']`.

```
/member/dashboard     → ringkasan akun, notifikasi terbaru, pendaftaran saya
/member/program       → daftar program aktif & program yang sudah didaftar
/member/program/{nama} → detail program + tombol daftar & jadwal tersedia
/member/jadwal        → jadwal kelas mingguan (dikelompokkan per hari)
/member/notifikasi    → daftar semua notifikasi
/member/notifikasi/{id} → tandai baca & arahkan ke link
/member/notifikasi/baca-semua → tandai semua sudah dibaca
/member/edit          → ubah profil (nama, telepon, alamat, password, foto, dokumen)
```

**Alur blokir akun belum disetujui:**

Di `PendaftaranController@index` dan `@store`:

```
if status user ≠ 'approved'  → redirect ke /member/dashboard
   dengan pesan: "Akun kamu belum diverifikasi. Silakan tunggu konfirmasi dari staff."
```

Jadi member `pending`/`rejected` tidak bisa mengakses `/pendaftaran` maupun halaman program → tetap di dashboard dengan peringatan.

**Berhasil login sebagai member `approved`:**

1. Dashboard menampilkan profil, notifikasi, dan daftar pendaftaran program saya.
2. Klik **Program** untuk melihat semua kelas.
3. Klik satu program → detail + jadwal tersedia → daftar (lihat alur #5).
4. Klik **Jadwal** untuk melihat jadwal minggu ini per hari.
5. Pendaftaran kelas **tentative** (1 pertemuan = 1 materi) otomatis dihapus saat masuk minggu/pertemuan baru (lihat alur #9).

---

## 5. Alur Pendaftaran Program (Daftar Kelas)

Alur ini yang penting — hasilnya muncul di panel Admin **Pendaftaran**.

```
/member/program/{nama}
  │
  ├─ Member memilih program & jadwal kelas
  │
  └─ POST /pendaftaran  (PendaftaranController@store)
      │
      ├─ [Blokir 1] Status member ≠ approved → redirect dashboard + pesan
      │
      ├─ [Cek] Program ada & aktif? Layanan::is_active
      │
      ├─ [Cek] Jadwal aktif? JadwalKelas::is_active
      │
├─ [Cek] Sudah pernah daftar jadwal ini?
       │        (status pending/confirmed, jadwal_id sama)
       │        → "Kamu sudah terdaftar di jadwal ini"
       │
       ├─ [Cek] Tanggal jadwal sudah lewat?
       │        tanggal < hari ini → ditolak
       │
       ├─ [Cek] BENTROK JADWAL by NIK
       │        NIK sama sudah punya pendaftaran confirmed
       │        pada tanggal & jam yang overlap
       │        (seseorang tidak boleh daftar 2 kelas bentrok)
       │
       ├─ [Cek] Kuota = 0?
       │        → buat Pendaftaran status = 'rejected'
       │          catatan = "Kuota kelas belum dibuka (0)."
       │
       ├─ [Cek] KUOTA kelas penuh?
       │        jumlah confirmed >= kuota jadwal
       │        → buat Pendaftaran status = 'rejected'
       │          catatan = "Kuota kelas sudah penuh."
       │        → pesan error, minta pilih jadwal lain / hubungi admin
       │
      └─ [Berhasil] Buat Pendaftaran:
             status  = 'confirmed'     ← LANGSUNG TERVERIFIKASI
             mode    = online/offline (dari jadwal)
             jadwal_id = jadwal terpilih
         → pesan sukses "✅ Kamu berhasil mendaftar!"
```

> ✅ Pendaftaran program memakai **konfirmasi instan** — begitu daftar langsung status `confirmed`, tidak perlu approve admin.
> ❌ Satu-satunya penolakan otomatis: ketika **kuota kelas sudah penuh**.
> Member bisa **membatalkan** pendaftaran yang masih `confirmed` via `DELETE /member/pendaftaran/{id}/batal`.

Data pendaftaran ini kemudian terkelola di panel Admin → **Pendaftaran** (lihat alur #6).

> ⚠️ Saat kuota penuh, member **ditolak**, bukan masuk antrean. Slot kosong akibat pembatalan
> bisa langsung diambil member lain yang daftar ulang, tapi tidak ada waiting list otomatis.
> Ini salah satu celah sistem yang direncanakan untuk dikembangkan dalam tugas akhir.

---

## 6. Alur Admin

Semua rute admin dibungkus middleware `['auth','admin.auth']` + prefix `/admin`.

### 6.1. Dashboard Admin (`/admin`)

Kartu statistik (9 angka, tanpa visualisasi):
- Total berita, total profil, jumlah jadwal kelas
- Pendaftar program: total, `pending`, `confirmed`
- Member: total, menunggu approval (`pending`), terverifikasi (`approved`)
- Pesan baru belum dibaca
- + daftar 5 pendaftar terbaru & 5 pesan terbaru

> Catatan: dashboard ini baru menampilkan **angka statis** — belum ada grafik distribusi usia,
> tren pendaftaran, maupun tingkat keterisian kelas. Visualisasi ini salah satu rencana
> pengembangan dalam tugas akhir.

### 6.2. Kelola Member (`/admin/member/kelola`)

Ini tempat **menyetujui akun member baru** (menjawab flow register `pending`):

```
/member/kelola        → tabel semua member (desc by created_at)
  ├─ klik member → /admin/member/{id}   (detail + dokumen KTP/domisili/KTM/KK + foto)
  │
└─ PUT /admin/member/{id}  (Admin\MemberController@update)
            status diubah ke salah satu:
              ├─ 'pending'  (default saat register)
              ├─ 'approved' → member bisa daftar program
              │    • nomor member (no_member) dibuat otomatis format RB-YYMMDD-NNNN
              │      (urutan global, tidak direset)
              │    • notifikasi in-app "Akun Kamu Disetujui" dikirim
              └─ 'rejected' → member diblokir (boleh isi catatan_member)
                   • notifikasi in-app "Akun Kamu Ditolak" + alasan dari catatan_member
            catatan_member: alasan, opsional
```

Setelah status = `approved`, member langsung bisa mengakses program & pendaftaran.

Dokumen member (KTP, surat domisili, KTM, KK, foto profil) dilihat lewat
`GET /admin/member/{id}/dokumen/{kolom}` — file dilayani baik dari storage maupun dari
kolom base64.

> Export data member: `GET /admin/member/export` (file .xls).
>
> **Reset massal** (berguna untuk demo/reset data):
> `POST /admin/member/reset` dan `POST /admin/pendaftaran/reset` — keduanya menghapus
> data (member + pendaftaran + notifikasi + file dokumen, atau seluruh tabel pendaftaran).
> Karena destruktif, kedua endpoint ini memverifikasi ulang **nama admin + password**
> (`Controller@verifikasiKredensialAdmin`) sebelum menjalankan.

### 6.3. Kelola Pendaftaran Program (`/admin/pendaftaran`)

```
/pendaftaran          → daftar pendaftar program dikelompokkan
                        jenis (tematik/tentative) → mode (online/offline) → kelas
/pendaftaran/export   → export .xls semua pendaftar
DELETE /pendaftaran/{id} → hapus satu pendaftaran (kuota kembali tersedia)
```

Karena pendaftaran program **langsung `confirmed`**, di sini admin pada dasarnya hanya
**melihat, mengekspor, dan menghapus** — tidak ada tombol approve/reject.

Baris pendaftaran lama yang belum punya `jadwal_id` tetap ditampilkan dengan cara
menCocokkan nama program sebagai fallback.

### 6.4. Laporan (`/admin/laporan`)

Modul analitik yang sudah ada. Filter periode: **minggu** (`input type="week"`),
**bulan** (`input type="month"`), atau **semua**.

Metrik ringkasan:
- `total_pendaftar` — jumlah baris pendaftaran `confirmed` dalam periode
- `total_member` — jumlah member unik di antara pendaftar tersebut
- `member_approved` — berapa di antaranya yang akunnya sudah `approved`

Rincian per kategori (dihitung dengan Collection, bukan SQL `GROUP BY`):
- `per_kelas` — jumlah pendaftar tiap kelas
- `per_jenis` — tematik vs tentative
- `per_mode` — online vs offline

Export: `GET /admin/laporan/export` → file `.xls` berisi ringkasan, rincian per kelas,
dan detail 13 kolom (No, Tanggal Daftar, No Member, Nama, NIK, Usia, Pekerjaan, Email, HP,
Jenis, Mode, Program/Kelas, Status Anggota). Seluruh tanggal sudah diformat WIB / locale `id`.

### 6.5. Kelola Konten

| Menu | Rute | Aksi |
|------|------|------|
| **Konten** (berita) | `POST /admin/berita`, `PUT /admin/berita/{id}`, `DELETE /admin/berita/{id}` | Tambah / edit / hapus berita |
| **Profil** | `POST /admin/profil`, `PUT /admin/profil/{id}`, `DELETE /admin/profil/{id}` | Kelola sejarah, visi misi, volunteer, sasaran |
| **Program** | `/admin/program`, `POST/PUT/DELETE` | Kelola daftar program bahasa |
| **Jadwal Kelas** | `POST/PUT/DELETE /admin/jadwal-kelas/{id}` | Kelola jadwal mingguan, kuota, pengajar, tema |
| **Program-Jadwal** | `/admin/program-jadwal` | Halaman gabungan program + jadwal (jadwal lewat tanggal dibersihkan saat dibuka) |

Setiap perubahan pada **jadwal kelas** (buat / ubah / hapus) otomatis mengirim notifikasi
in-app **broadcast ke seluruh member yang sudah `approved`** —titles varies antara
"Jadwal Kelas Baru", "Jadwal Kelas Diperbarui", atau "Jadwal Kelas Dihapus".

Gambar berita disimpan dua kali: ke file storage **dan** ke kolom base64 (`gambar_data`),
supaya tetap tampil di Railway yang filesystem-nya nggak persisten.

### 6.6. Kelola Kontak Masuk (`/admin/kontak`)

```
/kontak                → daftar pesan pengunjung (terbaru dulu)
/kontak/{id}/read      → tandai sudah dibaca
DELETE /kontak/{id}    → hapus pesan
```

Pesan yang masuk dari form kontak `/kontak` disimpan ke tabel `kontak` **dan** dikirim
via email ke semua admin (`KontakMasukMail`, mode `MAIL_MAILER=log` saat development
jadi email ditulis ke `storage/logs/laravel.log`). Panel admin tetap jadi inbox utama.

---

## 7. Alur Keseluruhan (End-to-End)

Ilustrasi perjalanan satu pengguna dari pertama datang sampai menjadi member aktif:

```
┌──────────────────────────────────────────────────────────────────────┐
│ 1. PENGUNJUNG                                                        │
│    • Buka beranda, lihat berita, profil, layanan, jadwal, tata cara  │
│    • Kirim pesan lewat form kontak (masuk ke panel admin)            │
└──────────────────────────────┬───────────────────────────────────────┘
                               ▼
┌──────────────────────────────────────────────────────────────────────┐
│ 2. REGISTER (calon member)                                           │
│    • Isi form + upload foto & dokumen (KTP/Domisili/KTM/KK)          │
│    • Akun dibuat status = PENDING, otomatis login                    │
└──────────────────────────────┬───────────────────────────────────────┘
                               ▼
┌──────────────────────────────────────────────────────────────────────┐
│ 3. TUNGGU PERSETUJUAN ADMIN                                          │
│    • Member lihat dashboard dengan peringatan "belum diverifikasi"   │
│    • Member TIDAK BISA daftar program dulu                           │
└──────────────────────────────┬───────────────────────────────────────┘
                               ▼
┌──────────────────────────────────────────────────────────────────────┐
│ 4. ADMIN SETUJUI / TOLAK                                             │
│    • Admin buka /admin/member/kelola → detail member                 │
│    • Set status = approved (atau rejected + catatan)                 │
└──────────────────────────────┬───────────────────────────────────────┘
                               ▼
┌──────────────────────────────────────────────────────────────────────┐
│ 5. MEMBER AKTIF                                                      │
│    • Bisa membuka /member/program                                    │
│    • Pilih program → pilih jadwal → daftar (langsung CONFIRMED)      │
│    • Lihat jadwal mingguan, edit profil, terima notifikasi           │
└──────────────────────────────┬───────────────────────────────────────┘
                               ▼
┌──────────────────────────────────────────────────────────────────────┐
│ 6. ADMIN PANTAU                                                     │
│    • Lihat & export pendaftar program di /admin/pendaftaran          │
│    • Lihat & export data member di /admin/member                     │
└──────────────────────────────────────────────────────────────────────┘
```

---

## 8. Diagram Status Member & Pendaftaran

**Status User (akun member):**

```
     register
        │
        ▼
   ┌─────────┐   approved (admin)   ┌──────────┐
   │ pending ├──────────────────────► approved │  → bisa daftar program
   │         │                       │          │    no_member dibuat: RB-YYMMDD-NNNN
   └────┬────┘                       └──────────┘
        │
        └── rejected (admin) → akun diblokir, tidak bisa lanjut
```

Status juga bisa dikembalikan ke `pending` kapan saja dari panel admin.

**Status Pendaftaran (program):**

```
    daftar program
        │
        ├── kuota = 0 ─────────► rejected  (catatan "Kuota kelas belum dibuka (0).")
        │
        ├── kuota penuh ───────► rejected  (catatan "Kuota kelas sudah penuh.")
        │
        └── kuota tersedia ────► confirmed (instan)
                                    │
                                    └── member batalkan (delete)
                                        atau admin hapus (delete)
                                        → kuota kembali tersedia
```

> Belum ada status `waiting` / antrean — inilah celah yang jadi objek pengembangan
> smart waiting list pada tugas akhir.

---

## 9. Alur Otomatis / Scheduler

- **Reset jadwal kelas mingguan** → `php artisan jadwal:reset-mingguan`
  - Dijadwalkan tiap **Minggu 00:00** oleh Laravel Scheduler (lihat `bootstrap/app.php` → schedule via console).
  - Di entrypoint deployment (`entrypoint.sh`) ditambah tinker untuk membersihkan duplikat profil & seed awal jika tabel layanan kosong.
- **Bersihkan pendaftaran tentative** (di `MemberController@bersihkanPendaftaranTentative`):
  - Saat dashboard/program dibuka, pendaftaran kelas **tentative** (1 pertemuan = 1 materi) yang `confirmed` dan `created_at` sebelum awal minggu berjalan otomatis dihapus — member harus daftar lagi untuk pertemuan/materi berikutnya.
  - Kelas **tematik** (1 tema/buku dibahas beberapa pertemuan) tidak dihapus — member tetap terdaftar sampai tema selesai.
- **Throttle form publik** → `throttle:public-forms` (10 permintaan/menit per IP) pada login,
  register, dan form kontak untuk cegah spam.
- **Pembersihan otomatis saat deploy** (`.docker/entrypoint.sh`): clear cache, `migrate --force`,
  backfill kolom `umur` & `rentang_usia`, deduplikat `profil`, dan seed awal bila tabel
  `layanan` masih kosong.

> Untuk production, pastikan cron scheduler jalan:
> ```bash
> * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
> ```

---

## 10. Rute Utama (Route Map)

### Publik (tanpa login)
| Metode | URI | Nama |
|--------|-----|------|
| GET | `/` | `home` |
| GET | `/profil` | `profil` |
| GET | `/profil/{id}` | `profil.show` |
| GET | `/berita` | `berita.list` |
| GET | `/berita/{slug}` | `berita.show` |
| GET | `/layanan` | `layanan` |
| GET | `/layanan/{nama}` | `layanan.show` |
| GET | `/jadwal` | `jadwal` |
| GET | `/tata-cara/{jenis?}` | `tata-cara` |
| GET | `/kontak` | `kontak` |
| POST | `/kontak` | `kontak.kirim` (throttle) |
| GET | `/contoh-surat-domisili` | `contoh.surat.domisili` |
| GET | `/sitemap.xml` | `sitemap` |

### Auth (guest)
| Metode | URI | Nama |
|--------|-----|------|
| GET | `/login` | `login` |
| POST | `/login` | `login.post` (throttle) |
| GET | `/register` | `register` |
| POST | `/register` | `register.post` (throttle) |
| POST | `/logout` | `logout` |

### Member | middleware: `auth` + `member.auth`
| Metode | URI | Nama |
|--------|-----|------|
| GET | `/pendaftaran` | `pendaftaran` |
| POST | `/pendaftaran` | `pendaftaran.store` |
| GET | `/member/dashboard` | `member.dashboard` |
| GET | `/member/program` | `member.program` |
| GET | `/member/program/{nama}` | `member.program.detail` |
| GET | `/member/jadwal` | `member.jadwal` |
| GET | `/member/notifikasi` | `member.notifikasi` |
| GET | `/member/notifikasi/baca-semua` | `member.notifikasi.baca.semua` |
| GET | `/member/notifikasi/{id}` | `member.notifikasi.baca` |
| GET | `/member/edit` | `member.edit` |
| PUT | `/member/update` | `member.update` |
| DELETE | `/member/pendaftaran/{id}/batal` | `member.pendaftaran.batal` |

### Admin | middleware: `auth` + `admin.auth`, prefix `/admin`
| Metode | URI | Nama |
|--------|-----|------|
| GET | `/admin` | `admin.dashboard` |
| GET | `/admin/konten` | `admin.konten.index` |
| POST | `/admin/berita` | `admin.berita.store` |
| PUT | `/admin/berita/{id}` | `admin.berita.update` |
| DELETE | `/admin/berita/{id}` | `admin.berita.destroy` |
| POST | `/admin/profil` | `admin.profil.store` |
| PUT | `/admin/profil/{id}` | `admin.profil.update` |
| DELETE | `/admin/profil/{id}` | `admin.profil.destroy` |
| GET | `/admin/program` | `admin.program.index` |
| POST | `/admin/program` | `admin.program.store` |
| PUT | `/admin/program/{id}` | `admin.program.update` |
| DELETE | `/admin/program/{id}` | `admin.program.destroy` |
| GET | `/admin/program-jadwal` | `admin.program-jadwal.index` |
| GET | `/admin/kontak` | `admin.kontak.index` |
| GET | `/admin/kontak/{id}/read` | `admin.kontak.markRead` |
| DELETE | `/admin/kontak/{id}` | `admin.kontak.destroy` |
| POST | `/admin/jadwal-kelas` | `admin.jadwal-kelas.store` |
| PUT | `/admin/jadwal-kelas/{id}` | `admin.jadwal-kelas.update` |
| DELETE | `/admin/jadwal-kelas/{id}` | `admin.jadwal-kelas.destroy` |
| GET | `/admin/pendaftaran` | `admin.pendaftaran.index` |
| GET | `/admin/pendaftaran/export` | `admin.pendaftaran.export` |
| POST | `/admin/pendaftaran/reset` | `admin.pendaftaran.reset` |
| DELETE | `/admin/pendaftaran/{id}` | `admin.pendaftaran.destroy` |
| GET | `/admin/laporan` | `admin.laporan.index` |
| GET | `/admin/laporan/export` | `admin.laporan.export` |
| GET | `/admin/member/kelola` | `admin.member.kelola` |
| GET | `/admin/member/export` | `admin.member.export` |
| POST | `/admin/member/reset` | `admin.member.reset` |
| GET | `/admin/member/{id}/dokumen/{kolom}` | `admin.member.dokumen` |
| GET | `/admin/member/{id}` | `admin.member.show` |
| PUT | `/admin/member/{id}` | `admin.member.update` |

> Tervalidasi: 61 rute di `routes/web.php` = 61 baris tabel di dokumen ini.

---

## 11. Batasan Sistem Saat Ini

Bagian ini sengaja dicatat karena jadi bahan analisis untuk pengembangan tugas akhir.

| Area | Kondisi sekarang | Catatan |
|------|------------------|---------|
| Dashboard admin | 9 angka statis, tanpa chart | Belum ada visualisasi distribusi usia, tren pendaftaran, tingkat keterisian |
| Kuota penuh | Member **ditolak** (`rejected`) | Tidak ada waiting list / auto-promote saat ada pembatalan |
| Notifikasi | In-app (tabel `notifikasi`) saja | Tidak ada email ke member, tidak ada pengingat H-1, tidak ada web push |
| Lupa password | Tidak ada | Tabel `password_reset_tokens` sudah di-drop lewat migration; reset hanya manual oleh admin (`php artisan admin:reset-password`) |
| Absensi | Link eksternal ke SIPUS | Tidak ada tabel absensi sendiri, tidak ada rekap kehadiran |
| Akses peserta | Web saja (Blade server-rendered) | Tidak ada `routes/api.php`, tidak ada token auth, tidak ada PWA |
| Relasi program ↔ jadwal | Dicocokkan by `LIKE %nama_kelas%` | Bukan foreign key; mengganti nama program diam-diam memutus relasi jadwal |
| Pengujian | Hanya 2 test bawaan Laravel | Belum ada test fitur aplikasi |

### Command yang tersedia

| Command | Fungsi |
|---------|--------|
| `php artisan jadwal:reset-mingguan` | Hapus jadwal kelas yang tanggalnya sudah lewat |
| `php artisan admin:reset-password [email] [password]` | Reset password admin (password acak 16 karakter bila tidak diisi) |
| `composer dev` | Jalankan server + queue + log + vite bersamaan |
| `composer test` | Jalankan PHPUnit |