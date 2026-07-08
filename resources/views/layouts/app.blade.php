<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_desc', 'Rumah Belajar Surabaya — program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta name="keywords" content="rumah belajar surabaya, perpustakaan surabaya, kearsipan surabaya, literasi surabaya">
    <meta property="og:title" content="@yield('title', 'Rumah Belajar Surabaya')">
    <meta property="og:description" content="@yield('meta_desc', 'Program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <title>@yield('title', 'Rumah Belajar Surabaya') — Dinas Perpustakaan dan Kearsipan Kota Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" style="flex-shrink:0;">
                    <rect width="28" height="28" rx="6" fill="#005f73"/>
                    <path d="M14 7v14M7 10h14M7 18h14" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="14" cy="14" r="4" fill="none" stroke="white" stroke-width="1.5"/>
                </svg>
                <span class="brand-teal">Rumah Belajar</span>
                <span class="brand-light">Surabaya</span>
            </a>
            <div class="navbar-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('home') }}#about">Tentang</a>
                <a href="{{ route('home') }}#berita">Berita</a>
                <a href="{{ route('home') }}#layanan">Layanan</a>
                <a href="{{ route('home') }}#kontak">Kontak</a>
                <a href="{{ route('login') }}" class="btn-login">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Login Admin
                </a>
            </div>
            <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('show')">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    @yield('content')

    {{-- FOOTER --}}
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h3>Kontak & Alamat</h3>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=-7.2636128%2C112.7455063&travelmode=driving" target="_blank" rel="noopener noreferrer" style="text-decoration:none;color:inherit;display:block;">
                        <div class="footer-item">
                            <div class="footer-item-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div>
                                <h4>Alamat</h4>
                                <p>Jl. Yos Sudarso No.15, Embong Kaliasin<br>Kec. Genteng, Surabaya, Jawa Timur 60271</p>
                            </div>
                        </div>
                    </a>
                    <div class="footer-item">
                        <div class="footer-item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p>info@rumahbelajar-surabaya.go.id</p>
                        </div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <h4>Telepon</h4>
                            <p>(031) 1234567</p>
                        </div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <h4>Jam Operasional</h4>
                            <p>Senin — Jumat, 08.00 — 16.00 WIB</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3>Peta Lokasi</h3>
                    <div class="footer-map" style="padding:0;overflow:hidden;display:block;position:relative;">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=112.738%2C-7.267%2C112.753%2C-7.260&amp;layer=mapnik&amp;marker=-7.2636128%2C112.7455063"
                            width="100%"
                            height="240"
                            style="border:0;display:block;"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Rumah Bahasa Surabaya"
                        ></iframe>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=-7.2636128%2C112.7455063&travelmode=driving"
                           target="_blank" rel="noopener noreferrer"
                           style="position:absolute;bottom:12px;right:12px;z-index:10;padding:8px 16px;background:rgba(0,95,115,0.9);backdrop-filter:blur(4px);color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 2px 8px rgba(0,0,0,0.15);transition:all 0.2s;"
                           onmouseover="this.style.background='#005f73'" onmouseout="this.style.background='rgba(0,95,115,0.9)'"
                           title="Buka rute ke Rumah Bahasa Surabaya di Google Maps">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Buka Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                &copy; {{ date('Y') }} Dinas Perpustakaan dan Kearsipan Kota Surabaya. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <script>
        // Mobile nav toggle
        document.querySelector('.nav-toggle')?.addEventListener('click', function() {
            const links = document.querySelector('.navbar-links');
            links.style.display = links.style.display === 'flex' ? 'none' : 'flex';
        });

        // Smooth reveal on scroll (simple)
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
