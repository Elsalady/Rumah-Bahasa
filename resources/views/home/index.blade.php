@extends('layouts.app')

{{-- VERSION: 20260819-v2 --}}

@section('title', 'Beranda')
@section('meta_desc', 'Rumah Bahasa Surabaya — pusat literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')

@section('content')


{{-- ===== 1. HERO (BERANDA) - SLIDER ===== --}}
@php
    $heroSlides = [
        asset('images/rumbas.jpg'),
        asset('images/rumbas2.jpeg'),
        asset('images/rumbas3.jpeg'),
        asset('images/rumbas4.jpeg'),
    ];
@endphp
<section class="hero" id="beranda" style="
    position: relative !important;
    padding-bottom: 30px !important;
    margin-bottom: 0 !important;
">
    {{-- Slider background --}}
    <div class="hero-slider" style="position:absolute;inset:0;z-index:0;overflow:hidden;">
        @foreach($heroSlides as $i => $img)
            <div class="hero-slide {{ $i === 0 ? 'active' : '' }}" style="background:linear-gradient(180deg, rgba(56,151,224,0.35) 0%, rgba(56,151,224,0.65) 60%, rgba(56,151,224,0.95) 100%), url('{{ $img }}') center / cover no-repeat;"></div>
        @endforeach
    </div>

    <div class="hero-pattern" style="display: none !important;"></div>

    <div class="container" style="position:relative;z-index:2;width:100%;">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Dinas Perpustakaan dan Kearsipan Kota Surabaya
            </div>
            <h1>Selamat Datang di <span>Rumah Bahasa</span> Surabaya</h1>

            <p style="
    font-size: clamp(12px, 3.2vw, 13.5px) !important;
    line-height: 1.4 !important;
    max-width: 98% !important;
    width: 100% !important;
    margin: 8px auto 16px auto !important;
    text-align: center;
">
    Pusat literasi dan pembelajaran untuk masyarakat Surabaya. Mari bersama tingkatkan budaya literasi dan cinta bahasa.
</p>
            <div class="search-box" id="search-menu" onclick="toggleSearchMenu(event)">
                <div class="search-bar-row">
                    <input type="text" id="search-input" placeholder="Cari menu website..." aria-label="Cari menu" autocomplete="off">
                    <button type="button" id="search-toggle" aria-label="Buka menu">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Cari
                    </button>
                </div>

                {{-- ===== DROPDOWN MENU WEBSITE (Simple Native) ===== --}}
                <div class="search-dropdown" id="search-dropdown">
                    <a href="{{ route('home') }}#pelatihan" class="search-menu-item" data-search="lingkup pelatihan">Lingkup Pelatihan</a>
                    <a href="{{ route('home') }}#berita" class="search-menu-item" data-search="berita info terkini">Berita</a>
                    <a href="{{ route('layanan') }}" class="search-menu-item" data-search="program kelas bahasa layanan">Program</a>
                    <a href="{{ route('register') }}" class="search-menu-item" data-search="daftar sekarang register">Daftar Sekarang</a>
                    <a href="{{ route('home') }}#about" class="search-menu-item" data-search="profil tentang">Profil</a>
                    <a href="{{ route('home') }}#kontak" class="search-menu-item" data-search="kontak hubungi kami pesan">Kontak</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
        background-size: cover;
        background-position: center;
    }
    .hero-slide.active {
        opacity: 1;
        animation: heroKenburns 8s ease-in-out infinite alternate;
    }
    @keyframes heroKenburns {
        from { transform: scale(1); }
        to { transform: scale(1.08); }
    }

    /* ===== HERO ZOOM OUT — senada dengan Ken Burns background =====
       Muncul berurutan, lalu berulang setiap 5 detik (bergerak terus).
       Search bar TIDAK ikut animasi supaya kolom pencarian selalu tampil. */
    .hero-content .hero-badge,
    .hero-content h1,
    .hero-content p {
        opacity: 0;
        animation: heroZoomOut 5s ease-in-out infinite;
        will-change: opacity, transform;
    }
    .hero-content .hero-badge { animation-delay: 0s; }
    .hero-content h1 { animation-delay: 0.5s; }
    .hero-content p { animation-delay: 1s; }

    /* Search bar selalu terlihat (tidak ikut animasi muncul-hilang) */
    .hero-content .search-box {
        opacity: 1 !important;
        animation: none !important;
    }

    /* Satu siklus 5 detik: zoom-out masuk (2s), diam (2.5s), fade keluar (0.5s) */
    @keyframes heroZoomOut {
        0% {
            opacity: 0;
            transform: scale(1.14) translateY(16px);
        }
        12% {
            opacity: 0;
            transform: scale(1.1) translateY(10px);
        }
        30% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        82% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        100% {
            opacity: 0;
            transform: scale(0.98) translateY(-8px);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .hero-content .hero-badge,
        .hero-content h1,
        .hero-content p {
            animation: none;
            opacity: 1;
        }
    }

    /* ===== SEARCH BAR + DROPDOWN MENU ===== */
    /* Hero harus visible agar dropdown tidak terpotong (overflow:hidden dari style.css) */
    section.hero {
        overflow: visible !important;
    }
    .search-box {
        position: relative !important;
        display: flex !important;
        flex-direction: column;
        max-width: 520px !important;
        margin: 0 auto !important;
        background: transparent !important;
        border-radius: 14px !important;
        box-shadow: none !important;
        overflow: visible !important; /* Penting: dropdown tidak boleh terpotong */
        z-index: 1200;
    }
    .search-box .search-bar-row {
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    }
    .search-box input {
        flex: 1;
        padding: 16px 20px;
        border: none;
        outline: none;
        font-size: 15px;
        color: var(--gray-900);
        background: transparent;
        min-width: 0;
    }
    .search-box input::placeholder { color: var(--gray-400); }
    .search-box button {
        padding: 16px 22px;
        background: #0c4e91;
        color: #fff;
        border: none;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .search-box button:hover { background: #0167a2; }

    .search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        display: none; /* Lebih andal daripada visibility: hidden */
        padding: 4px 0;
    }
    .search-box.search-open .search-dropdown {
        display: block;
    }
    .search-menu-item {
        display: block;
        padding: 10px 16px;
        text-decoration: none;
        color: #1f2937;
        font-size: 14px;
        text-align: left;
        transition: background 0.15s;
    }
    .search-menu-item:hover {
        background: #f3f4f6;
        color: #111827;
    }
    .search-empty {
        padding: 20px;
        text-align: center;
        color: var(--gray-400);
        font-size: 13px;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var slides = document.querySelectorAll('.hero-slide');
    if (slides.length < 2) return;
    var current = 0;
    setInterval(function() {
        slides[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
    }, 5000);
});
</script>

{{-- ===== SCRIPT SEARCH DROPDOWN MENU ===== --}}
<script>
// Fungsi global untuk inline onclick (paling andal, tidak tergantung DOMContentLoaded)
function toggleSearchMenu(event) {
    if (event) event.stopPropagation();
    const box = document.getElementById('search-menu');
    if (!box) return;
    if (box.classList.contains('search-open')) {
        box.classList.remove('search-open');
    } else {
        box.classList.add('search-open');
        const input = document.getElementById('search-input');
        if (input) input.focus();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('search-menu');
    if (!searchBox) return;
    const input = document.getElementById('search-input');
    const dropdown = document.getElementById('search-dropdown');
    if (!input || !dropdown) return;
    const items = Array.from(dropdown.querySelectorAll('.search-menu-item'));

    // Filter menu sesuai ketikan
    input.addEventListener('input', function() {
        const q = input.value.trim().toLowerCase();
        let visibleCount = 0;
        items.forEach(function(item) {
            const text = (item.dataset.search || '') + ' ' + item.textContent.toLowerCase();
            const match = !q || text.includes(q);
            item.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });
        // Tampilkan pesan kosong jika tidak ada hasil
        let empty = dropdown.querySelector('.search-empty');
        if (visibleCount === 0 && !empty) {
            empty = document.createElement('div');
            empty.className = 'search-empty';
            empty.textContent = 'Menu tidak ditemukan';
            dropdown.appendChild(empty);
        } else if (visibleCount > 0 && empty) {
            empty.remove();
        }
    });

    // Tutup saat klik di luar
    document.addEventListener('click', function(e) {
        if (!searchBox.contains(e.target)) {
            searchBox.classList.remove('search-open');
        }
    });

    // Tutup dengan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchBox.classList.remove('search-open');
        }
    });
});
</script>


