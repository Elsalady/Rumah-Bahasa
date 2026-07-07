<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AuthController;

// ===== PUBLIC ROUTES =====
Route::get('/', [BeritaController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== ADMIN ROUTES (with session check) =====
Route::middleware(['admin.auth'])->prefix('admin')->group(function () {
    Route::get('/', [BeritaController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/berita', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
});
