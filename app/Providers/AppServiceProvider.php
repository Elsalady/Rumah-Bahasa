<?php

namespace App\Providers;

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
        // Fallback: kalo APP_URL di .env masih 'localhost' tapi request masuk dari LAN,
        // pake host dari request biar route/url gak pake 'localhost'
        if (request()->server->has('HTTP_HOST')) {
            $host = request()->server('HTTP_HOST');
            if ($host && !str_contains($host, 'localhost') && !str_contains($host, '127.0.0.1')) {
                URL::forceRootUrl(request()->getSchemeAndHttpHost());
            }
        }
    }
}
