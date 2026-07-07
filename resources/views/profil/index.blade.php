@extends('layouts.app')

@section('title', 'Profil')
@section('description', 'Profil lengkap Rumah Bahasa Surabaya — visi, misi, sejarah, dan program literasi.')

@section('content')
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Profil</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mt-3 font-heading">Tentang Rumah Bahasa</h1>
            <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Mengenal lebih dekat Rumah Bahasa Surabaya</p>
        </div>

        <div class="max-w-4xl mx-auto space-y-16">
            <div class="card-3d p-8 md:p-10">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center mb-5 shadow-lg shadow-emerald-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-heading">Sejarah</h2>
                <p class="text-gray-500 leading-relaxed">
                    Rumah Bahasa Surabaya didirikan sebagai bagian dari upaya Dinas Perpustakaan dan Kearsipan 
                    Kota Surabaya dalam meningkatkan literasi kebahasaan masyarakat. 
                    (Konten sedang dilengkapi)
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card-3d p-8">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Visi</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Terwujudnya masyarakat Surabaya yang literat dan cinta bahasa.
                    </p>
                </div>
                <div class="card-3d p-8">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-green-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 font-heading">Misi</h3>
                    <ul class="text-gray-500 space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-500 mt-1">•</span>
                            Meningkatkan minat baca dan literasi masyarakat
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-500 mt-1">•</span>
                            Melestarikan bahasa daerah Surabaya
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-500 mt-1">•</span>
                            Menyediakan akses literasi yang inklusif
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-500 mt-1">•</span>
                            Mengembangkan program kebahasaan yang inovatif
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-3d p-8 md:p-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-heading">Tugas & Fungsi</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3 p-4 bg-green-50/80 rounded-xl">
                        <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold number-badge">1</span>
                        <span class="text-gray-600">Menyelenggarakan program literasi kebahasaan</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 bg-green-50/80 rounded-xl">
                        <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold number-badge">2</span>
                        <span class="text-gray-600">Mengelola pojok baca dan perpustakaan mini</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 bg-green-50/80 rounded-xl">
                        <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold number-badge">3</span>
                        <span class="text-gray-600">Menyelenggarakan kelas bahasa dan pelatihan</span>
                    </div>
                    <div class="flex items-start gap-3 p-4 bg-green-50/80 rounded-xl">
                        <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold number-badge">4</span>
                        <span class="text-gray-600">Melestarikan dan mengembangkan bahasa daerah</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
