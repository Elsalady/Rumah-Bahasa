@extends('layouts.app')

@section('title', 'Galeri')
@section('meta_desc', 'Galeri foto kegiatan Rumah Belajar Surabaya.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <div class="section-title">
            <h2>Galeri Kegiatan</h2>
            <p>Dokumentasi kegiatan dan program Rumah Belajar Surabaya</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;">
            @forelse($galeri as $item)
                <div class="dashboard-card" style="overflow:hidden;padding:0;">
                    <div style="height:200px;background:linear-gradient(135deg,var(--teal-50),var(--teal-100));display:flex;align-items:center;justify-content:center;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--teal-400)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                    <div style="padding:20px;">
                        <h3 style="font-size:16px;font-weight:600;color:var(--gray-900);margin-bottom:4px;">{{ $item->judul }}</h3>
                        @if($item->deskripsi)
                            <p style="color:var(--gray-500);font-size:13px;">{{ $item->deskripsi }}</p>
                        @endif
                        @if($item->tanggal)
                            <p style="color:var(--gray-400);font-size:12px;margin-top:8px;">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-400);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <p>Belum ada galeri.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