{{-- ===== 2. LINGKUP PELATIHAN ===== --}}
<section class="pelatihan-section" id="pelatihan" style="padding: 56px 0; background: linear-gradient(180deg, #3897e0 0%, #5cb0f2 30%, #7cc0f6 55%, #bfe0fb 82%, #ffffff 100%);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

        {{-- ===== WADAH BESAR PUTIH ===== --}}
        <div class="pelatihan-container">
            <div class="section-title" style="text-align:center; margin-bottom: 40px;">
                <h2 style="font-size: 2rem; font-weight: 700; color: #0c4e91; margin-bottom: 8px;">Lingkup <span style="color:#0167a2;">Pelatihan</span></h2>
                <p style="color: var(--gray-500); font-size: 1rem; max-width: 560px; margin: 0 auto;">Pelatihan unggulan yang kami selenggarakan untuk masyarakat Surabaya</p>
            </div>

            @if($pelatihan->count())
                <div class="pelatihan-grid">
                    @foreach($pelatihan as $item)
                        <a href="{{ route('layanan.show', $item->nama) }}" class="dashboard-card pelatihan-card fade-up" style="display:block; padding: 36px 26px; text-align:center; border-radius:16px; border:1px solid var(--gray-100); box-shadow:0 2px 12px rgba(0,0,0,0.06); opacity:0; transition-delay:{{ $loop->index * 0.25 }}s; animation-delay:{{ $loop->index * 0.25 + 1.2 }}s; text-decoration:none;">
                            @if($item->ikon)
                                <div style="font-size:52px; margin-bottom:16px; color:#bfe3ff;">{!! $item->ikon !!}</div>
                            @elseif($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama }}" style="width:80px; height:80px; object-fit:cover; border-radius:16px; margin-bottom:16px;">
                            @endif
                            <h3 style="font-size:20px; font-weight:700; color:#ffffff; margin:0 0 10px;">{{ $item->nama }}</h3>
                            <p style="font-size:14px; color:rgba(255,255,255,0.75); line-height:1.7; margin:0;">{{ Str::limit($item->deskripsi, 90) }}</p>
                            <span style="display:inline-flex;align-items:center;gap:6px;color:#7dd3fc;font-weight:600;font-size:13px;margin-top:14px;text-decoration:none;">
                                Lihat Detail
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </span>
                        </a>
                    @endforeach
                </div>

                {{-- Info jumlah kelas & tombol lihat selengkapnya --}}
                <div style="text-align:center; margin-top:36px;">
                    <p style="font-size:14px; color:var(--gray-500); margin:0 0 16px;">
                        Tersedia <strong style="color:#0c4e91;">{{ $totalProgram }}</strong> program kelas bahasa &amp; pelatihan lainnya
                    </p>
                    <a href="{{ route('layanan') }}" style="display:inline-flex;align-items:center;gap:8px;color:#ffffff;font-weight:600;font-size:14px;text-decoration:none;background:linear-gradient(135deg,#0c4e91 0%,#0167a2 55%,#1680bd 100%);padding:12px 28px;border-radius:50px;transition:all 0.2s;" onmouseover="this.style.background='#0a3f7a'" onmouseout="this.style.background='linear-gradient(135deg,#0c4e91 0%,#0167a2 55%,#1680bd 100%)'">
                        Lihat selengkapnya
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    /* ===== Wadah Besar Lingkup Pelatihan ===== */
    .pelatihan-container {
        background: #ffffff;
        border-radius: 32px;
        padding: 56px 48px;
        box-shadow: 0 16px 48px rgba(2, 42, 84, 0.25);
        position: relative;
        overflow: hidden;
    }

    .pelatihan-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    section.pelatihan-section .pelatihan-card {
        background: linear-gradient(160deg, #0f5a9e 0%, #0c4e91 55%, #0a3f7a 100%);
        border: 1px solid rgba(255,255,255,0.12) !important;
        box-shadow: 0 8px 24px rgba(2, 42, 84, 0.18) !important;
    }
    section.pelatihan-section .pelatihan-card:hover {
        box-shadow: 0 16px 40px rgba(2, 42, 84, 0.3) !important;
        transform: translateY(-4px) scale(1) !important;
    }

    /* ===== POP-OUT LAMBAT (slow-in) + GERAK NAIK-TURUN TERUS ===== */
    .pelatihan-grid .pelatihan-card {
        transform: translateY(36px) scale(0.88);
        transition: opacity 1.2s cubic-bezier(0.22, 1, 0.36, 1), transform 1.2s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .pelatihan-grid .pelatihan-card.show {
        opacity: 1 !important;
        transform: translateY(0) scale(1);
        animation: pelatihanFloat 3.6s ease-in-out 0.9s infinite;
    }
    /* Pakai properti `translate` terpisah supaya tidak dikalahkan
       `transform !important` dari .fade-up.show */
    @keyframes pelatihanFloat {
        0%, 100% { translate: 0 0; }
        50% { translate: 0 -14px; }
    }

    @media (max-width: 900px) {
        .pelatihan-container { padding: 44px 32px; }
        .pelatihan-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
    }
    @media (max-width: 640px) {
        section.pelatihan-section { padding: 36px 0 !important; }
        .pelatihan-container {
            padding: 32px 20px;
            border-radius: 24px;
        }
        .pelatihan-container .section-title { margin-bottom: 28px !important; }
        .pelatihan-container .section-title h2 { font-size: 1.5rem !important; }
        .pelatihan-container .section-title p { font-size: 0.85rem !important; }
        .pelatihan-grid { grid-template-columns: 1fr; gap: 16px; }
        section.pelatihan-section .pelatihan-card { padding: 28px 20px !important; }
        section.pelatihan-section .pelatihan-card h3 { font-size: 17px !important; }
        section.pelatihan-section .pelatihan-card p { font-size: 13px !important; }
    }
</style>


{{-- ===== 3. NEWS (BERITA) ===== --}}
<section class="news-section" id="berita">
    <div class="container">
        <div class="section-title" style="text-align:center; margin-bottom:44px;">
            <h2>Berita & Info Terkini</h2>
            <p style="max-width:560px; margin:0 auto;">Informasi terbaru seputar kegiatan dan program Rumah Bahasa Surabaya</p>
        </div>
        {{-- ===== COVERFLOW 3D CAROUSEL ===== --}}
        @php
            // Gambar sementara untuk berita tanpa foto (pakai foto rumbas)
            $gambarBeritaCadangan = [
                asset('images/rumbas.jpg'),
                asset('images/rumbas2.jpeg'),
                asset('images/rumbas3.jpeg'),
                asset('images/rumbas4.jpeg'),
            ];
            $beritaArr = $berita->values();
            $beritaJson = $beritaArr->map(function ($item, $idx) use ($gambarBeritaCadangan) {
                return [
                    'judul' => $item->judul,
                    'tanggal' => \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY'),
                    'deskripsi' => Str::limit(strip_tags($item->ringkasan ?: $item->isi), 140),
                    'isi' => $item->isi,
                    'gambar' => $item->gambar
                        ? asset('images/berita/' . $item->gambar)
                        : $gambarBeritaCadangan[$idx % 4],
                ];
            })->values();
        @endphp
        @if($beritaArr->count())
            <div class="cf-carousel" id="news-coverflow" data-count="{{ $beritaArr->count() }}">
                <div class="cf-carousel-inner">
                    <button type="button" class="cf-nav-btn cf-prev" aria-label="Berita sebelumnya">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    </button>

                    <div class="cf-main">
                        <div class="cf-stage">
                            @foreach($beritaArr as $i => $item)
                                <div class="cf-card" data-index="{{ $i }}">
                                    <div class="cf-card-img">
                                        @if($item->gambar)
                                            <img src="{{ asset('images/berita/'.$item->gambar) }}" alt="{{ $item->judul }}">
                                        @else
                                            <img src="{{ $gambarBeritaCadangan[$i % 4] }}" alt="{{ $item->judul }}">
                                        @endif
                                    </div>
                                    <div class="cf-card-body">
                                        <div class="cf-card-date">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</div>
                                        <h3>{{ $item->judul }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Deskripsi Dinamis --}}
                        <div class="cf-caption">
                            <div class="cf-caption-date" id="cf-caption-date"></div>
                            <h3 class="cf-caption-title" id="cf-caption-title"></h3>
                            <p class="cf-caption-desc" id="cf-caption-desc"></p>
                        </div>
                    </div>

                    <button type="button" class="cf-nav-btn cf-next" aria-label="Berita berikutnya">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>

                {{-- Pagination dots --}}
                <div class="cf-dots"></div>
            </div>

            {{-- Data berita untuk modal (JSON aman dari kutip/HTML) --}}
            <script type="application/json" id="cf-berita-data">
                @json($beritaJson)
            </script>

            {{-- ===== MODAL DETAIL BERITA ===== --}}
            <div class="cf-modal-overlay" id="berita-modal" aria-hidden="true">
                <div class="cf-modal" role="dialog" aria-modal="true" aria-label="Detail berita">
                    <button type="button" class="cf-modal-close" id="berita-modal-close" aria-label="Tutup">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    <div class="cf-modal-content" id="berita-modal-content"></div>
                </div>
            </div>
        @else
            <div class="news-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <p>Belum ada berita.</p>
            </div>
        @endif
        <div style="text-align:center;margin-top:32px;margin-bottom:24px;">
            <a href="{{ route('berita.list') }}" style="display:inline-flex;align-items:center;gap:8px;color:#ffffff;font-weight:600;font-size:14px;text-decoration:none;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.25);padding:12px 32px;border-radius:50px;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.22)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                Lihat selengkapnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ===== STYLE COVERFLOW 3D CAROUSEL ===== --}}
<style>
    /* ===== Coverflow 3D Carousel ===== */
    #news-coverflow {
        position: relative;
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        perspective: 1400px;
    }

    .cf-carousel-inner {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
    }

    .cf-main {
        flex: 1;
        min-width: 0;
        max-width: 720px;
    }

    .cf-stage {
        position: relative;
        width: 100%;
        height: 320px;
        transform-style: preserve-3d;
    }

    .cf-card {
        position: absolute;
        top: 0;
        left: 50%;
        width: 300px;
        height: 300px;
        margin-left: -150px;
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        text-decoration: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        transform-style: preserve-3d;
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.7s ease, filter 0.7s ease;
        will-change: transform, opacity;
        cursor: pointer;
    }

    .cf-card-img {
        height: 170px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--teal-100), var(--teal-50));
    }
    .cf-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .cf-card-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--teal-400);
    }

    .cf-card-body {
        padding: 14px 18px;
    }
    .cf-card-date {
        font-size: 11px;
        color: var(--teal-500);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    .cf-card-body h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1.4;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ===== Posisi card: active, kiri, kanan ===== */
    .cf-card.cf-active {
        transform: translateX(0) scale(1) rotateY(0deg);
        opacity: 1;
        z-index: 30;
        filter: brightness(1);
    }
    .cf-card.cf-left-1 {
        transform: translateX(-62%) scale(0.78) rotateY(35deg);
        opacity: 0.6;
        z-index: 20;
        filter: brightness(0.85);
    }
    .cf-card.cf-right-1 {
        transform: translateX(62%) scale(0.78) rotateY(-35deg);
        opacity: 0.6;
        z-index: 20;
        filter: brightness(0.85);
    }
    .cf-card.cf-left-2 {
        transform: translateX(-110%) scale(0.6) rotateY(45deg);
        opacity: 0.25;
        z-index: 10;
        filter: brightness(0.6);
    }
    .cf-card.cf-right-2 {
        transform: translateX(110%) scale(0.6) rotateY(-45deg);
        opacity: 0.25;
        z-index: 10;
        filter: brightness(0.6);
    }
    .cf-card.cf-hidden {
        opacity: 0;
        transform: translateX(0) scale(0.4) rotateY(60deg);
        z-index: 1;
        pointer-events: none;
    }

    /* ===== Caption dinamis di bawah card ===== */
    .cf-caption {
        text-align: center;
        min-height: 110px;
        max-width: 620px;
        margin: 16px auto 0;
        padding: 0 16px;
        color: #ffffff;
    }
    .cf-caption-date {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.75);
        margin-bottom: 6px;
    }
    .cf-caption-title {
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 6px;
        line-height: 1.35;
    }
    .cf-caption-desc {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.6;
        margin: 0 auto;
        max-width: 560px;
        text-align: center;
    }

    /* ===== Controls: Prev/Next di samping + Dots di bawah ===== */
    .cf-nav-btn {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        flex-shrink: 0;
        z-index: 40;
    }
    .cf-nav-btn:hover {
        background: #ffffff;
        color: #0c4e91;
        border-color: #ffffff;
        transform: scale(1.08);
    }
    .cf-nav-btn:active { transform: scale(0.95); }
    .cf-dots {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 20px;
    }
    .cf-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.35);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .cf-dot.cf-dot-active {
        width: 26px;
        border-radius: 50px;
        background: #ffffff;
    }
    .cf-dot:hover { background: rgba(255, 255, 255, 0.7); }

    /* ===== Modal Detail Berita ===== */
    .cf-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(2, 6, 23, 0.75);
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.35s ease, visibility 0.35s ease;
    }
    .cf-modal-overlay.cf-open {
        opacity: 1;
        visibility: visible;
    }
    .cf-modal {
        position: relative;
        width: 100%;
        max-width: 720px;
        max-height: 86vh;
        background: #0f1e2e;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        transform: translateY(24px) scale(0.96);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .cf-modal-overlay.cf-open .cf-modal {
        transform: translateY(0) scale(1);
    }
    .cf-modal-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.25s ease;
    }
    .cf-modal-close:hover {
        background: #dc2626;
        transform: rotate(90deg);
    }
    .cf-modal-content {
        max-height: 86vh;
        overflow-y: auto;
        color: #e2e8f0;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.3) transparent;
    }
    .cf-modal-content::-webkit-scrollbar { width: 8px; }
    .cf-modal-content::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 8px;
    }
    .cf-modal-img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, var(--teal-100), var(--teal-50));
    }
    .cf-modal-img-placeholder {
        width: 100%;
        height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e3a5f, #0f1e2e);
        color: rgba(255,255,255,0.5);
    }
    .cf-modal-body {
        padding: 28px 32px 36px;
    }
    .cf-modal-date {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #5eead4;
        margin-bottom: 8px;
    }
    .cf-modal-body h3 {
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.35;
        margin: 0 0 16px;
    }
    .cf-modal-desc {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.75;
        margin: 0 0 16px;
    }
    .cf-modal-isi {
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        padding-top: 16px;
        font-size: 14.5px;
        color: #cbd5e1;
        line-height: 1.8;
    }
    .cf-modal-isi p { margin: 0 0 12px; }

    /* ===== Responsive ===== */
    @media (max-width: 640px) {
        .cf-modal-body { padding: 20px 18px 28px; }
        .cf-modal-body h3 { font-size: 19px; }
        .cf-modal-img, .cf-modal-img-placeholder { height: 180px; }
        .cf-modal { max-height: 88vh; }
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .cf-carousel-inner { gap: 6px; }
        .cf-stage { height: 280px; }
        .cf-card { width: 230px; height: 260px; margin-left: -115px; }
        .cf-card-img { height: 140px; }
        .cf-card-body h3 { font-size: 14px; }
        .cf-nav-btn { width: 40px; height: 40px; }
        .cf-card.cf-left-1 { transform: translateX(-70%) scale(0.78) rotateY(35deg); }
        .cf-card.cf-right-1 { transform: translateX(70%) scale(0.78) rotateY(-35deg); }
        .cf-card.cf-left-2, .cf-card.cf-right-2 { opacity: 0; pointer-events: none; }
    }
    @media (max-width: 480px) {
        .cf-stage { height: 240px; }
        .cf-card { width: 200px; height: 230px; margin-left: -100px; }
        .cf-card-img { height: 120px; }
        .cf-caption { min-height: 100px; }
        .cf-caption-title { font-size: 16px; }
        .cf-caption-desc { font-size: 13px; }
        .cf-nav-btn { width: 36px; height: 36px; }
        .cf-nav-btn svg { width: 16px; height: 16px; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('news-coverflow');
    if (!carousel) return;
    const cards = Array.from(carousel.querySelectorAll('.cf-card'));
    if (cards.length === 0) return;

    let current = 0;
    const total = cards.length;
    const captionDate = document.getElementById('cf-caption-date');
    const captionTitle = document.getElementById('cf-caption-title');
    const captionDesc = document.getElementById('cf-caption-desc');
    const dotsWrap = carousel.querySelector('.cf-dots');

    // Data berita (dari JSON yang dirender Blade)
    let beritaData = [];
    try {
        const jsonEl = document.getElementById('cf-berita-data');
        if (jsonEl) beritaData = JSON.parse(jsonEl.textContent);
    } catch (e) {
        beritaData = [];
    }

    // Build dots
    cards.forEach(function(_, idx) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'cf-dot';
        dot.setAttribute('aria-label', 'Ke berita ' + (idx + 1));
        dot.addEventListener('click', function() { goTo(idx); });
        dotsWrap.appendChild(dot);
    });
    const dots = Array.from(dotsWrap.querySelectorAll('.cf-dot'));

    function render() {
        cards.forEach(function(card, idx) {
            card.classList.remove('cf-active', 'cf-left-1', 'cf-right-1', 'cf-left-2', 'cf-right-2', 'cf-hidden');
            let diff = (idx - current + total) % total;
            if (diff > total / 2) diff -= total;
            if (diff === 0) {
                card.classList.add('cf-active');
            } else if (diff === -1 || (diff === 1 && total === 2)) {
                card.classList.add('cf-left-1');
            } else if (diff === 1) {
                card.classList.add('cf-right-1');
            } else if (diff === -2) {
                card.classList.add('cf-left-2');
            } else if (diff === 2) {
                card.classList.add('cf-right-2');
            } else {
                card.classList.add('cf-hidden');
            }
        });

        // Update dots
        dots.forEach(function(dot, idx) {
            dot.classList.toggle('cf-dot-active', idx === current);
        });

        // Update caption
        const active = beritaData[current] || {};
        captionDate.textContent = active.tanggal || '';
        captionTitle.textContent = active.judul || '';
        captionDesc.textContent = active.deskripsi || '';
    }

    function goTo(idx) {
        current = (idx + total) % total;
        render();
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    carousel.querySelector('.cf-prev').addEventListener('click', prev);
    carousel.querySelector('.cf-next').addEventListener('click', next);

    // Keyboard & swipe
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prev();
        if (e.key === 'ArrowRight') next();
    });

    let touchStartX = 0;
    const stage = carousel.querySelector('.cf-stage');
    stage.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });
    stage.addEventListener('touchend', function(e) {
        const deltaX = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(deltaX) > 40) {
            if (deltaX < 0) next(); else prev();
        }
    }, { passive: true });

    // Auto-play
    let autoplay = setInterval(next, 5000);
    carousel.addEventListener('mouseenter', function() { clearInterval(autoplay); });
    carousel.addEventListener('mouseleave', function() { autoplay = setInterval(next, 5000); });

    // ===== MODAL DETAIL BERITA =====
    const modalOverlay = document.getElementById('berita-modal');
    const modalClose = document.getElementById('berita-modal-close');
    const modalContent = document.getElementById('berita-modal-content');
    let modalOpen = false;

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str == null ? '' : String(str);
        return div.innerHTML;
    }

    function openModal(idx) {
        const data = beritaData[idx] || {};
        const img = data.gambar || '';
        const isi = data.isi || '';

        let imgHtml = img
            ? '<img src="' + img + '" alt="' + escapeHtml(data.judul) + '" class="cf-modal-img">'
            : '<div class="cf-modal-img-placeholder"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>';

        modalContent.innerHTML =
            imgHtml +
            '<div class="cf-modal-body">' +
                '<div class="cf-modal-date">' + escapeHtml(data.tanggal) + '</div>' +
                '<h3>' + escapeHtml(data.judul) + '</h3>' +
                '<p class="cf-modal-desc">' + escapeHtml(data.deskripsi) + '</p>' +
                (isi ? '<div class="cf-modal-isi"><p>' + escapeHtml(isi).replace(/\n/g, '</p><p>') + '</p></div>' : '') +
            '</div>';

        modalOpen = true;
        modalOverlay.classList.add('cf-open');
        modalOverlay.setAttribute('aria-hidden', 'false');
        clearInterval(autoplay);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        if (!modalOpen) return;
        modalOpen = false;
        modalOverlay.classList.remove('cf-open');
        modalOverlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    cards.forEach(function(card, idx) {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            openModal(idx);
        });
    });

    modalClose.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalOpen) closeModal();
    });

    render();
});
</script>

