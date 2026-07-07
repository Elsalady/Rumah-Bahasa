@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Rumah Belajar Surabaya — pusat literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero-pattern"></div>
    <div class="container" style="position:relative;z-index:2;width:100%;">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Dinas Perpustakaan dan Kearsipan Kota Surabaya
            </div>
            <h1>Selamat Datang di <span>Rumah Belajar</span> Surabaya</h1>
            <p>Pusat literasi dan pembelajaran untuk masyarakat Surabaya. Mari bersama tingkatkan budaya literasi dan cinta bahasa.</p>
            <div class="search-box">
                <input type="text" placeholder="Cari informasi, berita, atau layanan..." aria-label="Cari">
                <button type="submit">Cari</button>
            </div>
        </div>
    </div>
</section>

{{-- Wave Separator --}}
<div class="wave-separator" style="background:var(--white);">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C320,100 480,0 720,40 C960,80 1120,0 1440,40 L1440,80 L0,80 Z" fill="var(--teal-900)" opacity="0.03"/>
        <path d="M0,30 C360,80 540,10 720,30 C900,50 1080,10 1440,30 L1440,80 L0,80 Z" fill="var(--white)"/>
    </svg>
</div>

{{-- ===== ABOUT ===== --}}
<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-content fade-up" style="opacity:0;transform:translateY(30px);">
                <h2>Tentang <span>Rumah Belajar</span> Surabaya</h2>
                <p>Rumah Belajar Surabaya adalah program unggulan Dinas Perpustakaan dan Kearsipan Kota Surabaya yang bertujuan meningkatkan literasi dan pembelajaran masyarakat.</p>
                <p>Kami menyediakan berbagai layanan mulai dari pojok baca, kelas bahasa, pelatihan keterampilan, hingga kegiatan pelestarian bahasa daerah Surabaya.</p>
            </div>
            <div class="about-visual fade-up" style="opacity:0;transform:translateY(30px);transition-delay:0.15s;">
                <div class="icon-circle">
                    <div class="icon-circle-ring"></div>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        <path d="M12 19.5v-2" stroke-width="2"/>
                        <circle cx="12" cy="12" r="1.5" fill="currentColor"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Wave Separator --}}
<div class="wave-separator" style="background:var(--gray-50);">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,50 C240,10 480,90 720,50 C960,10 1200,90 1440,50 L1440,80 L0,80 Z" fill="var(--white)"/>
    </svg>
</div>

{{-- ===== NEWS ===== --}}
<section class="news-section" id="berita">
    <div class="container">
        <div class="section-title">
            <h2>Berita & Info Terkini</h2>
            <p>Informasi terbaru seputar kegiatan dan program Rumah Belajar Surabaya</p>
        </div>
        <div class="news-grid">
            @forelse($berita as $item)
                <article class="news-card fade-up" style="opacity:0;transform:translateY(30px);transition-delay:{{ $loop->index * 0.1 }}s;">
                    <div class="news-card-img">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div class="news-card-body">
                        <div class="news-card-date">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ Str::limit($item->ringkasan ?: strip_tags($item->isi), 120) }}</p>
                    </div>
                </article>
            @empty
                <div class="news-empty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    <p>Belum ada berita.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Wave Separator --}}
<div class="wave-separator" style="background:var(--white);">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C360,100 720,-10 1080,40 C1260,65 1350,35 1440,40 L1440,80 L0,80 Z" fill="var(--gray-50)"/>
    </svg>
</div>

{{-- ===== FEATURES ===== --}}
<section class="features" id="layanan">
    <div class="container">
        <div class="section-title">
            <h2>Layanan Kami</h2>
            <p>Berbagai program dan fasilitas yang tersedia untuk masyarakat</p>
        </div>
        <div class="features-grid">
            <div class="feature-card fade-up" style="opacity:0;transform:translateY(30px);">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="7" x2="16" y2="7"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                </div>
                <h3>Pojok Baca</h3>
                <p>Koleksi buku bahasa daerah, nasional, dan internasional yang nyaman dibaca.</p>
            </div>
            <div class="feature-card fade-up" style="opacity:0;transform:translateY(30px);transition-delay:0.1s;">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                </div>
                <h3>Kelas Bahasa</h3>
                <p>Kelas bahasa asing, bahasa daerah, dan pelatihan menulis untuk semua usia.</p>
            </div>
            <div class="feature-card fade-up" style="opacity:0;transform:translateY(30px);transition-delay:0.2s;">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                </div>
                <h3>Kegiatan Budaya</h3>
                <p>Lomba bercerita, menulis aksara Jawa, dan festival literasi bahasa secara rutin.</p>
            </div>
        </div>
    </div>
</section>

{{-- Wave to footer --}}
<div class="wave-separator" style="margin-bottom:-2px;">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C320,100 480,0 720,40 C960,80 1120,0 1440,40 L1440,80 L0,80 Z" fill="var(--teal-900)"/>
    </svg>
</div>

@endsection
