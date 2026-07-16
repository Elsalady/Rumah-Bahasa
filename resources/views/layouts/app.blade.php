<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_desc', 'Rumah Bahasa Surabaya — program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta name="keywords" content="rumah bahasa surabaya, perpustakaan surabaya, kearsipan surabaya, literasi surabaya">
    <meta property="og:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
    <meta property="og:description" content="@yield('meta_desc', 'Program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <title>@yield('title', 'Rumah Bahasa Surabaya') — Dinas Perpustakaan dan Kearsipan Kota Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Perbaikan Struktur CSS Responsif Navbar --}}
    <style>
        .navbar {
            background: var(--white, #ffffff);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 15px 0;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .brand-teal { color: #005f73; }
        .brand-light { color: #2dd4bf; }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 25px;
        }
        .navbar-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }
        .navbar-links a:hover { color: #005f73; }
        
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #005f73;
            color: white !important;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600 !important;
        }

        .navbar-links a {
            position: relative;
            transition: all 0.3s ease;
        }
        .navbar-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, #005f73, #0d9488, #14b8a6, #2dd4bf);
            border-radius: 3px;
            transition: transform 0.3s ease;
        }
        .navbar-links a:hover {
            color: #0d9488 !important;
        }
        .navbar-links a:hover::after {
            transform: translateX(-50%) scaleX(0.5);
        }
        .navbar-links a.nav-active {
            color: #0d9488 !important;
        }
        .navbar-links a.nav-active::after {
            transform: translateX(-50%) scaleX(1);
            animation: shimmer 2s ease-in-out infinite;
            background: linear-gradient(90deg, #005f73, #0d9488, #14b8a6, #2dd4bf, #14b8a6, #0d9488, #005f73);
            background-size: 200% 100%;
        }
        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @media (max-width: 768px) {
            .navbar-links a::after {
                bottom: 8px;
                width: 30%;
                left: 0;
                transform: translateX(0) scaleX(0);
                transform-origin: left;
            }
            .navbar-links a:hover::after {
                transform: translateX(0) scaleX(0.5);
                transform-origin: left;
            }
            .navbar-links a.nav-active::after {
                transform: translateX(0) scaleX(1);
                transform-origin: left;
                width: 30%;
            }
        }

        /* Tombol Burger Menu (Default Tersembunyi di Desktop) */
        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            z-index: 1010;
        }
        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: #005f73;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        /* Kompabilitas Body biar gak ketutupan Navbar Fixed */
        body { padding-top: 70px; }

        /* ===== RESPONSIVE BREAKPOINT UNTUK MOBILE (HP) ===== */
        @media (max-width: 768px) {
            .nav-toggle {
                display: flex; /* Memunculkan tombol burger di HP */
            }
            .navbar-links {
                position: fixed;
                top: 0;
                right: -100%; /* Sembunyikan menu di kanan layar */
                width: 280px;
                height: 100vh;
                background: white;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 90px 30px 30px 30px;
                gap: 20px;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-sizing: border-box;
            }
            /* Class trigger saat menu di buka */
            .navbar-links.show {
                right: 0; /* Menu muncul menggeser dari kanan */
            }
            .navbar-links a {
                width: 100%;
                font-size: 1.1rem;
                padding: 10px 0;
                border-bottom: 1px solid #f3f4f6;
            }
            .btn-login {
                justify-content: center;
                margin-top: 10px;
            }
        }
    </style>
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
                <div>
                    <span class="brand-teal">Rumah Bahasa</span>
                    <span class="brand-light">Surabaya</span>
                </div>
            </a>
            
            <div class="navbar-links">
                <a href="{{ route('home') }}#beranda">Beranda</a>
                <a href="{{ route('home') }}#berita">Berita</a>
                <a href="{{ route('home') }}#about">Profil</a>
                <a href="{{ route('home') }}#galeri">Galeri</a>
                <a href="{{ route('home') }}#layanan">Layanan</a>
                <a href="{{ route('home') }}#kontak">Kontak</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-login" style="background:var(--teal-600);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Login
                        </a>
                    @else
                        <a href="{{ route('member.dashboard') }}" class="btn-login" style="background:var(--teal-500);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Login
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Login
                    </a>
                @endauth
            </div>
            
            <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('show')">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    @yield('content')
</body>
</html>

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
                            <p>rumah.bahasa.surabaya@gmail.com</p>
                        </div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <h4>Telepon</h4>
                            <p>(031) 5358856</p>
                        </div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-item-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <h4>Jam Operasional</h4>
                            <p>Senin — Kamis, 08.00 — 16.00 WIB</p>
                            <p>Jumat, 08.00 — 14.00 WIB</p>
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

        // Active nav section indicator
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-links a[href^="#"], .navbar-links a[href*="#"]');
            
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        navLinks.forEach(link => {
                            link.classList.remove('nav-active');
                            const href = link.getAttribute('href');
                            if (href && href.includes('#' + id)) {
                                link.classList.add('nav-active');
                            }
                        });
                    }
                });
            }, { threshold: 0.3, rootMargin: '-80px 0px 0px 0px' });

            sections.forEach(section => sectionObserver.observe(section));
        });
    </script>
</body>
</html>