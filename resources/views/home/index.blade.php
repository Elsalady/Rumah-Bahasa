@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Rumah Bahasa Surabaya — pusat literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')

@section('content')


{{-- ===== 1. HERO (BERANDA) ===== --}}
<section class="hero" style="
    position: relative !important;
    background: 
        linear-gradient(
            180deg, 
            rgba(56, 151, 224, 0.1) 0%, 
            rgba(56, 151, 224, 0.75) 50%, 
            rgba(56, 151, 224, 1) 85%, 
            #ffffff 100%
        ), 
        url('{{ asset('images/elsa.jpg') }}') center / cover no-repeat !important;
    padding-bottom: 30px !important;
    margin-bottom: 0 !important;
">
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
    opacity: 0.95;
    text-align: center;
">
    Pusat literasi dan pembelajaran untuk masyarakat Surabaya. Mari bersama tingkatkan budaya literasi dan cinta bahasa.
</p>
            <form class="search-box" action="{{ route('berita.list') }}" method="GET">
                <input type="text" name="q" placeholder="Cari informasi, berita, atau layanan..." aria-label="Cari">
                <button type="submit">Cari</button>
            </form>
        </div>
    </div>
</section>


{{-- ===== 3. NEWS (BERITA) ===== --}}
<section class="news-section" id="berita">
    <div class="container">
        <div class="section-title">
            <h2>Berita & Info Terkini</h2>
            <p>Informasi terbaru seputar kegiatan dan program Rumah Bahasa Surabaya</p>
        </div>
        <div class="news-grid">
            @forelse($berita as $item)
                <article class="news-card fade-up" style="opacity:0;transform:translateY(30px);transition-delay:{{ $loop->index * 0.1 }}s;">
                    <div class="news-card-img">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                        @else
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        @endif
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
        <div style="text-align:center;margin-top:28px;">
            <a href="{{ route('berita.list') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--teal-700);font-weight:600;font-size:14px;text-decoration:none;transition:gap 0.3s;">
                Lihat selengkapnya
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- Style Khusus Section News --}}
<style>
    section.news-section {
        background-color: #ffffff !important;
        padding-top: 15px !important;
    }

    @media (max-width: 640px) {
        section.news-section {
            padding-top: 10px !important;
            padding-bottom: 25px !important;
        }

        /* Judul Section di Mobile */
        .section-title h2 {
            font-size: 20px !important;
            margin-bottom: 6px !important;
        }

        .section-title p {
            font-size: 13px !important;
            line-height: 1.4 !important;
            margin-bottom: 16px !important;
        }

        /* Container Grid Card */
        .news-grid {
            gap: 16px !important;
        }

        /* Gambar Card Dibuat Kompak */
        .news-card-img {
            height: 160px !important; /* Maksimal tinggi gambar di HP */
        }

        /* Content Body Card */
        .news-card-body {
            padding: 14px 16px !important;
        }

        .news-card-date {
            font-size: 11px !important;
            margin-bottom: 6px !important;
        }

        .news-card-body h3 {
            font-size: 15px !important;
            line-height: 1.35 !important;
            margin-bottom: 8px !important;
        }

        .news-card-body p {
            font-size: 12.5px !important;
            line-height: 1.45 !important;
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

    /* Section news menyambung dari putih */
    section.news-section {
        background-color: #ffffff !important;
        padding-top: 15px !important;
    }

    @media (max-width: 640px) {
        section.hero {
            padding-bottom: 20px !important;
        }
        section.news-section {
            padding-top: 10px !important;
        }
    }
</style>

<!--{{-- Wave Separator to Features --}}
<div class="wave-separator" style="background:var(--white);">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C320,100 480,0 720,40 C960,80 1120,0 1440,40 L1440,80 L0,80 Z" fill="var(--teal-900)" opacity="0.03"/>
        <path d="M0,30 C360,80 540,10 720,30 C900,50 1080,10 1440,30 L1440,80 L0,80 Z" fill="var(--white)"/>
    </svg>
</div> -->

<!--{{-- ===== 2. FEATURES (LAYANAN) - SEKARANG DI BAWAH BERANDA ===== --}}
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
</section> -->

<!--{{-- Wave Separator to News --}}
<div class="wave-separator" style="background:var(--gray-50);">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,50 C240,10 480,90 720,50 C960,10 1200,90 1440,50 L1440,80 L0,80 Z" fill="var(--white)"/>
    </svg>
</div>] -->



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
<!-- {{-- ===== GALERI SECTION ===== --}}
<section class="galeri-section" id="galeri">
    <div class="container">
        <div class="section-title">
            <h2>Galeri Kegiatan</h2>
            <p>Dokumentasi kegiatan dan program Rumah Bahasa Surabaya</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;">
            @forelse($galeri as $item)
                <div class="galeri-card-premium" style="padding:0;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);background:var(--white);transition:transform 0.3s ease,box-shadow 0.3s ease;">
                    @if($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" style="width:100%;height:200px;object-fit:cover;display:block;">
                    @else
                        <div style="height:200px;background:linear-gradient(135deg,var(--teal-50),var(--teal-100));display:flex;align-items:center;justify-content:center;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--teal-400)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                    @endif
                    <div style="padding:20px;">
                        <h3 style="font-size:16px;font-weight:600;color:var(--gray-900);margin-bottom:4px;">{{ $item->judul }}</h3>
                        @if($item->deskripsi)
                            <p style="color:var(--gray-500);font-size:13px;">{{ $item->deskripsi }}</p>
                        @endif
                        @if($item->tanggal)
                            <p style="color:var(--gray-400);font-size:12px;margin-top:8px;">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-400);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <p>Belum ada galeri.</p>
                </div>
            @endforelse
        </div>
        <div style="text-align:center;margin-top:40px;">
            <a href="{{ route('galeri') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--teal-700);font-weight:600;font-size:15px;text-decoration:none;transition:gap 0.3s;">
                Lihat selengkapnya
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            </a>
        </div>
    </div>
</section> -->

<!--{{-- Wave Separator to About --}}
<div class="wave-separator" style="background:var(--white);">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C360,100 720,-10 1080,40 C1260,65 1350,35 1440,40 L1440,80 L0,80 Z" fill="var(--gray-50)"/>
    </svg>
</div> -->

{{-- ===== 4. ABOUT (TENTANG) ===== --}}
<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-content fade-up" style="opacity:0;transform:translateY(30px);">
                <h2>Tentang <span style="color: #045981;">Rumah Bahasa</span> Surabaya</h2>
                <p>Rumah Bahasa Surabaya adalah program unggulan Dinas Perpustakaan dan Kearsipan Kota Surabaya yang bertujuan meningkatkan literasi dan pembelajaran masyarakat.</p>
                <p>Kami menyediakan berbagai layanan mulai dari pojok baca, kelas bahasa, pelatihan keterampilan, hingga kegiatan pelestarian bahasa daerah Surabaya.</p>
                <div style="margin-top:16px;">
                    <a href="{{ route('profil') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--teal-700);font-weight:600;font-size:14px;text-decoration:none;transition:gap 0.3s;">
                        Lihat selengkapnya
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
            <div class="about-visual fade-up" style="opacity:0;transform:translateY(30px);transition-delay:0.15s;">
                <div class="house-shape">
                    {{-- Animasi Rumah Bergaris Putus-Putus (Ikon Dalam Dihapus) --}}
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 15 L85 45 V85 H15 V45 Z" stroke="var(--teal-600, #0284c7)" stroke-width="2.5" stroke-dasharray="6 4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
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

    .house-shape {
        width: 140px;
        height: 140px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .house-shape svg {
        width: 100%;
        height: 100%;
        animation: spinSlow 20s linear infinite; /* Animasi berputar lembut */
    }

    @keyframes spinSlow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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

        .house-shape {
            width: 90px !important; /* Ukuran rumah diperkecil di mobile */
            height: 90px !important;
            margin-top: 10px !important;
        }
    }
</style>

{{-- TARUH DI SINI: Wave Separator Cantik Menuju Form Message (Bukan Garis Sekat Biasa!) --}}
<div class="wave-separator" style="background:var(--white); margin-bottom:-2px;">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C320,100 480,0 720,40 C960,80 1120,0 1440,40 L1440,80 L0,80 Z" fill="var(--teal-900)"/>
    </svg>
</div>

{{-- ===== 5. KOTAK PESAN (MESSAGE FORM) - PALING BAWAH ===== --}}
<section class="message-section" id="kontak" style="background: var(--teal-900); padding: 60px 0 100px 0; position: relative; overflow: hidden;">
    {{-- Ornamen Dekoratif Minimalis / Floating Shapes --}}
    <div class="ornament-blur" style="position: absolute; top: -10%; left: -5%; width: 300px; height: 300px; background: rgba(255,255,255,0.03); border-radius: 50%; filter: blur(40px); pointer-events: none;"></div>
    <div class="ornament-blur" style="position: absolute; bottom: -10%; right: -5%; width: 400px; height: 400px; background: rgba(0,0,0,0.15); border-radius: 50%; filter: blur(60px); pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 3; max-width: 800px; margin: 0 auto; padding: 0 20px;">
        <div class="section-title" style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: var(--white); font-size: 2.25rem; font-weight: 700; margin-bottom: 12px; letter-spacing: -0.5px;">Hubungi <span style="color: #045981;">Kami</span></h2>
            <p style="color: rgba(255,255,255,0.85); font-size: 1rem; max-width: 500px; margin: 0 auto;">Punya pertanyaan atau masukan? Kirimkan pesanmu langsung di bawah ini.</p>
        </div>

        {{-- Glassmorphism Card Form --}}
        <div class="form-container" style="background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); padding: 40px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            @if(session('success'))
                <div style="background: rgba(94, 197, 234, 0.15); border: 1px solid rgba(94, 187, 234, 0.3); color: #5eadea; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-size: 0.95rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem;">
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
                        <label for="nama" style="color: rgba(255,255,255,0.95); font-size: 0.9rem; font-weight: 500;">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama kamu" required
                            style="width: 100%; padding: 14px 18px; background: rgba(255, 255, 255, 0.22); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: rgba(226, 232, 240, 0.9); font-size: 0.95rem; transition: all 0.3s ease; outline: none;">
                    </div>
                    <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                        <label for="email" style="color: rgba(255,255,255,0.95); font-size: 0.9rem; font-weight: 500;">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required
                            style="width: 100%; padding: 14px 18px; background: rgba(255, 255, 255, 0.22); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: rgba(226, 232, 240, 0.9); font-size: 0.95rem; transition: all 0.3s ease; outline: none;">
                    </div>
                </div>

                <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="subjek" style="color: rgba(255,255,255,0.95); font-size: 0.9rem; font-weight: 500;">Subjek</label>
                    <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" placeholder="Topik pesan"
                        style="width: 100%; padding: 14px 18px; background: rgba(255, 255, 255, 0.22); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: rgba(226, 232, 240, 0.9); font-size: 0.95rem; transition: all 0.3s ease; outline: none;">
                </div>

                <div class="input-group" style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="pesan" style="color: rgba(255,255,255,0.95); font-size: 0.9rem; font-weight: 500;">Pesan Anda</label>
                    <textarea id="pesan" name="pesan" rows="4" placeholder="Tuliskan pertanyaan atau aspirasimu di sini..." required
                        style="width: 100%; padding: 14px 18px; background: rgba(255, 255, 255, 0.22); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 10px; color: rgba(226, 232, 240, 0.9); font-size: 0.95rem; font-family: inherit; transition: all 0.3s ease; outline: none; resize: vertical;"></textarea>
                </div>

                <div style="text-align: right; margin-top: 4px;">
                    <button type="submit" style="background: #015b88; color: #3ac7ff; font-weight: 600; padding: 12px 28px; border: none; border-radius: 10px; cursor: pointer; font-size: 0.95rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(2, 132, 199, 0.4);">
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
    /* Placeholder dengan warna Abu-abu Muda Semi-Transparan */
    .input-group input::placeholder,
    .input-group textarea::placeholder {
        color: rgba(226, 232, 240, 0.65) !important;
        opacity: 1;
    }
    .input-group input::-webkit-input-placeholder,
    .input-group textarea::-webkit-input-placeholder {
        color: rgba(226, 232, 240, 0.65) !important;
    }

    /* Focus State */
    .input-group input:focus, .input-group textarea:focus {
        border-color: #7dd3fc !important;
        background: rgba(255, 255, 255, 0.32) !important;
        box-shadow: 0 0 0 3px rgba(125, 211, 252, 0.25);
        color: #ffffff !important;
    }

    /* Hover Button */
    .form-container button:hover {
        background: #0369a1 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5) !important;
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