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
  │    foto profil (wajib), jenis dokumen (KTP/Domisili/KTM/KK), dokumen (wajib)
  │
  ├─ Validasi (AuthController@register):
  │    email.unique → "Email ini sudah terdaftar"
  │    foto & dokumen wajib, mimes:jpeg,png,jpg, max 2MB
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
5. Pendaftaran kelas **tematik** otomatis dihapus saat masuk minggu baru (lihat alur #9).

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
      ├─ [Cek] Sudah pernah daftar program ini?
      │        (status pending/confirmed) → "Kamu sudah terdaftar di program ini"
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

---

## 6. Alur Admin

Semua rute admin dibungkus middleware `['auth','admin.auth']` + prefix `/admin`.

### 6.1. Dashboard Admin (`/admin`)

Kartu statistik:
- Total berita, pendaftar program, pesan baru
- Member menunggu approval (`pending`)
- Member terverifikasi (`approved`)
- Total member, jumlah profil, jumlah jadwal kelas
- + daftar pendaftar terbaru & pesan terbaru

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
         └─ 'rejected' → member diblokir (boleh isi catatan_member)
       catatan_member: alasan, opsional
```

Setelah status = `approved`, member langsung bisa mengakses program & pendaftaran.

> Export data member: `GET /admin/member/export` (file .xls).

### 6.3. Kelola Pendaftaran Program (`/admin/pendaftaran`)

```
/pendaftaran          → daftar pendaftar program dikelompokkan
                        jenis (tematik/tentative) → mode (online/offline) → kelas
/pendaftaran/export   → export .xls semua pendaftar
```

Karena pendaftaran program **langsung `confirmed`**, di sini admin hanya **melihat & mengekspor**, tidak ada tombol approve/reject.

### 6.4. Kelola Konten

| Menu | Rute | Aksi |
|------|------|------|
| **Konten** (berita) | `POST /admin/berita`, `PUT /admin/berita/{id}`, `DELETE /admin/berita/{id}` | Tambah / edit / hapus berita |
| **Profil** | `POST /admin/profil`, `PUT /admin/profil/{id}`, `DELETE /admin/profil/{id}` | Kelola sejarah, visi misi, dsb. |
| **Program** | `/admin/program`, `POST/PUT/DELETE` | Kelola daftar program & kelas |
| **Jadwal Kelas** | `POST/PUT/DELETE /admin/jadwal-kelas/{id}` | Kelola jadwal mingguan, kuota, pengajar |
| **Program-Jadwal** | `/admin/program-jadwal` | Halaman gabungan program + jadwal |

### 6.5. Kelola Kontak Masuk (`/admin/kontak`)

```
/kontak                → daftar pesan pengunjung (terbaru dulu)
/kontak/{id}/read      → tandai sudah dibaca
DELETE /kontak/{id}    → hapus pesan
```

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
   └────┬────┘                      └──────────┘
        │
        └── rejected (admin) → akun diblokir, tidak bisa lanjut
```

**Status Pendaftaran (program):**

```
    daftar program
        │
        ├── kuota penuh ──────► rejected  (otomatis, catatan "Kuota kelas sudah penuh")
        │
        └── kuota tersedia ───► confirmed (instan)
                                    │
                                    └── member bisa batalkan (delete)
```

---

## 9. Alur Otomatis / Scheduler

- **Reset jadwal kelas mingguan** → `php artisan jadwal:reset-mingguan`
  - Dijadwalkan tiap **Minggu 00:00** oleh Laravel Scheduler (lihat `bootstrap/app.php` → schedule via console).
  - Di entrypoint deployment (`entrypoint.sh`) ditambah tinker untuk membersihkan duplikat profil & seed awal jika tabel layanan kosong.
- **Bersihkan pendaftaran tematik** (di `MemberController@bersihkanPendaftaranTematik`):
  - Saat dashboard/program dibuka, pendaftaran kelas **tematik** yang `confirmed` dan `created_at` sebelum awal minggu berjalan otomatis dihapus.
  - Kelas **tentative** tidak dihapus (anggota tetap 1 semester).
- **Throttle form publik** → `throttle:public-forms` pada login, register, dan form kontak untuk cegah spam.

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
| GET | `/admin/member/kelola` | `admin.member.kelola` |
| GET | `/admin/member/export` | `admin.member.export` |
| GET | `/admin/member/{id}` | `admin.member.show` |
| PUT | `/admin/member/{id}` | `admin.member.update` |