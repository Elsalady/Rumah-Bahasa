<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            ['loc' => url('/'), 'freq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('profil'), 'freq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('berita.list'), 'freq' => 'daily', 'priority' => '0.9'],
            ['loc' => route('layanan'), 'freq' => 'weekly', 'priority' => '0.8'],
            ['loc' => route('kontak'), 'freq' => 'yearly', 'priority' => '0.5'],
            ['loc' => route('jadwal'), 'freq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('tata-cara', 'ktp-surabaya'), 'freq' => 'yearly', 'priority' => '0.6'],
            ['loc' => route('tata-cara', 'ktp-non-surabaya'), 'freq' => 'yearly', 'priority' => '0.6'],
        ]);

        // Berita aktif
        Berita::where('is_active', true)->orderBy('tanggal', 'desc')->get()->each(function ($berita) use ($urls) {
            $urls->push([
                'loc' => route('berita.show', $berita->slug),
                'freq' => 'monthly',
                'priority' => '0.7',
            ]);
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$u['loc']}</loc>\n";
            $xml .= "    <changefreq>{$u['freq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
