<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalKelasController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PendaftaranController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProfilController as AdminProfil;
use App\Http\Controllers\Admin\LayananController as AdminLayanan;
use App\Http\Controllers\Admin\GaleriController as AdminGaleri;
use App\Http\Controllers\Admin\KontakController as AdminKontak;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaran;
use App\Http\Controllers\Admin\MemberController as AdminMember;
use App\Http\Controllers\Admin\JadwalKelasController as AdminJadwalKelas;

// ===== PUBLIC =====
Route::get('/', [BeritaController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/berita', [BeritaController::class, 'list'])->name('berita.list');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'kirim'])->name('kontak.kirim');
Route::get('/jadwal', [JadwalKelasController::class, 'index'])->name('jadwal');

// ===== CONTOH SURAT (public) =====
Route::get('/contoh-surat-domisili', function () {
    return view('auth.contoh-surat-domisili');
})->name('contoh.surat.domisili');

// ===== AUTH (guest) =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== MEMBER =====
Route::middleware(['auth', 'member.auth'])->group(function () {
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/program', [MemberController::class, 'program'])->name('program');
        Route::get('/jadwal', [MemberController::class, 'jadwal'])->name('jadwal');
        Route::get('/notifikasi', [MemberController::class, 'notifikasiIndex'])->name('notifikasi');
        Route::get('/notifikasi/baca-semua', [MemberController::class, 'notifikasiBacaSemua'])->name('notifikasi.baca.semua');
        Route::get('/notifikasi/{id}', [MemberController::class, 'notifikasiBaca'])->name('notifikasi.baca');
        Route::get('/edit', [MemberController::class, 'edit'])->name('edit');
        Route::put('/update', [MemberController::class, 'update'])->name('update');
    });
});

// ===== ADMIN =====
Route::middleware(['auth', 'admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('/berita', [BeritaController::class, 'adminIndex'])->name('berita.index');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    Route::get('/profil', [AdminProfil::class, 'index'])->name('profil.index');
    Route::post('/profil', [AdminProfil::class, 'store'])->name('profil.store');
    Route::put('/profil/{id}', [AdminProfil::class, 'update'])->name('profil.update');
    Route::delete('/profil/{id}', [AdminProfil::class, 'destroy'])->name('profil.destroy');

    Route::get('/layanan', [AdminLayanan::class, 'index'])->name('layanan.index');
    Route::post('/layanan', [AdminLayanan::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [AdminLayanan::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [AdminLayanan::class, 'destroy'])->name('layanan.destroy');

    Route::get('/galeri', [AdminGaleri::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [AdminGaleri::class, 'store'])->name('galeri.store');
    Route::put('/galeri/{id}', [AdminGaleri::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{id}', [AdminGaleri::class, 'destroy'])->name('galeri.destroy');

    Route::get('/kontak', [AdminKontak::class, 'index'])->name('kontak.index');
    Route::get('/kontak/{id}/read', [AdminKontak::class, 'markRead'])->name('kontak.markRead');
    Route::delete('/kontak/{id}', [AdminKontak::class, 'destroy'])->name('kontak.destroy');

    Route::get('/jadwal-kelas', [AdminJadwalKelas::class, 'index'])->name('jadwal-kelas.index');
    Route::post('/jadwal-kelas', [AdminJadwalKelas::class, 'store'])->name('jadwal-kelas.store');
    Route::put('/jadwal-kelas/{id}', [AdminJadwalKelas::class, 'update'])->name('jadwal-kelas.update');
    Route::delete('/jadwal-kelas/{id}', [AdminJadwalKelas::class, 'destroy'])->name('jadwal-kelas.destroy');

    Route::get('/pendaftaran', [AdminPendaftaran::class, 'index'])->name('pendaftaran.index');
    Route::put('/pendaftaran/{id}', [AdminPendaftaran::class, 'update'])->name('pendaftaran.update');
    Route::get('/pendaftaran/export', [AdminPendaftaran::class, 'export'])->name('pendaftaran.export');

    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/', [AdminMember::class, 'index'])->name('index');
        Route::get('/export', [AdminMember::class, 'export'])->name('export');
        Route::get('/{id}', [AdminMember::class, 'show'])->name('show');
        Route::put('/{id}', [AdminMember::class, 'update'])->name('update');
    });
});
