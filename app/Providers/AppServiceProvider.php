<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS: di production selalu https; di lokal ikuti request (biar aman juga
        // kalau diakses via https). Mencegah CSS/JS diblokir browser (mixed content).
        if (app()->environment('production') || request()->isSecure()) {
            URL::forceScheme('https');
        }

        // Fallback (khusus development): kalo APP_URL di .env masih 'localhost' tapi request
        // masuk dari LAN, pake host dari request biar route/url gak pake 'localhost'.
        // Di production APP_URL sudah domain asli, jadi biarkan dihormati (link email, sitemap, dll).
        if (app()->environment('local') && request()->server->has('HTTP_HOST')) {
            $host = request()->server('HTTP_HOST');
            if ($host && !str_contains($host, 'localhost') && !str_contains($host, '127.0.0.1')) {
                URL::forceRootUrl(request()->getSchemeAndHttpHost());
            }
        }

        // Rate limit untuk form publik (kontak, login, register) — cegah spam
        RateLimiter::for('public-forms', function ($job) {
            return Limit::perMinute(10)->by($job->ip());
        });
    }
}
