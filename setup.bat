@echo off
chcp 65001 >nul

echo ============================================
echo   🔧  Setup Rumah Bahasa Surabaya
echo ============================================
echo.

REM Cek PHP
where php >nul 2>&1
if %errorlevel% neq 0 (
    echo   [ERROR] PHP gak ditemukan. Install PHP dulu.
    pause
    exit /b
)
echo   [✓] PHP  OK

REM Cek Composer
where composer >nul 2>&1
if %errorlevel% neq 0 (
    echo   [ERROR] Composer gak ditemukan. Install Composer dulu.
    pause
    exit /b
)
echo   [✓] Composer  OK

REM Cek ekstensi SQLite
php -m | find "pdo_sqlite" >nul
if %errorlevel% neq 0 (
    echo   [ERROR] Ekstensi PHP pdo_sqlite belum aktif.
    echo   Buka C:\php\php.ini, cari ";extension=pdo_sqlite"
    echo   Hapus tanda titik koma di depannya, simpan, lalu coba lagi.
    pause
    exit /b
)
echo   [✓] pdo_sqlite  OK

echo.
echo   [1/5] Install Composer dependencies...
call composer install --no-interaction

echo.
echo   [2/5] Copy .env...
if not exist .env (
    copy .env.example .env >nul
    echo   [✓] .env berhasil dibuat
) else (
    echo   [✓] .env sudah ada
)

echo.
echo   [3/5] Generate APP_KEY...
php artisan key:generate --force --quiet
echo   [✓] APP_KEY OK

echo.
echo   [4/5] Hapus database lama (kalo ada)...
if exist database\database.sqlite del database\database.sqlite

echo.
echo   [5/5] Migrate + Seed database...
php artisan migrate:fresh --seed --force
if %errorlevel% neq 0 (
    echo.
    echo   [ERROR] Migrasi gagal. Hubungi developer.
    pause
    exit /b
)
echo   [✓] Database siap

echo.
echo ============================================
echo   ✅  SETUP BERHASIL!
echo ============================================
echo.
echo   🔗  Jalankan:  php artisan serve
echo      atau klik   serve.bat
echo.
echo   👤  Admin : admin@rumahbahasa.com
echo   🔑         admin123
echo.
echo   👤  Member: member@example.com
echo   🔑         member123
echo.
pause
