@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')
{{-- Statistik Cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:40px;">
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:var(--teal-700);">{{ $stats['berita'] }}</div>
        <p style="color:var(--gray-500);font-size:13px;margin-top:4px;">Berita</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:var(--teal-700);">{{ $stats['member'] }}</div>
        <p style="color:var(--gray-500);font-size:13px;margin-top:4px;">Member</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:{{ $stats['pending'] > 0 ? '#b45309' : 'var(--teal-700)' }};">{{ $stats['pending'] }}</div>
        <p style="color:var(--gray-500);font-size:13px;margin-top:4px;">Pending</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:{{ $stats['pesan_baru'] > 0 ? '#dc2626' : 'var(--teal-700)' }};">{{ $stats['pesan_baru'] }}</div>
        <p style="color:var(--gray-500);font-size:13px;margin-top:4px;">Pesan Baru</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        <h3>Pendaftar Terbaru</h3>
        @if($recentPendaftar->count())
            @foreach($recentPendaftar as $p)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--gray-100);">
                    <div>
                        <p style="font-weight:600;color:var(--gray-900);">{{ $p->user->name }}</p>
                        <p style="font-size:13px;color:var(--gray-400);">{{ $p->program }}</p>
                    </div>
                    <span style="font-size:12px;font-weight:600;padding:2px 10px;border-radius:50px;background:#fffbeb;color:#b45309;">{{ ucfirst($p->status) }}</span>
                </div>
            @endforeach
            <a href="{{ route('admin.pendaftaran.index') }}" style="display:block;text-align:center;padding:12px;color:var(--teal-700);font-size:13px;font-weight:600;">Lihat Semua →</a>
        @else
            <p class="text-muted" style="text-align:center;padding:24px;">Belum ada pendaftar.</p>
        @endif
    </div>
    <div class="dashboard-card">
        <h3>Pesan Baru</h3>
        @if($recentPesan->count())
            @foreach($recentPesan as $p)
                <div style="padding:12px 0;border-bottom:1px solid var(--gray-100);">
                    <p style="font-weight:600;color:var(--gray-900);">{{ $p->nama }}</p>
                    <p style="font-size:13px;color:var(--gray-500);">{{ Str::limit($p->pesan, 80) }}</p>
                </div>
            @endforeach
            <a href="{{ route('admin.kontak.index') }}" style="display:block;text-align:center;padding:12px;color:var(--teal-700);font-size:13px;font-weight:600;">Lihat Semua →</a>
        @else
            <p class="text-muted" style="text-align:center;padding:24px;">Tidak ada pesan baru.</p>
        @endif
    </div>
</div>
@endsection
