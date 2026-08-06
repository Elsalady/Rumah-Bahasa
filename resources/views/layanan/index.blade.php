@extends('layouts.app')

@section('title', 'Program & Kelas Bahasa')
@section('meta_desc', 'Daftar lengkap kelas bahasa dan pelatihan Rumah Bahasa Surabaya — Jepang, Korea, Arab, Mandarin, Inggris, dan lainnya.')

@section('content')
<section style="padding:120px 0 80px;background:#f8fafc;">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Beranda
        </a>

        <div class="section-title" style="text-align:center;margin-bottom:40px;">
            <h2>Program & <span style="color:#045981;">Kelas Bahasa</span></h2>
            <p>Daftar lengkap kelas bahasa dan pelatihan yang diselenggarakan Rumah Bahasa Surabaya</p>
        </div>

        @if($programs->count())
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;">
                @foreach($programs as $item)
                    <a href="{{ route('layanan.show', $item->nama) }}" style="display:flex;flex-direction:column;text-decoration:none;padding:32px 24px;text-align:center;border-radius:16px;border:1px solid var(--gray-100);background:#fff;box-shadow:0 2px 12px rgba(0,0,0,0.05);transition:box-shadow 0.3s,transform 0.3s;" onmouseover="this.style.boxShadow='0 12px 32px rgba(2, 132, 199, 0.12)';this.style.transform='translateY(-4px)'" onmouseout="this.style.boxShadow='0 2px 12px rgba(0,0,0,0.05)';this.style.transform='translateY(0)'">
                        @if($item->ikon)
                            <div style="font-size:48px;margin-bottom:16px;color:var(--teal-600);">{!! $item->ikon !!}</div>
                        @elseif($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama }}" style="width:80px;height:80px;object-fit:cover;border-radius:16px;margin:0 auto 16px;">
                        @endif
                        <h3 style="font-size:19px;font-weight:700;color:var(--gray-900);margin:0 0 10px;">{{ $item->nama }}</h3>
                        <p style="font-size:14px;color:var(--gray-500);line-height:1.7;margin:0 0 20px;flex:1;">{{ Str::limit($item->deskripsi, 120) }}</p>
                        <span style="display:inline-flex;align-items:center;justify-content:center;gap:8px;color:#fff;font-weight:600;font-size:14px;text-decoration:none;background:#0c4e91;padding:11px 24px;border-radius:8px;transition:background 0.2s;" onmouseover="this.style.background='#4d9ce2'" onmouseout="this.style.background='#0c4e91'">
                            Lihat Detail
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align:center;padding:60px 20px;color:var(--gray-400);">
                <p>Belum ada program yang tersedia.</p>
            </div>
        @endif
    </div>
</section>
@endsection
