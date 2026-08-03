@extends('layouts.app')

@section('title', $data['judul'])
@section('meta_desc', $data['deskripsi'])

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Beranda
        </a>

        <div class="section-title">
            <h2>{{ $data['judul'] }}</h2>
            <p>Langkah-langkah mendaftar sebagai peserta Rumah Bahasa Surabaya</p>
        </div>

        <div style="margin-top:48px; max-width: 860px; margin-left:auto; margin-right:auto;">
            {{-- Deskripsi --}}
            <div class="dashboard-card" style="padding:24px; margin-bottom:24px;">
                <p style="font-size:14px; color:var(--gray-500); line-height:1.8; margin:0;">{{ $data['deskripsi'] }}</p>
            </div>

            {{-- Langkah --}}
            <div class="dashboard-card" style="padding:28px;">
                <h3 style="font-size:18px; font-weight:700; color:var(--gray-900); margin-top:0; margin-bottom:20px;">Langkah Pendaftaran</h3>
                <ol style="margin:0; padding-left:20px; display:flex; flex-direction:column; gap:14px;">
                    @foreach($data['langkah'] as $index => $langkah)
                        <li style="font-size:14px; color:var(--gray-600); line-height:1.8;">
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:50%; background:var(--teal-600); color:#fff; font-weight:700; font-size:12px; margin-right:8px;">{{ $index + 1 }}</span>
                            {!! $langkah !!}
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Info kontak --}}
            <div class="dashboard-card" style="padding:28px; margin-top:24px;">
                <h3 style="font-size:16px; font-weight:700; color:var(--gray-900); margin-top:0; margin-bottom:16px;">Informasi Lebih Lanjut</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div style="font-size:13px; color:var(--gray-500);">Email</div>
                    <div style="font-size:13px; font-weight:600; color:var(--gray-900);"><a href="mailto:rumah.bahasa.surabaya@gmail.com" style="color:var(--teal-700);">rumah.bahasa.surabaya@gmail.com</a></div>
                    <div style="font-size:13px; color:var(--gray-500);">Facebook</div>
                    <div style="font-size:13px; font-weight:600; color:var(--gray-900);"><a href="https://id-id.facebook.com/RumahBahasaSurabayaFanpage/" target="_blank" rel="noopener" style="color:var(--teal-700);">Rumah Bahasa Surabaya Fanpage</a></div>
                    <div style="font-size:13px; color:var(--gray-500);">Instagram</div>
                    <div style="font-size:13px; font-weight:600; color:var(--gray-900);"><a href="https://www.instagram.com/rumahbahasasby/" target="_blank" rel="noopener" style="color:var(--teal-700);">@rumahbahasasby</a></div>
                    <div style="font-size:13px; color:var(--gray-500);">WhatsApp Business</div>
                    <div style="font-size:13px; font-weight:600; color:var(--gray-900);"><a href="https://wa.me/6285173040210" target="_blank" rel="noopener" style="color:var(--teal-700);">0851-7304-0210</a></div>
                    <div style="font-size:13px; color:var(--gray-500);">Telepon</div>
                    <div style="font-size:13px; font-weight:600; color:var(--gray-900);">(031) 5358856</div>
                </div>
            </div>

            {{-- Switch varian --}}
            <div style="display:flex; justify-content:center; gap:12px; margin-top:32px; flex-wrap:wrap;">
                <a href="{{ route('tata-cara', 'ktp-surabaya') }}" style="display:inline-flex; align-items:center; gap:8px; color:#fff; font-weight:600; font-size:14px; text-decoration:none; background:{{ $varian === 'ktp-surabaya' ? '#0c4e91' : '#fff' }}; color:{{ $varian === 'ktp-surabaya' ? '#fff' : 'var(--teal-700)' }}; border:1.5px solid var(--teal-600); padding:10px 22px; border-radius:8px; transition:background 0.2s;">KTP Surabaya</a>
                <a href="{{ route('tata-cara', 'ktp-non-surabaya') }}" style="display:inline-flex; align-items:center; gap:8px; font-weight:600; font-size:14px; text-decoration:none; background:{{ $varian === 'ktp-non-surabaya' ? '#0c4e91' : '#fff' }}; color:{{ $varian === 'ktp-non-surabaya' ? '#fff' : 'var(--teal-700)' }}; border:1.5px solid var(--teal-600); padding:10px 22px; border-radius:8px; transition:background 0.2s;">KTP Non-Surabaya</a>
            </div>
        </div>
    </div>
</section>
@endsection
