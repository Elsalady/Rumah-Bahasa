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

            @if($item->gambar)
                <img src="{{ asset('images/berita/' . $item->gambar) }}" alt="{{ $item->judul }}" style="width:100%;height:240px;object-fit:cover;border-radius:16px;margin-bottom:40px;display:block;" onerror="this.style.display='none'">
            @endif

            <div style="color:var(--gray-700);line-height:1.9;font-size:16px;">
                <p style="margin-bottom:16px;">{{ $item->ringkasan }}</p>
                <p>{{ $item->isi }}</p>
            </div>
        </article>
    </div>
</section>
@endsection