@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')
{{-- Statistik Cards --}}
<div class="admin-stat-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:40px;">
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['berita'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Berita</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['profil'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Profil</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['pending'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Pending Program</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['confirmed'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Pendaftar Disetujui</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['pending_member'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Pending Member</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['member'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Pendaftar</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['jadwal_kelas'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Jadwal Kelas</p>
    </div>
    <div class="dashboard-card" style="text-align:center;padding:28px 20px;">
        <div style="font-size:36px;font-weight:800;color:#e6edf3;">{{ $stats['pesan_baru'] }}</div>
        <p style="color:#8b949e;font-size:13px;margin-top:4px;">Pesan Baru</p>
    </div>
</div>

<div class="admin-dashboard-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        <h3>Member Terbaru</h3>
        @if($recentPendaftar->count())
            @foreach($recentPendaftar as $p)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #21262d;">
                    <div style="min-width:0;">
                        <p style="font-weight:600;color:#e6edf3;margin:0;">{{ $p->name }}</p>
                        <p style="font-size:13px;color:#8b949e;margin:2px 0 0;">{{ $p->email }}</p>
                        <p style="font-size:11px;color:#6e7681;margin:2px 0 0;">{{ $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }} WIB</p>
                    </div>
                    <span style="font-size:12px;font-weight:700;padding:4px 12px;border-radius:50px;color:#ffffff;
                        {{ $p->status === 'approved' ? 'background:#1d4ed8;' : '' }}
                        {{ $p->status === 'pending' ? 'background:#eab308;' : '' }}
                        {{ $p->status === 'rejected' ? 'background:#dc2626;' : '' }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
            @endforeach
            <a href="{{ route('admin.member.kelola') }}" style="display:block;text-align:center;padding:12px;color:#58a6ff;font-size:13px;font-weight:600;">Lihat Semua →</a>
        @else
            <p class="text-muted" style="text-align:center;padding:24px;">Belum ada member terdaftar.</p>
        @endif
    </div>
    <div class="dashboard-card">
        <h3>Pesan Terbaru</h3>
        @if($recentPesan->count())
            @foreach($recentPesan as $p)
                <div style="padding:12px 0;border-bottom:1px solid #21262d;">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                        <p style="font-weight:600;color:#e6edf3;margin:0;">{{ $p->nama }}</p>
                        @if(!$p->sudah_dibaca)
                            <span style="font-size:11px;font-weight:700;background:#da3633;color:#fff;padding:2px 8px;border-radius:50px;">Baru</span>
                        @endif
                    </div>
                    <p style="font-size:13px;color:#8b949e;margin:4px 0 0;">{{ Str::limit($p->pesan, 80) }}</p>
                </div>
            @endforeach
            <a href="{{ route('admin.kontak.index') }}" style="display:block;text-align:center;padding:12px;color:#58a6ff;font-size:13px;font-weight:600;">Lihat Semua →</a>
        @else
            <p class="text-muted" style="text-align:center;padding:24px;">Tidak ada pesan.</p>
        @endif
    </div>
</div>
@endsection
