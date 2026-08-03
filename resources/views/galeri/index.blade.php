@extends('layouts.app')

@section('title', 'Galeri')
@section('meta_desc', 'Galeri foto kegiatan Rumah Bahasa Surabaya — dokumentasi kelas, acara, dan program.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Beranda
        </a>

        <div class="section-title">
            <h2>Galeri Kegiatan</h2>
            <p>Dokumentasi foto dan kegiatan Rumah Bahasa Surabaya</p>
        </div>

        @if($galeri->count())
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:20px; margin-top:40px;">
                @foreach($galeri as $item)
                    <a href="{{ asset('storage/'.$item->gambar) }}" target="_blank" rel="noopener" class="galeri-card" style="display:block; border-radius:14px; overflow:hidden; background:#fff; border:1px solid var(--gray-100); box-shadow:0 2px 10px rgba(0,0,0,0.05); text-decoration:none; transition:all 0.25s ease;">
                        <div style="width:100%; aspect-ratio:4/3; overflow:hidden; background:var(--gray-50);">
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" loading="lazy" style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.35s ease;">
                        </div>
                        <div style="padding:16px 18px;">
                            <h3 style="font-size:15px; font-weight:700; color:var(--gray-900); margin:0 0 6px;">{{ $item->judul }}</h3>
                            @if($item->tanggal)
                                <p style="font-size:12px; color:var(--gray-400); margin:0;">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div style="margin-top:40px;">
                {{ $galeri->links() }}
            </div>
        @else
            <div class="dashboard-card" style="text-align:center; padding:60px; margin-top:40px;">
                <p style="color:var(--gray-400);">Belum ada foto galeri. Nanti ya!</p>
            </div>
        @endif
    </div>
</section>

<style>
    .galeri-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(2, 132, 199, 0.15);
    }
    .galeri-card:hover img {
        transform: scale(1.06);
    }
</style>
@endsection
