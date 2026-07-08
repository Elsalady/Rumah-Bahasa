@extends('layouts.app')

@section('title', 'Berita')
@section('meta_desc', 'Berita dan informasi terbaru Rumah Belajar Surabaya.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <div class="section-title">
            <h2>Berita & Informasi</h2>
            <p>Informasi terbaru seputar kegiatan dan program</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:28px;">
            @forelse($berita as $item)
                <a href="{{ route('berita.show', $item->slug) }}" class="dashboard-card" style="display:block;overflow:hidden;padding:0;transition:transform 0.3s,box-shadow 0.3s;text-decoration:none;">
                    <div style="height:200px;background:linear-gradient(135deg,var(--teal-50),var(--teal-100));display:flex;align-items:center;justify-content:center;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--teal-400)" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div style="padding:24px;">
                        <div style="font-size:12px;color:var(--teal-500);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">
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
