@echo off
chcp 65001 >nul

echo ============================================
echo   🚀  Rumah Bahasa Surabaya - Local Server
echo ============================================
echo.

REM Auto-detect local IP
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /C:"IPv4"') do (
    set IP=%%a
    goto :found
)
:found
set IP=%IP: =%

if "%IP%"=="" set IP=127.0.0.1

REM Set APP_URL biar route/redirect pake IP lokal, bukan localhost
set APP_URL=http://%IP%:8000

echo   Local IP : %IP%
echo   Port     : 8000
echo   APP_URL  : %APP_URL%
echo.
echo   🔗  Akses dari laptop kamu:
echo       http://localhost:8000
echo.
echo   🔗  Akses dari laptop TEMAN (LAN):
echo       http://%IP%:8000
echo.
echo ============================================
echo.
php artisan serve --host=0.0.0.0 --port=8000
echo.
pause
