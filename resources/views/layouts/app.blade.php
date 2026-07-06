<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Rumah Bahasa Surabaya — program literasi bahasa di Dinas Perpustakaan dan Kearsipan Kota Surabaya.')">
    <meta name="keywords" content="rumah bahasa surabaya, perpustakaan surabaya, kearsipan surabaya, literasi surabaya, bahasa jawa surabaya">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
    <meta property="og:description" content="@yield('description', 'Rumah Bahasa Surabaya — program literasi bahasa.')">
    <meta property="og:image" content="@yield('image', asset('images/og-default.jpg'))">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Rumah Bahasa Surabaya')">
    <meta property="twitter:description" content="@yield('description', 'Rumah Bahasa Surabaya')">

    <title>@yield('title', 'Rumah Bahasa Surabaya') - Dinas Perpustakaan dan Kearsipan Kota Surabaya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-600 font-sans antialiased overflow-x-hidden">

    {{-- GLOBAL FLOATING ORNAMENTS --}}
    <div class="ornament ornament-1 fixed"></div>
    <div class="ornament ornament-2 fixed"></div>
    <div class="ornament ornament-3 fixed"></div>
    <div class="ornament ornament-4 fixed"></div>
    <div class="ornament ornament-5 fixed"></div>
    <div class="ornament-dots fixed"></div>

    {{-- NAVBAR --}}
    <nav class="bg-white/80 backdrop-blur-xl border-b border-gray-100/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-accent-500">Rumah Bahasa</span>
                    <span class="text-xl font-light text-gray-400">Surabaya</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="nav-link px-4 py-2 rounded-xl {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="nav-link px-4 py-2 rounded-xl {{ request()->routeIs('profil') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">Profil</a>
                    <a href="{{ route('layanan') }}" class="nav-link px-4 py-2 rounded-xl {{ request()->routeIs('layanan') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">Layanan</a>
                    <a href="{{ route('berita') }}" class="nav-link px-4 py-2 rounded-xl {{ request()->routeIs('berita*') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">Berita</a>
                    <a href="{{ route('galeri') }}" class="nav-link px-4 py-2 rounded-xl {{ request()->routeIs('galeri') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">Galeri</a>
                    <a href="{{ route('kontak') }}" class="nav-link px-4 py-2 rounded-xl {{ request()->routeIs('kontak') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">Kontak</a>
                </div>

                {{-- Mobile menu button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100/80 bg-white/95 backdrop-blur-lg">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">Beranda</a>
                <a href="{{ route('profil') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('profil') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">Profil</a>
                <a href="{{ route('layanan') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('layanan') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">Layanan</a>
                <a href="{{ route('berita') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('berita*') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">Berita</a>
                <a href="{{ route('galeri') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('galeri') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">Galeri</a>
                <a href="{{ route('kontak') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('kontak') ? 'text-primary-600 bg-primary-50/60 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">Kontak</a>
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white font-semibold text-lg mb-4">Rumah Bahasa Surabaya</h3>
                    <p class="text-sm leading-relaxed">
                        Program literasi kebahasaan di bawah Dinas Perpustakaan dan Kearsipan Kota Surabaya.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-4">Kontak</h3>
                    <address class="text-sm not-italic leading-relaxed">
                        Dinas Perpustakaan dan Kearsipan Kota Surabaya<br>
                        Jl. Raya Surabaya<br>
                        Email: info@rumahbahasa-surabaya.go.id<br>
                        Telp: (031) 1234567
                    </address>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('profil') }}" class="hover:text-white">Profil</a></li>
                        <li><a href="{{ route('layanan') }}" class="hover:text-white">Layanan</a></li>
                        <li><a href="{{ route('berita') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ route('galeri') }}" class="hover:text-white">Galeri</a></li>
                        <li><a href="{{ route('kontak') }}" class="hover:text-white">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                &copy; {{ date('Y') }} Dinas Perpustakaan dan Kearsipan Kota Surabaya. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>

    <style>
        .nav-link {
            @apply text-gray-500 hover:text-blue-600 transition-colors duration-200;
        }
    </style>
</body>
</html>
