@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="dashboard-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h3 style="margin:0;border:none;padding:0;">Laporan</h3>
            <p style="margin:4px 0 0;font-size:13px;color:#8b949e;">Periode: <strong style="color:#e6edf3;">{{ $label }}</strong>
                @if($periode !== 'semua')
                    <span style="color:#6e7681;">— hanya pendaftaran berstatus Terdaftar (confirmed)</span>
                @endif
            </p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <a href="{{ route('admin.laporan.index', ['periode' => 'minggu']) }}" class="btn-login" style="padding:8px 16px;font-size:12px;text-decoration:none;">Pekan Ini</a>
            <a href="{{ route('admin.laporan.index', ['periode' => 'bulan']) }}" class="btn-login" style="padding:8px 16px;font-size:12px;text-decoration:none;">Bulan Ini</a>
            <a href="{{ route('admin.laporan.index', ['periode' => 'semua']) }}" class="btn-login" style="padding:8px 16px;font-size:12px;text-decoration:none;">Semua</a>
            <a href="javascript:void(0)" onclick="exportLaporan()" class="btn-login" style="padding:8px 16px;font-size:12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export XLS
            </a>
        </div>
    </div>

    {{-- Filter periode --}}
    <form method="GET" action="{{ route('admin.laporan.index') }}" style="display:flex;align-items:flex-end;gap:16px;flex-wrap:wrap;padding:16px;background:#1c2129;border:1px solid #30363d;border-radius:12px;margin-bottom:24px;">
        <div>
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#8b949e;text-transform:uppercase;letter-spacing:0.5px;">Jenis Periode</p>
            <div style="display:flex;gap:16px;flex-wrap:wrap;">
                <label style="display:flex;align-items:center;gap:6px;font-size:13px;color:#e6edf3;cursor:pointer;">
                    <input type="radio" name="periode" value="minggu" {{ $periode === 'minggu' ? 'checked' : '' }} onchange="setPeriode()"> Mingguan
                </label>
                <label style="display:flex;align-items:center;gap:6px;font-size:13px;color:#e6edf3;cursor:pointer;">
                    <input type="radio" name="periode" value="bulan" {{ $periode === 'bulan' ? 'checked' : '' }} onchange="setPeriode()"> Bulanan
                </label>
                <label style="display:flex;align-items:center;gap:6px;font-size:13px;color:#e6edf3;cursor:pointer;">
                    <input type="radio" name="periode" value="semua" {{ $periode === 'semua' ? 'checked' : '' }} onchange="setPeriode()"> Keseluruhan
                </label>
            </div>
        </div>
        <div id="wrapMinggu" style="display:none;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#8b949e;text-transform:uppercase;letter-spacing:0.5px;">Pilih Minggu</p>
            <input type="week" id="inputMinggu" name="minggu" value="{{ request()->get('minggu', now()->format('o-W')) }}"
                style="padding:9px 12px;background:#0d1117;border:1px solid #30363d;border-radius:8px;color:#e6edf3;font-size:13px;font-family:inherit;color-scheme:dark;">
        </div>
        <div id="wrapBulan" style="display:none;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#8b949e;text-transform:uppercase;letter-spacing:0.5px;">Pilih Bulan</p>
            <input type="month" id="inputBulan" name="bulan" value="{{ request()->get('bulan', now()->format('Y-m')) }}"
                style="padding:9px 12px;background:#0d1117;border:1px solid #30363d;border-radius:8px;color:#e6edf3;font-size:13px;font-family:inherit;color-scheme:dark;">
        </div>
        <button type="submit" class="btn-login" style="padding:10px 20px;font-size:13px;border:none;cursor:pointer;">Tampilkan</button>
    </form>

    {{-- Ringkasan --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:24px;">
        <div class="dashboard-card" style="text-align:center;padding:20px 16px;">
            <div style="font-size:30px;font-weight:800;color:#e6edf3;">{{ $ringkasan['total_pendaftar'] }}</div>
            <p style="color:#8b949e;font-size:12px;margin-top:4px;">Pendaftar (confirmed)</p>
        </div>
        <div class="dashboard-card" style="text-align:center;padding:20px 16px;">
            <div style="font-size:30px;font-weight:800;color:#e6edf3;">{{ $ringkasan['total_member'] }}</div>
            <p style="color:#8b949e;font-size:12px;margin-top:4px;">Member Unik</p>
        </div>
        <div class="dashboard-card" style="text-align:center;padding:20px 16px;">
            <div style="font-size:30px;font-weight:800;color:#e6edf3;">{{ $ringkasan['member_approved'] }}</div>
            <p style="color:#8b949e;font-size:12px;margin-top:4px;">Member Disetujui</p>
        </div>
    </div>

    {{-- Breakdown per kategori --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;margin-bottom:24px;">
        <div class="dashboard-card" style="padding:16px 20px;">
            <h4 style="margin:0 0 10px;font-size:14px;color:#e6edf3;">Per Kelas / Program</h4>
            @if($ringkasan['per_kelas']->count())
                @foreach($ringkasan['per_kelas'] as $kelas => $jumlah)
                    <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #3d444d;font-size:13px;">
                        <span style="color:#c9d1d9;">{{ $kelas }}</span>
                        <strong style="color:#3fb950;">{{ $jumlah }}</strong>
                    </div>
                @endforeach
            @else
                <p class="text-muted" style="text-align:center;padding:16px;">Tidak ada data.</p>
            @endif
        </div>
        <div class="dashboard-card" style="padding:16px 20px;">
            <h4 style="margin:0 0 10px;font-size:14px;color:#e6edf3;">Per Jenis &amp; Mode</h4>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <p style="margin:0 0 6px;font-size:12px;font-weight:700;color:#8b949e;text-transform:uppercase;">Jenis</p>
                    @if($ringkasan['per_jenis']->count())
                        @foreach($ringkasan['per_jenis'] as $j => $jum)
                            <div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;">
                                <span style="color:#c9d1d9;">{{ ucfirst($j) }}</span>
                                <strong style="color:#3fb950;">{{ $jum }}</strong>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted" style="font-size:12px;">-</p>
                    @endif
                </div>
                <div>
                    <p style="margin:0 0 6px;font-size:12px;font-weight:700;color:#8b949e;text-transform:uppercase;">Mode</p>
                    @if($ringkasan['per_mode']->count())
                        @foreach($ringkasan['per_mode'] as $m => $jum)
                            <div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;">
                                <span style="color:#c9d1d9;">{{ ucfirst($m) }}</span>
                                <strong style="color:#3fb950;">{{ $jum }}</strong>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted" style="font-size:12px;">-</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Detail pendaftar --}}
    <h4 style="margin:0 0 12px;font-size:14px;color:#e6edf3;">Detail Pendaftar</h4>
    @if($daftar->count())
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Daftar</th>
                        <th>No Member</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Usia</th>
                        <th>Pekerjaan</th>
                        <th>Jenis</th>
                        <th>Mode</th>
                        <th>Kelas / Program</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftar as $i => $p)
                        @php $u = $p->user; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="white-space:nowrap;">{{ $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                            <td><span style="font-family:monospace;font-weight:700;color:#58a6ff;">{{ $u && $u->no_member ? $u->no_member : '-' }}</span></td>
                            <td style="font-weight:600;">{{ $u ? $u->name : '-' }}</td>
                            <td>{{ $u && $u->nik ? $u->nik : '-' }}</td>
                            <td>{{ $u && $u->usia_label ? $u->usia_label : '-' }}</td>
                            <td>{{ $u && $u->jenis_pekerjaan ? $u->jenis_pekerjaan : '-' }}</td>
                            <td>{{ ucfirst($p->jenis) }}</td>
                            <td>{{ ucfirst($p->mode) }}</td>
                            <td style="font-weight:600;color:#c9d1d9;">{{ $p->jadwal ? $p->jadwal->nama_kelas : ($p->program ?: 'Tanpa kelas') }}</td>
                            <td>
                                @if($u)
                                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:50px;color:#fff;
                                        {{ $u->status === 'approved' ? 'background:#1d4ed8;' : '' }}
                                        {{ $u->status === 'pending' ? 'background:#eab308;' : '' }}
                                        {{ $u->status === 'rejected' ? 'background:#dc2626;' : '' }}">
                                        {{ ucfirst($u->status) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="dashboard-card" style="text-align:center;padding:32px;">
            <p class="text-muted">Tidak ada pendaftar (confirmed) pada periode ini.</p>
        </div>
    @endif
</div>

<script>
function setPeriode() {
    const kind = document.querySelector('input[name="periode"]:checked').value;
    document.getElementById('wrapMinggu').style.display = kind === 'minggu' ? 'block' : 'none';
    document.getElementById('wrapBulan').style.display = kind === 'bulan' ? 'block' : 'none';
}
setPeriode();

function exportLaporan() {
    const kind = document.querySelector('input[name="periode"]:checked').value;
    const p = new URLSearchParams({ periode: kind });
    if (kind === 'minggu') {
        p.set('minggu', document.getElementById('inputMinggu').value || '');
    } else if (kind === 'bulan') {
        p.set('bulan', document.getElementById('inputBulan').value || '');
    }
    window.location.href = "{{ route('admin.laporan.export') }}?" + p.toString();
}
</script>
@endsection