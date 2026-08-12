<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_desc', 'Rumah Bahasa Surabaya — program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta name="keywords" content="rumah bahasa surabaya, perpustakaan surabaya, kearsipan surabaya, literasi surabaya, kelas bahasa surabaya, program rumah bahasa">
    <meta name="author" content="Dinas Perpustakaan dan Kearsipan Kota Surabaya">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
    <meta property="og:description" content="@yield('meta_desc', 'Program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/rumbas.jpg'))">
    <meta property="og:site_name" content="Rumah Bahasa Surabaya">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
    <meta name="twitter:description" content="@yield('meta_desc', 'Program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/rumbas.jpg'))">

    <title>@yield('title', 'Rumah Bahasa Surabaya') — Dinas Perpustakaan dan Kearsipan Kota Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Schema.org untuk SEO --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "Rumah Bahasa Surabaya",
        "alternateName": "Rumah Bahasa",
        "url": "{{ url('/') }}",
        "description": "Program literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.",
        "publisher": {
            "@@type": "GovernmentOrganization",
            "name": "Dinas Perpustakaan dan Kearsipan Kota Surabaya",
            "url": "https://dispusip.surabaya.go.id"
        }
    }
    </script>

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
        .brand-blue { color: #2284d9; }
        .brand-light { color: #42c1f4; }

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
        .navbar-links a:hover { color: #1076ad; }
        
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #1282c3;
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
            background: linear-gradient(90deg, #1272e0, #328aee, #36b1f4, #5acaf7);
            border-radius: 3px;
            transition: transform 0.3s ease;
        }
        .navbar-links a:hover {
            color: #1b95c9 !important;
        }
        .navbar-links a:hover::after {
            transform: translateX(-50%) scaleX(0.5);
        }
        .navbar-links a.nav-active {
            color: #1a8fd8 !important;
        }
        .navbar-links a.nav-active::after {
            transform: translateX(-50%) scaleX(1);
            animation: shimmer 2s ease-in-out infinite;
            background: linear-gradient(90deg, #023ea7, #0f5fc1, #1a8fca, #59b8f7, #3cb3ef, #2784e0, #0258ad);
            background-size: 200% 100%;
        }
        @@keyframes shimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @@media (max-width: 768px) {
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
            background: #1360dc;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        /* Kompabilitas Body biar gak ketutupan Navbar Fixed */
        body { padding-top: 70px; }

        /* ===== RESPONSIVE BREAKPOINT UNTUK MOBILE (HP) ===== */
        @@media (max-width: 768px) {
            .nav-toggle {
                display: flex; /* Memunculkan tombol burger di HP */
            }
            .navbar-links {
                display: flex; /* tetap flex, disembunyikan lewat posisi + transisi geser */
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
            <img src="{{ asset('images/logo.png') }}" alt="Logo Rumah Bahasa" class="brand-logo">
        </a>
        
        <div class="navbar-links">
            <a href="{{ route('home') }}#beranda">Beranda</a>
            <a href="{{ route('home') }}#berita">Berita</a>
            <a href="{{ route('layanan') }}">Program</a>
            <a href="{{ route('home') }}#about">Profil</a>
            <a href="{{ route('tata-cara', 'ktp-surabaya') }}">Tata Cara</a>
            <a href="{{ route('home') }}#kontak">Kontak</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-login" style="background:var(--teal-600);">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Login
                    </a>
                @else
                    <a href="{{ route('member.dashboard') }}" class="btn-login" style="background:var(--teal-500);">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Login
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Login
                </a>
            @endauth
        </div>
        
        {{-- Area Samping Burger khusus Mobile --}}
        <div class="mobile-nav-actions">
            <a href="{{ route('login') }}" class="btn-login btn-mobile-register">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                Daftar
            </a>
            
            <button class="nav-toggle" onclick="document.querySelector('.navbar-links').classList.toggle('show')">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

{{-- Styling Khusus Navbar & Responsive Mobile --}}
<style>
    /* Styling Logo Custom */
    .navbar-brand img.brand-logo {
        height: 32px;
        width: auto;
        object-fit: contain;
        flex-shrink: 0;
    }

    /* Ukuran Font Standar Brand */
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    .navbar-brand .brand-teal {
        font-weight: 700;
        font-size: 16px;
    }
    .navbar-brand .brand-light {
        font-weight: 400;
        font-size: 15px;
        color: #64748b;
    }

    /* Wrapper Actions di Mobile */
    .mobile-nav-actions {
        display: none;
        align-items: center;
        gap: 10px;
    }

    /* BURGER MENU HITAM */
    .nav-toggle span {
        background-color: #1e293b !important; /* Warna hitam pekat/dark slate */
        height: 2.5px !important;
        border-radius: 2px;
    }

    /* Optimization untuk Layar Mobile */
    @@media (max-width: 768px) {
        .navbar {
            padding: 10px 0 !important; /* Memperkecil tinggi navbar */
        }
        
        .navbar-brand img.brand-logo {
            height: 28px; /* Lebih ramping di mobile */
        }

        .navbar-brand .brand-teal {
            font-size: 14px;
        }
        
        .navbar-brand .brand-light {
            font-size: 13px;
        }

        /* Tampilkan wrapper mobile actions */
        .mobile-nav-actions {
            display: flex !important;
        }

        /* Styling khusus Button Daftar di Mobile */
        .btn-mobile-register {
            padding: 6px 12px !important;
            font-size: 12px !important;
            border-radius: 6px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            text-decoration: none !important;
        }

        /* Menu Dropdown Mobile */
        .navbar-links {
            padding: 12px 16px !important;
            gap: 10px !important;
        }

        .navbar-links a {
            font-size: 14px !important; /* Font standar mobile */
            padding: 8px 0 !important;
        }

        .navbar-links .btn-login {
            padding: 8px 16px !important;
            font-size: 13px !important;
            justify-content: center;
        }
    }
</style>

@yield('content')

    @if(!isset($hideFooter) || !$hideFooter)
    {{-- FOOTER --}}
    <footer class="footer">
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
                    <h3>Program & Pendaftaran</h3>
                    <div class="footer-links">
                        <a href="{{ route('tata-cara', 'ktp-surabaya') }}">Tata Cara Pendaftaran (KTP Surabaya)</a>
                        <a href="{{ route('tata-cara', 'ktp-non-surabaya') }}">Tata Cara Pendaftaran (KTP Non-Surabaya)</a>
                        <a href="{{ route('register') }}">Daftar Program</a>
                        <a href="{{ route('layanan') }}">Daftar Kelas Bahasa</a>
                        <a href="{{ route('jadwal') }}">Jadwal Kelas</a>
                        <a href="{{ route('home') . '#pelatihan' }}">Lingkup Pelatihan</a>
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
                           style="position:absolute;bottom:12px;right:12px;z-index:10;padding:8px 16px;background:rgba(0, 44, 115, 0.9);backdrop-filter:blur(4px);color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 2px 8px rgba(0,0,0,0.15);transition:all 0.2s;"
                           onmouseover="this.style.background='#07459c'" onmouseout="this.style.background='rgba(0, 38, 115, 0.9)'"
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
                <div class="footer-bottom-box">
                    <div class="footer-bottom-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Rumah Bahasa" style="height:28px;width:auto;object-fit:contain;">
                    </div>
                    <div class="footer-bottom-text">
                        &copy; {{ date('Y') }} Dinas Perpustakaan dan Kearsipan Kota Surabaya. Seluruh hak cipta dilindungi.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <script>
        // Smooth reveal on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target); // stop mantau setelah animasi jalan sekali
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

            document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
        });

        // Active nav section indicator
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-links a[href^="#"], .navbar-links a[href*="#"]');

            // Tandai link aktif berdasarkan halaman yang sedang dibuka (untuk halaman terpisah seperti /layanan & /tata-cara)
            const currentPath = window.location.pathname;
            const allNavLinks = document.querySelectorAll('.navbar-links a');
            allNavLinks.forEach(link => {
                if (link.classList.contains('btn-login')) return; // lewati tombol login
                const href = link.getAttribute('href') || '';
                const label = link.textContent.trim().toLowerCase();
                const isActive =
                    (label === 'berita' && currentPath.startsWith('/berita')) ||
                    (label === 'profil' && currentPath.startsWith('/profil')) ||
                    (label === 'program' && currentPath.startsWith('/layanan')) ||
                    (label === 'tata cara' && currentPath.startsWith('/tata-cara')) ||
                    (label === 'galeri' && currentPath.startsWith('/galeri'));
                if (isActive) link.classList.add('nav-active');
            });

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

        // Tutup menu mobile otomatis saat salah satu link diklik
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.navbar-links a').forEach(link => {
                link.addEventListener('click', () => {
                    document.querySelector('.navbar-links').classList.remove('show');
                });
            });
        });
    </script>
</body>
</html>