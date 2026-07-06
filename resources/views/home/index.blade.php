@extends('layouts.app')

@section('title', 'Beranda')
@section('description', 'Rumah Bahasa Surabaya — program literasi bahasa oleh Dinas Perpustakaan dan Kearsipan Kota Surabaya.')

@section('content')

{{-- HERO --}}
<section class="hero-gradient py-20 md:py-28 relative overflow-hidden">
    <div class="hero-glow"></div>

    {{-- Floating decorative shapes --}}
    <div class="float-shape float-shape-1">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="24" cy="24" r="23" stroke="rgba(59,130,246,0.12)" stroke-width="2" stroke-dasharray="6 4"/>
            <circle cx="24" cy="24" r="8" fill="rgba(59,130,246,0.06)"/>
        </svg>
    </div>
    <div class="float-shape float-shape-2">
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="2" width="32" height="32" rx="8" stroke="rgba(16,185,129,0.12)" stroke-width="2"/>
            <rect x="12" y="12" width="12" height="12" rx="3" fill="rgba(16,185,129,0.06)"/>
        </svg>
    </div>
    <div class="float-shape float-shape-3">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 2L17.09 8.26L24 9.27L19 14.14L20.18 21.02L14 17.77L7.82 21.02L9 14.14L4 9.27L10.91 8.26L14 2Z" fill="rgba(139,108,247,0.08)" stroke="rgba(139,108,247,0.15)" stroke-width="1.5"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm border border-white/60 rounded-full px-4 py-1.5 mb-8 text-sm text-gray-500 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                Dinas Perpustakaan dan Kearsipan Kota Surabaya
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight font-heading">
                Selamat Datang di <br>
                <span class="gradient-text">Rumah Bahasa</span> Surabaya
            </h1>
            <p class="text-lg md:text-xl text-gray-500 leading-relaxed mb-10 max-w-2xl mx-auto">
                Pusat literasi dan kebahasaan yang menyenangkan. Mari bersama tingkatkan 
                budaya literasi dan cinta bahasa.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('profil') }}" class="btn-3d px-7 py-3.5 bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5">
                    Jelajahi Profil
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('kontak') }}" class="btn-3d px-7 py-3.5 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-700 shadow-sm hover:shadow-md hover:bg-white hover:-translate-y-0.5">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="py-20 section-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Layanan</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 font-heading">Apa yang Kami Tawarkan</h2>
            <p class="mt-3 text-gray-500 max-w-xl mx-auto">Berbagai program literasi dan kebahasaan untuk masyarakat Surabaya</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-500 text-white shadow-lg shadow-blue-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pojok Baca</h3>
                <p class="text-gray-500 leading-relaxed">Koleksi buku bahasa daerah, nasional, dan internasional yang nyaman untuk dibaca.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-500 text-white shadow-lg shadow-emerald-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kelas Literasi</h3>
                <p class="text-gray-500 leading-relaxed">Kelas bahasa asing, bahasa daerah, dan pelatihan menulis untuk semua usia.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-violet-400 to-violet-500 text-white shadow-lg shadow-violet-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kegiatan Budaya</h3>
                <p class="text-gray-500 leading-relaxed">Lomba bercerita, menulis aksara Jawa, dan festival literasi bahasa.</p>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-14">
            <div class="flex-1">
                <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-6 font-heading">Mengenal Rumah Bahasa</h2>
                <p class="text-gray-500 leading-relaxed mb-4">
                    Rumah Bahasa Surabaya adalah program unggulan Dinas Perpustakaan dan Kearsipan 
                    Kota Surabaya yang bertujuan meningkatkan literasi kebahasaan masyarakat.
                </p>
                <p class="text-gray-500 leading-relaxed mb-8">
                    Kami menyediakan berbagai layanan mulai dari pojok baca, kelas literasi, 
                    hingga kegiatan pelestarian bahasa daerah Surabaya.
                </p>
                <a href="{{ route('profil') }}" class="btn-3d px-6 py-3 bg-white border border-gray-200 text-gray-700 shadow-sm hover:shadow-md hover:text-primary-600 hover:border-primary-200 gap-1">
                    Selengkapnya
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="flex-1">
                <div class="glass-card h-72 md:h-96 w-full flex items-center justify-center overflow-hidden">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-primary-100 to-primary-50 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-gray-400">Foto Rumah Bahasa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="py-20 section-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12">
            <div>
                <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Berita</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 font-heading">Berita Terbaru</h2>
                <p class="mt-2 text-gray-500">Informasi kegiatan dan program terbaru</p>
            </div>
            <a href="{{ route('berita') }}" class="btn-3d mt-4 sm:mt-0 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm shadow-sm hover:shadow-md hover:text-primary-600">
                Lihat Semua
                <svg class="ml-1.5 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="glass-card p-12 text-center">
            <div class="w-14 h-14 mx-auto mb-4 bg-gray-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <p class="text-gray-400">Belum ada berita. Admin akan segera menambahkan.</p>
        </div>
    </div>
</section>

{{-- KONTAK CTA --}}
<section class="cta-gradient py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 font-heading">Punya Pertanyaan?</h2>
        <p class="text-white/80 mb-10 max-w-2xl mx-auto text-lg">
            Hubungi kami untuk informasi lebih lanjut tentang program dan layanan Rumah Bahasa Surabaya.
        </p>
        <a href="{{ route('kontak') }}" class="btn-3d px-7 py-3.5 bg-white text-primary-700 shadow-xl hover:shadow-2xl hover:-translate-y-0.5 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Hubungi Kami
        </a>
    </div>
</section>

@endsection