{{-- Style Khusus Section News --}}
<style>
    section.news-section {
        background: linear-gradient(135deg, #0c4e91 0%, #0167a2 55%, #1680bd 100%) !important;
        padding: 60px 0 10px !important;
        position: relative !important;
        overflow: visible !important;
    }

    section.news-section .section-title {
        margin-bottom: 44px !important;
    }

    section.news-section .section-title h2 {
        color: #ffffff !important;
        font-size: 34px !important;
        font-weight: 700 !important;
        margin-bottom: 12px !important;
        display: inline-block;
        background: linear-gradient(90deg, #ffffff 0%, #7dd3fc 20%, #ffffff 40%, #bfe3ff 60%, #ffffff 80%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: newsTitleFlow 4s linear infinite, newsTitleZoom 6s ease-in-out infinite;
    }

    @keyframes newsTitleFlow {
        from { background-position: 0% center; }
        to { background-position: -200% center; }
    }

    /* Zoom out lambat & smooth pada judul (bukan bounce) */
    @keyframes newsTitleZoom {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(0.92);
            opacity: 0.85;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        section.news-section .section-title h2 {
            animation: none;
            background: none;
            -webkit-text-fill-color: #ffffff;
        }
    }

    section.news-section .section-title p {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 16px !important;
        line-height: 1.6 !important;
    }

    @media (max-width: 640px) {
        section.news-section {
            padding: 40px 0 10px !important;
        }

        section.news-section .section-title {
            margin-bottom: 32px !important;
        }

        /* Judul Section di Mobile */
        .section-title h2 {
            font-size: 20px !important;
            margin-bottom: 8px !important;
        }

        .section-title p {
            font-size: 13px !important;
            line-height: 1.5 !important;
            margin-bottom: 16px !important;
        }
    }
</style>

{{-- Style Gradasi Halus & Pemangkas Whitespace --}}
<style>
    /* Background hero dibuat langsung bergradasi halus dari biru ke putih */
    section.hero {
        background: linear-gradient(180deg, #3897e0 0%, #5cb0f2 60%, #ffffff 100%) !important;
        padding-bottom: 30px !important;
        margin-bottom: 0 !important;
    }

    /* Section news dengan latar biru ala MEA (padding & radius diatur di style section news) */
    section.news-section {
        background: linear-gradient(135deg, #0c4e91 0%, #0167a2 55%, #1680bd 100%) !important;
    }

    @media (max-width: 640px) {
        section.hero {
            padding-bottom: 20px !important;
        }
    }
</style>

{{-- ===== BANNER MEA & AFTA ===== --}}
{{-- Dipindah ke halaman /profil (dibuka lewat tombol "Lihat selengkapnya" di section Tentang Rumah Bahasa) --}}

{{-- Wave Separator dari News ke About --}}
<div class="news-to-about-wave">
    <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,80C1248,85,1344,75,1392,70L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="#ffffff"/>
    </svg>
</div>

<style>
    /* Khusus wave pembatas News -> About */
    .news-to-about-wave {
        background-color: #f8fafc !important; /* Warna kontras di belakang wave */
        line-height: 0 !important;
        font-size: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
        width: 100%;
    }

    .news-to-about-wave svg {
        display: block !important;
        width: 100% !important;
        height: 50px !important; /* Tinggi wave yang ideal */
        margin: 0 !important;
        padding: 0 !important;
    }

    @media (max-width: 640px) {
        .news-to-about-wave svg {
            height: 35px !important; /* Pas & proporsional di HP */
        }
    }
</style>

{{-- ===== 4. ABOUT (TENTANG) ===== --}}
<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-content fade-up" style="opacity:0;transform:translateY(30px);">
                <h2>Tentang <span style="color: #035277;">Rumah Bahasa</span> Surabaya</h2>
                <p>Rumah Bahasa Surabaya adalah program unggulan Dinas Perpustakaan dan Kearsipan Kota Surabaya yang bertujuan meningkatkan literasi dan pembelajaran masyarakat.</p>
                <p>Kami menyediakan berbagai program mulai dari pojok baca, kelas bahasa, pelatihan keterampilan, hingga kegiatan pelestarian bahasa daerah Surabaya.</p>
                <div style="margin-top:16px;">
                    <a href="{{ route('profil') }}" style="display:inline-flex;align-items:center;gap:8px;color:#fff;font-weight:600;font-size:14px;text-decoration:none;background:#0c4e91;padding:12px 28px;border-radius:8px;transition:background 0.2s;" onmouseover="this.style.background='#4d9ce2'" onmouseout="this.style.background='#0c4e91'">
                        Lihat selengkapnya
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
            <div class="about-visual fade-up" style="opacity:0;transform:translateY(30px);transition-delay:0.15s;">
                <div class="orbit-container" id="orbit-container">
                    {{-- Ring orbit konsentris --}}
                    <div class="orbit-ring orbit-ring-1"></div>
                    <div class="orbit-ring orbit-ring-2"></div>

                    {{-- Pusat: logo Rumah Bahasa (1 logo saja) + glow biru --}}
                    <div class="orbit-center">
                        <div class="orbit-center-glow"></div>
                        <div class="orbit-center-icon" id="orbit-center-icon">
                            <img src="{{ asset('images/logo-rumbas.jpg') }}" alt="Logo Rumah Bahasa">
                        </div>
                    </div>

                    {{-- Cincin bendera: semua bendera bahasa yang tersedia, muter pelan mengelilingi logo --}}
                    <div class="orbit-flags" id="orbit-flags">
                        @php
                            $bendera = [
                                'flag-id.png' => 'Bendera Indonesia',
                                'flag-jp.png' => 'Bendera Jepang',
                                'flag-kr.png' => 'Bendera Korea',
                                'flag-sa.png' => 'Bendera Arab Saudi',
                                'flag-cn.png' => 'Bendera Tiongkok',
                                'flag-th.png' => 'Bendera Thailand',
                                'flag-ph.png' => 'Bendera Filipina',
                                'flag-uk.png' => 'Bendera Inggris',
                                'flag-fr.png' => 'Bendera Prancis',
                                'flag-de.png' => 'Bendera Jerman',
                                'flag-nl.png' => 'Bendera Belanda',
                                'flag-es.png' => 'Bendera Spanyol',
                                'flag-ru.png' => 'Bendera Rusia',
                            ];
                        @endphp
                        @foreach($bendera as $file => $alt)
                            <div class="orbit-flag" style="--i: {{ $loop->index }}; --n: {{ count($bendera) }};">
                                <img src="{{ asset('images/' . $file) }}" alt="{{ $alt }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Style Khusus Section About & Responsif Mobile --}}
<style>
    section.about {
        padding: 20px 0 !important; /* Memangkas whitespace atas-bawah */
        background: #ffffff;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: center;
    }

    /* ===== ORBIT INTERAKTIF (Radar/Orbit Pulse) ===== */
    .orbit-container {
        position: relative;
        width: 420px;
        height: 420px;
        margin: 0 auto;
    }

    .orbit-ring {
        position: absolute;
        border-radius: 50%;
        border: 1.5px dashed rgba(8, 130, 196, 0.25);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    .orbit-ring-1 { width: 300px; height: 300px; border: 1.5px dashed rgba(8, 130, 196, 0.35); animation: ringRotateSync 60s linear infinite; }
    .orbit-ring-2 { width: 210px; height: 210px; border-style: solid; border-color: rgba(8, 130, 196, 0.12); animation: orbitSpin 60s linear infinite reverse; }
    @keyframes orbitSpin { from { transform: translate(-50%, -50%) rotate(0deg); } to { transform: translate(-50%, -50%) rotate(360deg); } }
    /* Ring putus-putus muter SAMA dengan cincin bendera → titik-titik selalu di bawah bendera */
    @keyframes ringRotateSync { from { transform: translate(-50%, -50%) rotate(0deg); } to { transform: translate(-50%, -50%) rotate(360deg); } }

    /* Pusat: glow biru + ripple, bulat */
    .orbit-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100px;
        height: 100px;
        z-index: 5;
    }
    .orbit-center-glow {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(34, 211, 238, 0.9) 0%, rgba(8, 130, 196, 0.75) 55%, rgba(2, 84, 140, 0.5) 100%);
        box-shadow: 0 0 40px rgba(34, 211, 238, 0.55), 0 0 80px rgba(8, 130, 196, 0.35);
        animation: centerPulse 2.4s ease-out infinite;
    }
    @keyframes centerPulse {
        0% { box-shadow: 0 0 20px rgba(34, 211, 238, 0.45), 0 0 50px rgba(8, 130, 196, 0.3); transform: scale(1); }
        50% { box-shadow: 0 0 45px rgba(34, 211, 238, 0.7), 0 0 90px rgba(8, 130, 196, 0.5); transform: scale(1.05); }
        100% { box-shadow: 0 0 20px rgba(34, 211, 238, 0.45), 0 0 50px rgba(8, 130, 196, 0.3); transform: scale(1); }
    }
    .orbit-center-icon {
        position: absolute;
        inset: 12px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.45s ease;
    }
    .orbit-center-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ===== CINCIN BENDERA: bendera duduk tepat di ring putus-putus & tetap tegak saat muter ===== */
    .orbit-flags {
        position: absolute;
        inset: 0;
        animation: flagsRotate 60s linear infinite;
    }
    .orbit-flags:hover { animation-play-state: paused; }
    @keyframes flagsRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .orbit-flag {
        --size: 42px;   /* ukuran bendera */
        --r: 150px;     /* radius ring putus-putus (ring-1) */
        position: absolute;
        top: 50%;
        left: 50%;
        width: var(--size);
        height: var(--size);
        /* Geser setengah ukuran ke kiri-atas: titik tengah bendera tepat di pusat container */
        margin: calc(var(--size) / -2) 0 0 calc(var(--size) / -2);
        /* Posisi melingkar dengan radius --r; rotate balik bikin posisi awal tegak */
        transform: rotate(calc(var(--i) * 360deg / var(--n))) translateY(calc(-1 * var(--r))) rotate(calc(var(--i) * -360deg / var(--n)));
    }
    .orbit-flag:hover { z-index: 8; }

    .orbit-flag img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        border-radius: 6px;
        box-shadow: 0 3px 10px rgba(2, 84, 140, 0.15);
        background: #fff;
        /* Putar balik secepat ring berputar → bendera selalu tegak (tidak ikut miring) */
        animation: flagsRotateReverse 60s linear infinite;
    }
    .orbit-flags:hover .orbit-flag img { animation-play-state: paused; }
    @keyframes flagsRotateReverse {
        from { transform: rotate(0deg); }
        to { transform: rotate(-360deg); }
    }

    @media (max-width: 640px) {
        section.about {
            padding-top: 10px !important;
            padding-bottom: 15px !important;
        }

        .about-grid {
            grid-template-columns: 1fr;
            gap: 16px !important;
        }

        .about-content h2 {
            font-size: 20px !important;
            line-height: 1.3 !important;
            margin-bottom: 10px !important;
        }

        .about-content p {
            font-size: 13px !important;
            line-height: 1.5 !important;
            margin-bottom: 8px !important;
        }

        .orbit-container {
            width: 300px;
            height: 300px;
            margin-top: 10px;
        }
        .orbit-ring-1 { width: 215px; height: 215px; }
        .orbit-ring-2 { width: 150px; height: 150px; }
        .orbit-center { width: 76px; height: 76px; }
        .orbit-flag { --size: 30px; --r: 107px; }
    }
</style>

{{-- Wave separator: gelombang tetap terlihat, warnanya sama dengan section Hubungi Kami --}}
<div class="wave-separator" style="background:var(--white); margin-bottom:-2px;">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C320,100 480,0 720,40 C960,80 1120,0 1440,40 L1440,80 L0,80 Z" fill="#0c4e91"/>
    </svg>
</div>

{{-- ===== 5. KOTAK PESAN (MESSAGE FORM) - PALING BAWAH ===== --}}
<section class="message-section" id="kontak" style="background: #0c4e91; padding: 60px 0 100px 0; position: relative; overflow: hidden;">
    {{-- Ornamen Dekoratif Minimalis / Floating Shapes --}}
    <div class="ornament-blur" style="position: absolute; top: -10%; left: -5%; width: 300px; height: 300px; background: rgba(255,255,255,0.03); border-radius: 50%; filter: blur(40px); pointer-events: none;"></div>
    <div class="ornament-blur" style="position: absolute; bottom: -10%; right: -5%; width: 400px; height: 400px; background: rgba(0,0,0,0.15); border-radius: 50%; filter: blur(60px); pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 3; max-width: 800px; margin: 0 auto; padding: 0 20px;">
        <div class="section-title" style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: var(--white); font-size: 2.25rem; font-weight: 700; margin-bottom: 12px; letter-spacing: -0.5px;">Hubungi <span style="color: #7dd3fc;">Kami</span></h2>
            <p style="color: rgb(240, 244, 247); font-size: 1rem; max-width: 500px; margin: 0 auto;">Punya pertanyaan atau masukan? Kirimkan pesanmu langsung di bawah ini.</p>
        </div>

        {{-- Card Form Premium: gradient + glow shadow + animasi floating halus --}}
        <div class="form-container" style="background: linear-gradient(160deg, #ffffff 0%, #f0f7ff 60%, #e3effb 100%); padding: 40px; border-radius: 24px; border: 1px solid rgba(255,255,255,0.7); box-shadow: 0 24px 60px rgba(2, 42, 84, 0.35), 0 0 0 1px rgba(22, 128, 189, 0.08), 0 0 40px rgba(78, 165, 237, 0.15); animation: formFloat 3.5s ease-in-out infinite; position: relative;">
            @if(session('success'))
                <div style="background: rgba(94, 197, 234, 0.15); border: 1px solid rgba(94, 187, 234, 0.3); color: #0c4e91; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #b91c1c; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('kontak.kirim') }}" method="POST" class="contact-form" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                <div class="form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
                    <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                        <label for="nama" style="color: #1e293b; font-size: 0.9rem; font-weight: 600;">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama kamu" required
                            style="width: 100%; padding: 14px 18px; background: #f8fafc; border: 1.5px solid #dbe4f0; border-radius: 10px; color: #1e293b; font-size: 0.95rem; transition: all 0.3s ease; outline: none;">
                    </div>
                    <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                        <label for="email" style="color: #1e293b; font-size: 0.9rem; font-weight: 600;">Alamat Email/ No telepon</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com / 0812345678" required
                            style="width: 100%; padding: 14px 18px; background: #f8fafc; border: 1.5px solid #dbe4f0; border-radius: 10px; color: #1e293b; font-size: 0.95rem; transition: all 0.3s ease; outline: none;">
                    </div>
                </div>

                <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="subjek" style="color: #1e293b; font-size: 0.9rem; font-weight: 600;">Subjek</label>
                    <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" placeholder="Topik pesan"
                        style="width: 100%; padding: 14px 18px; background: #f8fafc; border: 1.5px solid #dbe4f0; border-radius: 10px; color: #1e293b; font-size: 0.95rem; transition: all 0.3s ease; outline: none;">
                </div>

                <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="pesan" style="color: #1e293b; font-size: 0.9rem; font-weight: 600;">Pesan Anda</label>
                    <textarea id="pesan" name="pesan" rows="4" placeholder="Tuliskan pertanyaan atau aspirasimu di sini..." required
                        style="width: 100%; padding: 14px 18px; background: #f8fafc; border: 1.5px solid #dbe4f0; border-radius: 10px; color: #1e293b; font-size: 0.95rem; font-family: inherit; transition: all 0.3s ease; outline: none; resize: vertical;"></textarea>
                </div>

                <div style="text-align: right; margin-top: 4px;">
                    <button type="submit" style="background: linear-gradient(135deg, #0c4e91 0%, #0167a2 55%, #1680bd 100%); color: #ffffff; font-weight: 600; padding: 12px 28px; border: none; border-radius: 10px; cursor: pointer; font-size: 0.95rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(2, 42, 84, 0.4);">
                        Kirim Pesan
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polyline points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- CSS Tambahan Khusus Responsive & Compact Mobile Form --}}
<style>
    /* Placeholder dengan warna Abu-abu Muda */
    .input-group input::placeholder,
    .input-group textarea::placeholder {
        color: #94a3b8 !important;
        opacity: 1;
    }
    .input-group input::-webkit-input-placeholder,
    .input-group textarea::-webkit-input-placeholder {
        color: #94a3b8 !important;
    }

    /* Focus State */
    .input-group input:focus, .input-group textarea:focus {
        border-color: #1680bd !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(22, 128, 189, 0.15);
        color: #1e293b !important;
    }

    /* Hover Button */
    .form-container button:hover {
        background: linear-gradient(135deg, #0a3f7a 0%, #0167a2 55%, #1273ab 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(2, 42, 84, 0.45) !important;
    }

    /* Animasi floating card form — gerakan jelas kelihatan (naik-turun 18px) */
    @keyframes formFloat {
        0%, 100% { transform: translateY(0); }
        25% { transform: translateY(-16px); }
        50% { transform: translateY(0); }
        75% { transform: translateY(-8px); }
    }

    /* Glow halus saat hover card form */
    .form-container:hover {
        box-shadow: 0 28px 70px rgba(2, 42, 84, 0.4), 0 0 0 1px rgba(22, 128, 189, 0.12), 0 0 60px rgba(78, 165, 237, 0.25) !important;
    }

    /* Penyesuaian Khusus Tampilan Mobile (Compact & Aspect-Ratio Friendly) */
    @media (max-width: 640px) {
        section.message-section {
            padding: 30px 0 50px 0 !important;
        }

        /* Batasi lebar maksimum container mobile biar proporsi 3:4 terjaga */
        section.message-section .container {
            max-width: 90% !important;
            padding: 0 10px !important;
        }

        section.message-section .section-title {
            margin-bottom: 20px !important;
        }
        section.message-section .section-title h2 {
            font-size: 1.5rem !important;
            margin-bottom: 6px !important;
        }
        section.message-section .section-title p {
            font-size: 0.85rem !important;
        }

        /* Card form dipadatkan */
        .form-container {
            padding: 20px 18px !important;
            border-radius: 16px !important;
            aspect-ratio: 3 / 4; /* Menjaga rasio 3:4 jika layar mendukung */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Kompres jarak antar elemen form */
        .contact-form {
            gap: 12px !important;
        }

        .form-container .form-grid {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .input-group {
            gap: 4px !important;
        }

        .input-group label {
            font-size: 0.8rem !important;
        }

        /* Input & Textarea lebih tipis */
        .form-container input {
            padding: 9px 12px !important;
            font-size: 0.875rem !important;
            border-radius: 8px !important;
        }

        .form-container textarea {
            padding: 9px 12px !important;
            font-size: 0.875rem !important;
            border-radius: 8px !important;
            rows: 3 !important;
            height: 80px !important; /* Dikecilkan biar nggak makan tempat */
        }

        .form-container button[type="submit"] {
            width: 100% !important;
            padding: 11px 20px !important;
            font-size: 0.9rem !important;
            justify-content: center !important;
        }
    }
</style>

@endsection