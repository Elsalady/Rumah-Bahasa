@extends('layouts.app')

@section('title', $item->judul)
@section('meta_desc', $item->ringkasan ?: strip_tags($item->isi))

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container" style="max-width:800px;">
        <a href="{{ route('berita.list') }}" style="color:var(--gray-500);font-size:14px;display:inline-flex;align-items:center;gap:6px;margin-bottom:32px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Berita
        </a>

        <article>
            <div style="font-size:13px;color:var(--teal-500);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">
                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </div>
            <h1 style="font-size:32px;font-weight:700;color:var(--gray-900);margin-bottom:16px;line-height:1.3;">{{ $item->judul }}</h1>
            @if($item->penulis)
                <p style="color:var(--gray-400);font-size:14px;margin-bottom:32px;">Oleh: {{ $item->penulis }}</p>
            @endif

            <div style="height:240px;background:linear-gradient(135deg,var(--teal-50),var(--teal-100));border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:40px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--teal-400)" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>

            <div style="color:var(--gray-700);line-height:1.9;font-size:16px;">
                <p style="margin-bottom:16px;">{{ $item->ringkasan }}</p>
                <p>{{ $item->isi }}</p>
            </div>
        </article>

        @if($recent && $recent->count())
            <hr style="border:none;border-top:1px solid var(--gray-100);margin:48px 0;">
            <h3 style="font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:24px;">Berita Lainnya</h3>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
                @foreach($recent as $r)
                    <a href="{{ route('berita.show', $r->slug) }}" style="display:block;color:inherit;text-decoration:none;">
                        <div class="dashboard-card" style="padding:16px;">
                            <div style="font-size:12px;color:var(--teal-500);font-weight:600;">{{ \Carbon\Carbon::parse($r->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</div>
                            <h4 style="font-size:14px;font-weight:600;color:var(--gray-900);margin-top:4px;">{{ $r->judul }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
