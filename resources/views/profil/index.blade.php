@extends('layouts.app')

@section('title', 'Profil')
@section('meta_desc', 'Profil lengkap Rumah Bahasa Surabaya — visi, misi, sejarah, dan program.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Beranda
        </a>
        <div class="section-title">
            <h2>Profil Rumah Bahasa</h2>
            <p>Mengenal lebih dekat program dan tujuan kami</p>
        </div>

        @php $kategoriMap = [
            'sejarah' => 'Sejarah',
            'visi_misi' => 'Visi & Misi',
            'tugas_fungsi' => 'Tugas & Fungsi',
            'struktur' => 'Struktur Organisasi',
            'volunteer' => 'Volunteer',
        ]; @endphp

        <div style="margin-top:48px;">
        @forelse($profil as $kategori => $items)
            <h3 style="font-size:22px;font-weight:700;color:var(--gray-900);margin-bottom:24px;margin-top:48px;{{ $loop->first ? 'margin-top:0;' : '' }}">
                {{ $kategoriMap[$kategori] ?? $kategori }}
            </h3>

            @if($kategori === 'visi_misi')
                @foreach($items as $item)
                    @php $paragraf = explode("\n\n", $item->deskripsi); @endphp
                    <div class="dashboard-card" style="padding:24px;margin-bottom:40px;">
                        @foreach($paragraf as $p)
                            @php $parts = explode("\n", trim($p), 2); @endphp
                            @if(!$loop->first)
                                <div style="margin-top:20px;"></div>
                            @endif
                            <div style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:6px;">{{ $parts[0] ?? '' }}</div>
                            <p style="font-size:14px;color:var(--gray-500);line-height:1.8;margin:0;">{{ $parts[1] ?? '' }}</p>
                        @endforeach
                    </div>
                @endforeach
            @else
                @foreach($items as $item)
                    <div class="dashboard-card" style="padding:24px;margin-bottom:24px;">
                        <div style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:6px;">{{ $item->judul }}</div>
                        @if(mb_strlen(strip_tags($item->deskripsi)) > 300)
                            <p style="font-size:14px;color:var(--gray-500);line-height:1.8;margin:0 0 12px 0;">{{ Str::limit(strip_tags($item->deskripsi), 300) }}</p>
                            <a href="{{ route('profil.show', $item->id) }}" style="display:inline-flex;align-items:center;gap:6px;color:#fff;font-weight:600;font-size:13px;text-decoration:none;background:#0c4e91;padding:8px 20px;border-radius:8px;transition:background 0.2s;" onmouseover="this.style.background='#4d9ce2'" onmouseout="this.style.background='#0c4e91'">
                                Lihat Selengkapnya
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        @else
                            <p style="font-size:14px;color:var(--gray-500);line-height:1.8;margin:0;">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                @endforeach
            @endif
        @empty
            <div class="dashboard-card" style="text-align:center;padding:60px;max-width:800px;margin:0 auto;">
                <p style="color:var(--gray-400);">Konten profil sedang dilengkapi.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
