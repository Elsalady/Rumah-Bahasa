@extends('layouts.admin')

@section('content')
<div class="dashboard-card">
    <div class="card-header-row" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <h3 style="margin:0;border:none;padding:0;">Laporan Pendaftar Program ({{ $daftar->count() }})</h3>
        <a href="{{ route('admin.pendaftaran.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </a>
    </div>

    @php
        $jenisLabel = ['tematik' => 'Tematik', 'tentative' => 'Tentative'];
        $modeLabel = ['online' => 'Online', 'offline' => 'Offline'];
        $totalKelompok = 0;
        foreach ($grup as $modes) { foreach ($modes as $kelasList) { $totalKelompok += count($kelasList); } }
    @endphp

    @if($totalKelompok > 0)
        @foreach($grup as $jenis => $modes)
            {{-- ===== JENIS: TEMATIK / TENTATIVE ===== --}}
            <div style="margin-bottom:36px;">
                <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:50px;font-size:14px;font-weight:700;color:#fff;margin-bottom:16px;
                    {{ $jenis === 'tematik' ? 'background:#0369a1;' : 'background:#b45309;' }}">
                    {{ $jenisLabel[$jenis] ?? ucfirst($jenis) }}
                </div>

                @foreach($modes as $mode => $kelasList)
                    @if(count($kelasList))
                        {{-- ===== MODE: ONLINE / OFFLINE ===== --}}
                        <div style="margin:0 0 24px 16px;">
                            <div style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;color:var(--gray-700);margin-bottom:12px;">
                                <span style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:50px;background:var(--gray-100);color:var(--gray-700);">
                                    {{ $modeLabel[$mode] ?? ucfirst($mode) }}
                                </span>
                                <span style="font-weight:400;color:var(--gray-400);font-size:12px;">{{ $kelasList[0]['anggota']->count() }} pendaftar</span>
                            </div>

                            @foreach($kelasList as $kelas)
                                {{-- ===== KELAS ===== --}}
                                <div style="margin:0 0 20px 16px;border:1px solid var(--gray-200);border-radius:12px;overflow:hidden;background:#fff;">
                                    <div style="padding:12px 18px;background:var(--gray-50);border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                                        <div>
                                            <strong style="font-size:14px;color:var(--gray-900);">{{ $kelas['kelas'] }}</strong>
                                            <div style="font-size:12px;color:var(--gray-500);margin-top:2px;">
                                                {{ $kelas['hari'] }}, {{ \Carbon\Carbon::parse($kelas['jam_mulai'])->format('H:i') }} - {{ \Carbon\Carbon::parse($kelas['jam_selesai'])->format('H:i') }} WIB
                                                @if($kelas['pengajar']) &middot; {{ $kelas['pengajar'] }} @endif
                                            </div>
                                        </div>
                                        <div style="display:flex;align-items:center;gap:8px;">
                                            <span style="font-size:12px;font-weight:600;padding:4px 12px;border-radius:50px;background:#1d4ed8;color:#fff;">{{ $kelas['anggota']->count() }} / {{ $kelas['kuota'] ?: '-' }} Pendaftar</span>
                                        </div>
                                    </div>

                                    @if($kelas['anggota']->count())
                                        <div class="table-wrap">
                                            <table class="data-table">
                                                <thead><tr><th>Kode Member</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Status</th><th>Tanggal Daftar</th></tr></thead>
                                                <tbody>
                                                    @foreach($kelas['anggota'] as $p)
                                                        <tr>
                                                            <td><span style="font-family:monospace;font-size:12px;font-weight:600;color:var(--teal-700);">{{ optional($p->user)->member_code ?: '-' }}</span></td>
                                                            <td><div class="title-cell">{{ $p->user->name }}</div></td>
                                                            <td style="font-size:13px;">{{ $p->user->email }}</td>
                                                            <td style="font-size:13px;">{{ $p->user->phone ?: '-' }}</td>
                                                            <td>
                                                                <span style="display:inline-block;padding:5px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#ffffff;
                                                                    {{ $p->status === 'confirmed' ? 'background:#1d4ed8;' : '' }}
                                                                    {{ $p->status === 'rejected' ? 'background:#dc2626;' : '' }}">
                                                                    {{ $p->status === 'confirmed' ? 'Terdaftar' : ($p->status === 'rejected' ? 'Kuota Penuh' : ucfirst($p->status)) }}
                                                                </span>
                                                            </td>
                                                            <td style="font-size:13px;">{{ $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted" style="text-align:center;padding:20px;">Belum ada pendaftar di kelas ini.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    @else
        <p class="text-muted" style="text-align:center;padding:40px;">Belum ada pendaftar program.</p>
    @endif
</div>
@endsection
