@extends('layouts.app')

@section('title', 'Jadwal Kelas')
@section('meta_desc', 'Jadwal kelas Rumah Bahasa Surabaya — Lihat jadwal kelas Tematik dan Tentative, Online dan Offline.')

@section('content')
<section style="padding:140px 0 80px;min-height:100vh;">
    <div class="container" style="max-width:900px;margin:0 auto;padding:0 20px;">

        <div style="text-align:center;margin-bottom:40px;">
            <h1 style="font-size:32px;font-weight:800;color:var(--gray-900);margin-bottom:8px;">Jadwal Kelas</h1>
            <p style="color:var(--gray-500);font-size:15px;">Jadwal kelas Rumah Bahasa Surabaya — Tematik &amp; Tentative</p>
        </div>

        {{-- Keterangan Jenis Kelas --}}
        <div style="display:flex;gap:16px;flex-wrap:wrap;justify-content:center;margin-bottom:32px;">
            <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;padding:10px 16px;border-radius:10px;font-size:13px;">
                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#0369a1;"></span>
                <strong>Tematik</strong>
                <span style="color:var(--gray-500);">— Kelas rutin dengan jadwal tetap dan tema spesifik.</span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;padding:10px 16px;border-radius:10px;font-size:13px;">
                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#b45309;"></span>
                <strong>Tentative</strong>
                <span style="color:var(--gray-500);">— Kelas bersifat sementara/kondisional, jadwal dapat berubah.</span>
            </div>
        </div>

        @if($jadwal->count())
            @php
                $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
            @endphp
            @foreach($hariList as $hari)
                @if(isset($jadwal[$hari]))
                    <div style="margin-bottom:32px;">
                        <h3 style="font-size:20px;font-weight:700;color:var(--teal-700);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--teal-100);">{{ $hari }}</h3>
                        <div style="display:grid;gap:12px;">
                            @foreach($jadwal[$hari] as $item)
                                <div style="background:#fff;border:1px solid var(--gray-100);border-radius:12px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                                    <div style="flex:1;min-width:180px;">
                                        <p style="font-weight:700;font-size:15px;color:var(--gray-900);margin:0;">{{ $item->nama_kelas }}</p>
                                        <p style="font-size:13px;color:var(--gray-500);margin:4px 0 0;">
                                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                            @if($item->pengajar)
                                                &middot; {{ $item->pengajar }}
                                            @endif
                                        </p>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                        <span style="display:inline-block;padding:3px 10px;border-radius:50px;font-size:11px;font-weight:600;
                                            {{ $item->jenis === 'tematik' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#fef3c7;color:#b45309;' }}">
                                            {{ ucfirst($item->jenis) }}
                                        </span>
                                        <span style="display:inline-block;padding:3px 10px;border-radius:50px;font-size:11px;font-weight:600;
                                            {{ $item->mode === 'online' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#ecfdf5;color:#166534;' }}">
                                            {{ ucfirst($item->mode) }}
                                        </span>
                                        @if($item->ruangan_link)
                                            <span style="font-size:12px;color:var(--gray-500);background:var(--gray-50);padding:3px 10px;border-radius:50px;">
                                                {{ $item->mode === 'online' ? '🔗' : '📍' }} {{ $item->ruangan_link }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div style="text-align:center;padding:80px 20px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gray-300)" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p style="color:var(--gray-400);font-size:15px;">Belum ada jadwal kelas yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
