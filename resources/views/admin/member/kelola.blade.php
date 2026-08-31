@extends('layouts.admin')

@section('title', 'Kelola Member')

@section('content')
<div class="dashboard-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h3 style="margin:0;border:none;padding:0;">Kelola Member</h3>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.member.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Member CSV
            </a>
            <a href="{{ route('admin.pendaftaran.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Pendaftar CSV
            </a>
        </div>
    </div>

    <!-- Tab Navigation (mencolok: tombol solid + ikon) -->
    <div class="member-tabs" style="display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap;">
        <button type="button" class="member-tab active" data-tab="tab-member" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;font-size:13px;font-weight:600;border-radius:10px;cursor:pointer;border:1px solid #30363d;font-family:inherit;transition:all 0.15s;background:#3fb950;color:#0d1117;border-color:#3fb950;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Pendaftar Member ({{ $members->count() }})
        </button>
        <button type="button" class="member-tab" data-tab="tab-pendaftar" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;font-size:13px;font-weight:600;border-radius:10px;cursor:pointer;border:1px solid #30363d;font-family:inherit;transition:all 0.15s;background:#21262d;color:#c9d1d9;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            Pendaftar Program ({{ $daftar->count() }})
        </button>
    </div>

    <!-- Tab: Data Member -->
    <div id="tab-member" class="tab-content">
        @if($members->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $i => $member)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><div class="title-cell">{{ $member->name }}</div></td>
                                <td style="font-size:13px;">{{ $member->email }}</td>
                                <td style="font-size:13px;">{{ $member->phone ?: '-' }}</td>
                                <td style="font-size:13px;">{{ $member->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                <td>
                                    <span style="display:inline-block;padding:6px 14px;border-radius:50px;font-size:12px;font-weight:700;color:#ffffff;
                                        {{ $member->status === 'approved' ? 'background:#1d4ed8;' : '' }}
                                        {{ $member->status === 'pending' ? 'background:#eab308;' : '' }}
                                        {{ $member->status === 'rejected' ? 'background:#dc2626;' : '' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.member.show', $member->id) }}" class="btn-sm btn-edit" style="text-decoration:none;display:inline-block;">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada member terdaftar.</p>
        @endif
    </div>

    <!-- Tab: Pendaftar Program (Drill-down: Jenis → Mode → Kelas) -->
    <div id="tab-pendaftar" class="tab-content" style="display:none;">
        @php
            $jenisLabel = ['tematik' => 'Tematik', 'tentative' => 'Tentative'];
            $modeLabel = ['online' => 'Online', 'offline' => 'Offline'];

            // Hitung jumlah pendaftar per jenis & mode untuk badge
            $jumlahJenis = [];
            $jumlahMode = [];
            foreach ($grup as $jenis => $modes) {
                $jumlahJenis[$jenis] = 0;
                foreach ($modes as $mode => $kelasList) {
                    $jumlahMode[$jenis . '|' . $mode] = 0;
                    foreach ($kelasList as $k) {
                        $n = $k['anggota']->count();
                        $jumlahJenis[$jenis] += $n;
                        $jumlahMode[$jenis . '|' . $mode] += $n;
                    }
                }
            }
        @endphp

        {{-- ===== LANGKAH 1: PILIH JENIS (Tematik / Tentative) ===== --}}
        <div id="pd-step-jenis">
            <p style="font-size:13px;color:var(--gray-500);margin:0 0 16px;">Langkah 1 — Pilih jenis kelas untuk melihat daftar pendaftarnya.</p>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
                @foreach(['tematik', 'tentative'] as $jenis)
                    @php $jml = $jumlahJenis[$jenis] ?? 0; @endphp
                    <button type="button" onclick="pdPilihJenis('{{ $jenis }}')" style="text-align:left;padding:24px;border-radius:14px;cursor:pointer;border:2px solid #30363d;background:#0d1117;font-family:inherit;transition:all 0.2s;display:flex;flex-direction:column;gap:8px;"
                        onmouseover="this.style.borderColor='#3fb950';this.style.background='#161b22'" onmouseout="this.style.borderColor='#30363d';this.style.background='#0d1117'">
                        <span style="font-size:26px;">{{ $jenis === 'tematik' ? '📘' : '📗' }}</span>
                        <strong style="font-size:16px;color:#e6edf3;">Kelas {{ ucfirst($jenis) }}</strong>
                        <span style="font-size:12px;color:#8b949e;line-height:1.6;">
                            {{ $jenis === 'tematik' ? 'Daftar per minggu, materi & peserta berubah tiap pertemuan.' : 'Anggota tetap 1 semester penuh.' }}
                        </span>
                        <span style="display:inline-flex;align-items:center;gap:6px;margin-top:6px;padding:5px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#fff;{{ $jenis === 'tematik' ? 'background:#0369a1;' : 'background:#b45309;' }}">{{ $jml }} Pendaftar</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ===== LANGKAH 2: PILIH MODE (Online / Offline) ===== --}}
        <div id="pd-step-mode" style="display:none;">
            <p style="font-size:13px;color:var(--gray-500);margin:0 0 16px;">
                <a href="javascript:void(0)" onclick="pdKembaliJenis()" style="color:#3fb950;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Pilih Jenis Lain
                </a>
            </p>
            <div id="pd-mode-cards" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
                {{-- diisi JS --}}
            </div>
        </div>

        {{-- ===== LANGKAH 3: DAFTAR KELAS + ANGGOTA ===== --}}
        <div id="pd-step-kelas" style="display:none;">
            <p style="font-size:13px;color:var(--gray-500);margin:0 0 16px;">
                <a href="javascript:void(0)" onclick="pdKembaliMode()" style="color:#3fb950;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Pilih Mode Lain
                </a>
            </p>
            <div id="pd-kelas-list"></div>
        </div>
    </div>
</div>

<style>
    .pd-kelas-card {
        border: 1px solid #21262d;
        border-radius: 12px;
        overflow: hidden;
        background: #0d1117;
        margin-bottom: 16px;
    }
    .pd-kelas-card .pd-kelas-head {
        padding: 12px 18px;
        background: #161b22;
        border-bottom: 1px solid #21262d;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .pd-kelas-card .pd-kelas-head strong { font-size: 14px; color: #e6edf3; }
    .pd-kelas-card .pd-kelas-head .pd-info { font-size: 12px; color: #8b949e; margin-top: 2px; }
    .pd-mode-btn {
        text-align: left;
        padding: 20px;
        border-radius: 14px;
        cursor: pointer;
        border: 2px solid #30363d;
        background: #0d1117;
        font-family: inherit;
        transition: all 0.2s;
    }
    .pd-mode-btn:hover { border-color: #3fb950; background: #161b22; }
    .pd-mode-btn strong { font-size: 15px; color: #e6edf3; display: block; }
    .pd-mode-btn span { font-size: 12px; color: #8b949e; }
</style>

<style>
    @media (max-width: 480px) {
        .card-header-row { flex-direction: column; align-items: flex-start !important; gap: 8px !important; }
        .member-tabs { overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none; flex-wrap: nowrap; }
        .member-tabs::-webkit-scrollbar { display: none; }
        .member-tab { font-size: 12px !important; padding: 10px 16px !important; }
    }
</style>
<script>
// ===== DATA GRUP UNTUK DRILL-DOWN =====
const PD_GRUP = @json($grup);
const PD_JENIS_LABEL = @json($jenisLabel);
const PD_MODE_LABEL = @json($modeLabel);

// Tampilkan langkah tertentu
function pdShow(id) {
    document.getElementById('pd-step-jenis').style.display = id === 'jenis' ? '' : 'none';
    document.getElementById('pd-step-mode').style.display = id === 'mode' ? '' : 'none';
    document.getElementById('pd-step-kelas').style.display = id === 'kelas' ? '' : 'none';
}

function pdPilihJenis(jenis) {
    const modes = PD_GRUP[jenis] || {};
    const wrap = document.getElementById('pd-mode-cards');
    wrap.innerHTML = '';

    ['online', 'offline'].forEach(mode => {
        const kelasList = modes[mode] || [];
        const jml = kelasList.reduce((a, k) => a + (k.anggota ? k.anggota.length : 0), 0);
        if (jml === 0) return; // skip mode tanpa pendaftar

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pd-mode-btn';
        btn.innerHTML = '<strong>📁 ' + (PD_MODE_LABEL[mode] || mode) + '</strong>' +
            '<span style="display:block;margin-top:4px;">' + jml + ' pendaftar</span>' +
            '<span style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:5px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#fff;background:#1d4ed8;">Buka</span>';
        btn.onclick = function() { pdPilihMode(jenis, mode); };
        wrap.appendChild(btn);
    });

    if (!wrap.children.length) {
        wrap.innerHTML = '<p style="color:#8b949e;font-size:13px;padding:20px;border:1px dashed #30363d;border-radius:12px;">Belum ada pendaftar untuk kelas ' + (PD_JENIS_LABEL[jenis] || jenis) + '.</p>';
    }

    pdShow('mode');
}

function pdPilihMode(jenis, mode) {
    const kelasList = (PD_GRUP[jenis] || {})[mode] || [];
    const wrap = document.getElementById('pd-kelas-list');
    wrap.innerHTML = '';

    if (!kelasList.length) {
        wrap.innerHTML = '<p style="color:#8b949e;font-size:13px;padding:20px;">Belum ada pendaftar.</p>';
        pdShow('kelas');
        return;
    }

    kelasList.forEach(kelas => {
        const anggota = kelas.anggota || [];
        const card = document.createElement('div');
        card.className = 'pd-kelas-card';

        let rows = '';
        anggota.forEach((p, i) => {
            const st = p.status === 'confirmed'
                ? '<span style="display:inline-block;padding:5px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#fff;background:#1d4ed8;">Terdaftar</span>'
                : (p.status === 'rejected'
                    ? '<span style="display:inline-block;padding:5px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#fff;background:#dc2626;">Kuota Penuh</span>'
                    : '<span style="display:inline-block;padding:5px 12px;border-radius:50px;font-size:12px;font-weight:700;color:#fff;background:#eab308;">' + (p.status || '-') + '</span>');
            rows += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td style="white-space:nowrap;font-weight:600;color:#0882c4;">' + (p.user && p.user.no_member ? p.user.no_member : '-') + '</td>' +
                '<td><div class="title-cell">' + (p.user ? p.user.name : '-') + '</div></td>' +
                '<td style="word-break:break-word;">' + (p.user ? p.user.email : '-') + '</td>' +
                '<td style="white-space:nowrap;">' + (p.user && p.user.phone ? p.user.phone : '-') + '</td>' +
                '<td>' + st + '</td>' +
                '<td style="white-space:nowrap;font-size:13px;">' + (p.created_at || '') + '</td>' +
                '</tr>';
        });

        card.innerHTML =
            '<div class="pd-kelas-head">' +
                '<div>' +
                    '<strong>📁 ' + kelas.kelas + '</strong>' +
                    '<div class="pd-info">' + kelas.hari + ', ' + kelas.jam_mulai + ' - ' + kelas.jam_selesai +
                        (kelas.pengajar ? ' &middot; ' + kelas.pengajar : '') + '</div>' +
                '</div>' +
                '<span style="font-size:12px;font-weight:600;padding:4px 12px;border-radius:50px;background:#1d4ed8;color:#fff;">' + anggota.length + ' / ' + (kelas.kuota || '-') + ' Pendaftar</span>' +
            '</div>' +
            '<div class="table-wrap">' +
                '<table class="data-table">' +
                    '<thead><tr><th>No</th><th>Nomor Member</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Status</th><th>Tanggal</th></tr></thead>' +
                    '<tbody>' + rows + '</tbody>' +
                '</table>' +
            '</div>';

        wrap.appendChild(card);
    });

    pdShow('kelas');
}

function pdKembaliJenis() { pdShow('jenis'); }
function pdKembaliMode() { pdShow('mode'); }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.member-tab');
    const contents = {
        'tab-member': document.getElementById('tab-member'),
        'tab-pendaftar': document.getElementById('tab-pendaftar'),
    };

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Deactivate all tabs (gaya tombol tidak aktif)
            tabs.forEach(t => {
                t.style.background = '#21262d';
                t.style.color = '#c9d1d9';
                t.style.borderColor = '#30363d';
                t.style.fontWeight = '600';
            });
            // Hide all contents
            Object.values(contents).forEach(c => { if (c) c.style.display = 'none'; });

            // Activate clicked tab (hijau solid)
            this.style.background = '#3fb950';
            this.style.color = '#0d1117';
            this.style.borderColor = '#3fb950';

            const target = contents[this.dataset.tab];
            if (target) target.style.display = '';

            // Reset drill-down ke langkah 1 setiap buka tab pendaftar
            if (this.dataset.tab === 'tab-pendaftar') {
                pdShow('jenis');
            }
        });
    });
});
</script>
@endsection