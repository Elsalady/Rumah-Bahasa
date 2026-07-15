@extends('layouts.app')

@section('title', 'Berita')
@section('meta_desc', 'Berita dan informasi terbaru Rumah Bahasa Surabaya.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Beranda
        </a>
        <div class="section-title">
            <h2>Berita & Informasi</h2>
            <p>Informasi terbaru seputar kegiatan dan program</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:28px;">
            @forelse($berita as $item)
                <a href="{{ route('berita.show', $item->slug) }}" class="dashboard-card news-card" style="display:block;overflow:hidden;padding:0;text-decoration:none;">
                    <div class="news-card-img">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--teal-400)" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @endif
                    </div>
                    <div class="news-card-body" style="padding:24px;">
                        <div class="news-card-date">
                            {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}
                        </div>
                        <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:6px;">{{ $item->judul }}</h3>
                        <p style="color:var(--gray-500);font-size:14px;">{{ Str::limit($item->ringkasan ?: strip_tags($item->isi), 120) }}</p>
                    </div>
                </a>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-400);">
                    <p>Belum ada berita.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($berita, 'links'))
            <div style="margin-top:48px;">{{ $berita->links() }}</div>
        @endif
    </div>
</section>
@endsection
