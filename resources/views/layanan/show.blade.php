@extends('layouts.app')

@section('title', $program->nama)
@section('meta_desc', $program->deskripsi)

@section('content')
<section style="padding:120px 0 80px;background:#f8fafc;">
    <div class="container" style="max-width:1000px;margin:0 auto;padding:0 20px;">
        <a href="{{ route('layanan') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Daftar Program
        </a>

        <div style="background:#fff;border:1px solid var(--gray-100);border-radius:20px;box-shadow:0 2px 12px rgba(0,0,0,0.05);padding:40px;text-align:center;margin-bottom:40px;">
            @if($program->ikon)
                <div style="font-size:64px;margin-bottom:16px;color:var(--teal-600);">{!! $program->ikon !!}</div>
            @elseif($program->gambar)
                <img src="{{ asset('storage/'.$program->gambar) }}" alt="{{ $program->nama }}" style="width:100px;height:100px;object-fit:cover;border-radius:20px;margin:0 auto 16px;">
            @endif
            <h1 style="font-size:32px;font-weight:800;color:var(--gray-900);margin:0 0 12px;">{{ $program->nama }}</h1>
            <p style="font-size:15px;color:var(--gray-500);line-height:1.8;max-width:700px;margin:0 auto 28px;">{{ $program->deskripsi }}</p>

            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:8px;color:#fff;font-weight:600;font-size:14px;text-decoration:none;background:#0c4e91;padding:13px 32px;border-radius:8px;transition:background 0.2s;" onmouseover="this.style.background='#4d9ce2'" onmouseout="this.style.background='#0c4e91'">
                Daftar Program
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        @if($program->link_wa)
            <div style="background:#fff;border:1px solid var(--gray-100);border-radius:20px;box-shadow:0 2px 12px rgba(0,0,0,0.05);padding:32px;text-align:center;margin-top:32px;">
                <p style="font-size:14px;color:#166534;margin:0 0 12px;font-weight:600;">Gabung grup WhatsApp untuk informasi lebih lanjut</p>
                <a href="{{ $program->link_wa }}" target="_blank" rel="noopener noreferrer" style="display:inline-flex;align-items:center;gap:8px;color:#fff;font-weight:600;font-size:14px;text-decoration:none;background:#25d366;padding:11px 24px;border-radius:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Gabung Grup WhatsApp
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
