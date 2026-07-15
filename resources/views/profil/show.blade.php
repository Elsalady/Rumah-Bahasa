@extends('layouts.app')

@section('title', $item->judul)
@section('meta_desc', Str::limit(strip_tags($item->deskripsi), 160))

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container" style="max-width:800px;">
        <a href="{{ route('profil') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Profil
        </a>

        <div class="dashboard-card" style="padding:40px;">
            @php
                $kategoriMap = [
                    'sejarah' => 'Sejarah',
                    'visi_misi' => 'Visi & Misi',
                    'tugas_fungsi' => 'Tugas & Fungsi',
                    'struktur' => 'Struktur Organisasi',
                ];
                $kategoriLabel = $kategoriMap[$item->kategori] ?? $item->kategori;
            @endphp
            <div style="font-size:12px;font-weight:600;color:var(--teal-600);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">{{ $kategoriLabel }}</div>
            <h2 style="font-size:24px;font-weight:700;color:var(--gray-900);margin-bottom:20px;">{{ $item->judul }}</h2>
            <div style="color:var(--gray-500);line-height:1.9;font-size:15px;">
                {!! nl2br(e($item->deskripsi)) !!}
            </div>
        </div>
    </div>
</section>
@endsection
