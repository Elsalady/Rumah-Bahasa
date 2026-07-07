@extends('layouts.app')

@section('title', 'Layanan')
@section('description', 'Layanan Rumah Bahasa Surabaya — pojok baca, kelas literasi, dan kegiatan budaya.')

@section('content')
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Layanan</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mt-3 font-heading">Program & Layanan</h1>
            <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Berbagai program dan layanan yang tersedia di Rumah Bahasa Surabaya</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 text-white shadow-lg shadow-emerald-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pojok Baca</h3>
                <p class="text-gray-500 leading-relaxed">Nikmati koleksi buku bahasa daerah, nasional, dan internasional di pojok baca kami.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg shadow-green-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kelas Bahasa Inggris</h3>
                <p class="text-gray-500 leading-relaxed">Kelas bahasa Inggris untuk pemula hingga mahir dengan metode interaktif.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-teal-400 to-emerald-500 text-white shadow-lg shadow-teal-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m0 4h6m-6 4h8m-8 4h5"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kelas Menulis</h3>
                <p class="text-gray-500 leading-relaxed">Pelatihan menulis kreatif, artikel, dan karya sastra untuk berbagai kalangan.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-amber-500 to-emerald-500 text-white shadow-lg shadow-amber-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Bahasa Daerah</h3>
                <p class="text-gray-500 leading-relaxed">Pelestarian bahasa Jawa Suroboyoan melalui kelas dan kegiatan budaya.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-rose-400 to-emerald-600 text-white shadow-lg shadow-rose-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lomba Literasi</h3>
                <p class="text-gray-500 leading-relaxed">Lomba bercerita, membaca puisi, dan menulis aksara Jawa rutin diadakan.</p>
            </div>
            <div class="card-3d p-8">
                <div class="icon-3d w-14 h-14 bg-gradient-to-br from-cyan-400 to-emerald-500 text-white shadow-lg shadow-cyan-200 mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pojok Digital</h3>
                <p class="text-gray-500 leading-relaxed">Akses literasi digital dengan komputer dan internet gratis.</p>
            </div>
        </div>
    </div>
</section>
@endsection
