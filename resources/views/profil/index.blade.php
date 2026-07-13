@extends('layouts.app')

@section('title', 'Profil')
@section('meta_desc', 'Profil lengkap Rumah Bahasa Surabaya — visi, misi, sejarah, dan program.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
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

        <div style="max-width:800px;margin:0 auto;display:grid;gap:40px;">
            @forelse($profil as $kategori => $items)
                <div class="dashboard-card">
                    <h3 style="margin-bottom:20px;">{{ $kategoriMap[$kategori] ?? $kategori }}</h3>
                    @foreach($items as $item)
                        <article style="margin-bottom:16px;{{ !$loop->last ? 'padding-bottom:16px;border-bottom:1px solid var(--gray-100);' : '' }}">
                            <h4 style="font-size:16px;font-weight:600;color:var(--teal-700);margin-bottom:6px;">{{ $item->judul }}</h4>
                            <p style="color:var(--gray-500);line-height:1.8;">{{ $item->deskripsi }}</p>
                        </article>
                    @endforeach
                </div>
            @empty
                <div class="dashboard-card" style="text-align:center;padding:60px;">
                    <p style="color:var(--gray-400);">Konten profil sedang dilengkapi.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
