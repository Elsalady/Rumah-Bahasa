@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Rumah Bahasa Surabaya — pusat literasi dan pembelajaran oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')

@section('content')


{{-- ===== 1. HERO (BERANDA) - SLIDER ===== --}}
@php
    $heroSlides = [
        asset('images/rumbas.jpg'),
        asset('storage/berita/berita_1.jpg'),
        asset('storage/berita/berita_2.jpg'),
        asset('storage/berita/berita_3.jpg'),
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
    opacity: 0.95;
    text-align: center;
">
    Pusat literasi dan pembelajaran untuk masyarakat Surabaya. Mari bersama tingkatkan budaya literasi dan cinta bahasa.
</p>
            <form class="search-box" action="{{ route('berita.list') }}" method="GET">
                <input type="text" name="q" placeholder="Cari informasi atau berita..." aria-label="Cari">
                <button type="submit">Cari</button>
            </form>
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


{{-- ===== 2. LINGKUP PELATIHAN ===== --}}
<section class="pelatihan-section" id="pelatihan" style="padding: 56px 0; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="section-title" style="text-align:center; margin-bottom: 40px;">
            <h2 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 8px;">Lingkup <span style="color:#045981;">Pelatihan</span></h2>
            <p style="color: var(--gray-500); font-size: 1rem; max-width: 560px; margin: 0 auto;">Pelatihan unggulan yang kami selenggarakan untuk masyarakat Surabaya</p>
        </div>

        @if($pelatihan->count())
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px;">
                @foreach($pelatihan as $item)
                    <a href="{{ route('layanan.show', $item->nama) }}" class="dashboard-card pelatihan-card fade-up" style="display:block; padding: 40px 28px; text-align:center; border-radius:16px; border:1px solid var(--gray-100); box-shadow:0 2px 12px rgba(0,0,0,0.05); opacity:0; transform:translateY(30px); transition:all 0.5s ease; transition-delay:{{ $loop->index * 0.15 }}s; text-decoration:none;">
                        @if($item->ikon)
                            <div style="font-size:56px; margin-bottom:16px; color:var(--teal-600);">{!! $item->ikon !!}</div>
                        @elseif($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama }}" style="width:80px; height:80px; object-fit:cover; border-radius:16px; margin-bottom:16px;">
                        @endif
                        <h3 style="font-size:20px; font-weight:700; color:var(--gray-900); margin:0 0 10px;">{{ $item->nama }}</h3>
                        <p style="font-size:14px; color:var(--gray-500); line-height:1.7; margin:0;">{{ Str::limit($item->deskripsi, 90) }}</p>
                        <span style="display:inline-flex;align-items:center;gap:6px;color:#0c4e91;font-weight:600;font-size:13px;margin-top:14px;text-decoration:none;">
                            Lihat Detail
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Info jumlah kelas & tombol lihat selengkapnya --}}
            <div style="text-align:center; margin-top:36px;">
                <p style="font-size:14px; color:var(--gray-500); margin:0 0 16px;">
                    Tersedia <strong style="color:var(--gray-900);">{{ $totalProgram }}</strong> program kelas bahasa &amp; pelatihan lainnya
                </p>
                <a href="{{ route('layanan') }}" style="display:inline-flex;align-items:center;gap:8px;color:#fff;font-weight:600;font-size:14px;text-decoration:none;background:#0c4e91;padding:12px 28px;border-radius:8px;transition:background 0.2s;" onmouseover="this.style.background='#4d9ce2'" onmouseout="this.style.background='#0c4e91'">
                    Lihat selengkapnya
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        @endif
    </div>
</section>

<style>
    section.pelatihan-section .pelatihan-card {
        background: #ffffff;
    }
    section.pelatihan-section .pelatihan-card:hover {
        box-shadow: 0 12px 32px rgba(2, 132, 199, 0.12);
        transform: translateY(-4px);
    }
    @media (max-width: 640px) {
        section.pelatihan-section { padding: 36px 0 !important; }
        section.pelatihan-section .section-title h2 { font-size: 1.5rem !important; }
        section.pelatihan-section .section-title p { font-size: 0.85rem !important; }
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
        <div class="news-grid">
            @forelse($berita as $item)
                <a href="{{ route('berita.show', $item->slug) }}" class="dashboard-card news-card fade-up" style="display:block;overflow:hidden;padding:0;text-decoration:none;opacity:0;transform:translateY(30px);transition-delay:{{ $loop->index * 0.1 }}s;">
                    <div class="news-card-img">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                        @else
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        @endif
                    </div>
                    <div class="news-card-body" style="padding:20px 22px;">
                        <div class="news-card-date">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</div>
                        <h3 style="font-size:17px;font-weight:700;color:var(--gray-900);margin-bottom:8px;line-height:1.4;">{{ $item->judul }}</h3>
                        <p style="color:var(--gray-500);font-size:13.5px;line-height:1.6;margin:0 0 10px;">{{ Str::limit($item->ringkasan ?: strip_tags($item->isi), 80) }}</p>
                        <span style="display:inline-flex;align-items:center;gap:5px;color:#0c4e91;font-weight:600;font-size:13px;">
                            Lihat selengkapnya
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="news-empty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    <p>Belum ada berita.</p>
                </div>
            @endforelse
        </div>
        <div style="text-align:center;margin-top:40px;margin-bottom:8px;">
            <a href="{{ route('berita.list') }}" style="display:inline-flex;align-items:center;gap:8px;color:#0c4e91;font-weight:600;font-size:14px;text-decoration:none;background:#ffffff;padding:12px 32px;border-radius:50px;transition:background 0.2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#ffffff'">
                Lihat selengkapnya
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- Fix Grid Berita di Beranda: Dipaksa 3 kolom kotak-kotak kecil --}}
<style>
    #berita .news-grid {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 24px !important;
    }
    @media (max-width: 900px) {
        #berita .news-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 640px) {
        #berita .news-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

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
    }

    section.news-section .section-title p {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 16px !important;
        line-height: 1.6 !important;
    }

    section.news-section .news-card-img {
        height: 150px !important;
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

        /* Container Grid Card */
        .news-grid {
            gap: 16px !important;
        }

        /* Gambar Card Dibuat Kompak */
        .news-card-img {
            height: 150px !important; /* Maksimal tinggi gambar di HP */
        }

        /* Content Body Card */
        .news-card-body {
            padding: 16px 16px !important;
        }

        .news-card-date {
            font-size: 11px !important;
            margin-bottom: 6px !important;
        }

        .news-card-body h3 {
            font-size: 15px !important;
            line-height: 1.4 !important;
            margin-bottom: 8px !important;
        }

        .news-card-body p {
            font-size: 12.5px !important;
            line-height: 1.55 !important;
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
                <h2>Tentang <span style="color: #045981;">Rumah Bahasa</span> Surabaya</h2>
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