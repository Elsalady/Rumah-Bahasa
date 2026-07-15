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
        ]; @endphp

        @forelse($profil as $kategori => $items)
            <h3 style="font-size:22px;font-weight:700;color:var(--gray-900);margin-bottom:24px;margin-top:40px;{{ $loop->first ? 'margin-top:0;' : '' }}">
                {{ $kategoriMap[$kategori] ?? $kategori }}
            </h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;">
                @foreach($items as $item)
                    <div class="news-card" style="display:flex;flex-direction:column;">
                        <div class="news-card-body" style="flex:1;display:flex;flex-direction:column;">
                            <div style="font-size:12px;color:var(--teal-500);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">
                                {{ $kategoriMap[$kategori] ?? $kategori }}
                            </div>
                            <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:8px;line-height:1.4;">
                                {{ $item->judul }}
                            </h3>
                            <p style="font-size:14px;color:var(--gray-500);line-height:1.7;flex:1;">
                                {{ Str::limit(strip_tags($item->deskripsi), 200) }}
                            </p>
                            @if(strlen(strip_tags($item->deskripsi)) > 200)
                                <a href="{{ route('profil.show', $item->id) }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);font-weight:600;font-size:13px;text-decoration:none;margin-top:12px;">
                                    Lihat Selengkapnya
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="dashboard-card" style="text-align:center;padding:60px;max-width:800px;margin:0 auto;">
                <p style="color:var(--gray-400);">Konten profil sedang dilengkapi.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
