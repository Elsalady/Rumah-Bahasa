@extends('layouts.app')

@section('title', 'Kontak')
@section('description', 'Hubungi Rumah Bahasa Surabaya — Dinas Perpustakaan dan Kearsipan Kota Surabaya.')

@section('content')
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Kontak</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mt-3 font-heading">Hubungi Kami</h1>
            <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Silakan hubungi kami untuk informasi lebih lanjut</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            {{-- Info Kontak --}}
            <div class="space-y-6">
                <div class="card-3d p-6 flex items-start gap-5">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Alamat</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Dinas Perpustakaan dan Kearsipan Kota Surabaya<br>Jl. Raya Surabaya</p>
                    </div>
                </div>
                <div class="card-3d p-6 flex items-start gap-5">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                        <p class="text-gray-500 text-sm">info@rumahbahasa-surabaya.go.id</p>
                    </div>
                </div>
                <div class="card-3d p-6 flex items-start gap-5">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-teal-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Telepon</h3>
                        <p class="text-gray-500 text-sm">(031) 1234567</p>
                    </div>
                </div>
            </div>

            {{-- Form Kontak --}}
            <div>
                @if(session('success'))
                    <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-200/80 text-emerald-700 rounded-2xl p-5 mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card-3d p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 font-heading">Kirim Pesan</h3>
                    <form action="{{ route('kontak.kirim') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-600 mb-1.5">Nama</label>
                            <input type="text" name="nama" id="nama" required
                                class="form-input-green @error('nama') border-red-300 @enderror"
                                value="{{ old('nama') }}" placeholder="Masukkan nama Anda">
                            @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600 mb-1.5">Email</label>
                            <input type="email" name="email" id="email" required
                                class="form-input-green @error('email') border-red-300 @enderror"
                                value="{{ old('email') }}" placeholder="contoh@email.com">
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="subjek" class="block text-sm font-medium text-gray-600 mb-1.5">Subjek</label>
                            <input type="text" name="subjek" id="subjek"
                                class="form-input-green"
                                value="{{ old('subjek') }}" placeholder="Subjek pesan">
                        </div>
                        <div>
                            <label for="pesan" class="block text-sm font-medium text-gray-600 mb-1.5">Pesan</label>
                            <textarea name="pesan" id="pesan" rows="5" required
                                class="form-input-green @error('pesan') border-red-300 @enderror"
                                placeholder="Ketik pesan Anda...">{{ old('pesan') }}</textarea>
                            @error('pesan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-500 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-emerald-500/20 hover:-translate-y-0.5 transition-all duration-200">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
