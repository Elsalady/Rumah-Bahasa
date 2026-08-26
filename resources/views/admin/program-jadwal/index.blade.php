@extends('layouts.admin')

@section('title', 'Program & Jadwal')

@section('content')
<style>
    .program-card {
        background: #161b22;
        border: 1px solid #21262d;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: none;
        overflow: hidden;
    }
    .program-card-header {
        padding: 18px 24px;
        background: #0d1117;
        border-bottom: 1px solid #21262d;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        cursor: pointer;
        transition: background 0.2s;
    }
    .program-card-header:hover { background: #0d1117; }
    .program-card-header .left { display:flex;align-items:center;gap:12px;flex:1;min-width:0; }
    .program-card-header h3 { margin:0;font-size:16px;font-weight:600;color:#e6edf3; }
    .program-card-body { padding: 24px; }
    .toggle-icon { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#8b949e; background:#21262d; padding:4px 10px 4px 8px; border-radius:6px; border:1px solid #30363d; transition:all 0.2s; white-space:nowrap; }
    .toggle-icon:hover { background:#30363d; color:#e6edf3; }
    .toggle-icon.open { background:rgba(63,185,80,0.1); color:#3fb950; }
    .toggle-icon svg { width:16px; height:16px; }
    .jadwal-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: #0d1117;
        border: 1px solid #21262d;
        border-radius: 8px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .jadwal-row:hover { background: #161b22; }
    .btn-add-jadwal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #3fb950;
        color: #0d1117;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        font-family: inherit;
    }
    .btn-add-jadwal:hover { background: #56d364; }
    .jadwal-form {
        background: #0d1117;
        border: 1px solid #30363d;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 16px;
        display: none;
    }
    .jadwal-form.open { display: block; }
    .jadwal-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    @media (max-width:768px) { .jadwal-form-grid { grid-template-columns: 1fr; } }
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <h3 style="margin:0;">Program & Jadwal Kelas</h3>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('admin.program.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;background:#3fb950;color:#0d1117;border:none;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#56d364'" onmouseout="this.style.background='#3fb950'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Program
        </a>
        <span style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background:rgba(63,185,80,0.1);color:#3fb950;border:1px solid rgba(63,185,80,0.3);border-radius:8px;font-size:13px;font-weight:600;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Minggu ini: {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('d M') }} — {{ \Carbon\Carbon::now()->endOfWeek()->translatedFormat('d M Y') }}
        </span>
    </div>
</div>

@if($program->count())
    @foreach($program as $prog)
        @php
            $keyword = str_replace('Kelas ', '', $prog->nama);
            $jadwalProgram = $allJadwal->filter(function ($items, $key) use ($keyword) {
                return stripos($key, $keyword) !== false;
            })->flatten();
        @endphp
        <div class="program-card">
            <div class="program-card-header" onclick="toggleProgram({{ $prog->id }})">
                <div class="left">
                    @if($prog->ikon)
                        <span style="font-size:24px;">{!! $prog->ikon !!}</span>
                    @endif
                    <div>
                        <h3>{{ $prog->nama }}</h3>
                        <p style="font-size:12px;color:var(--gray-400);margin:2px 0 0;">
                            {{ $jadwalProgram->count() }} jadwal
                            @if($prog->link_wa) &middot; <a href="{{ $prog->link_wa }}" target="_blank" style="color:#25d366;">WA Grup</a> @endif
                        </p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <a href="{{ route('admin.program.index', ['edit' => $prog->id]) }}" class="btn-sm btn-edit" style="text-decoration:none;" onclick="event.stopPropagation();">Edit</a>
                    <span class="toggle-icon" id="toggle-{{ $prog->id }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Jadwal
                    </span>
                </div>
            </div>
            <div class="program-card-body" id="body-{{ $prog->id }}" style="display:none;">
                {{-- Form tambah jadwal --}}
                <div class="jadwal-form" id="form-{{ $prog->id }}">
                    <h4 style="margin:0 0 12px;font-size:14px;">Tambah Jadwal untuk {{ $prog->nama }}</h4>
                    <form action="{{ route('admin.jadwal-kelas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nama_kelas" value="{{ $keyword }}">
                        <div class="jadwal-form-grid">
                            <div class="form-group">
                                <label>Hari</label>
                                <select name="hari" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;" required>
                                    <option value="">— Pilih —</option>
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                                        <option value="{{ $h }}">{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;" required>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                <div class="form-group">
                                    <label>Jam Mulai</label>
                                    <input type="time" name="jam_mulai" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;" required>
                                </div>
                                <div class="form-group">
                                    <label>Jam Selesai</label>
                                    <input type="time" name="jam_selesai" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pengajar</label>
                                <input type="text" name="pengajar" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;">
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select name="jenis" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;" required>
                                        <option value="tematik">Tematik</option>
                                        <option value="tentative">Tentative</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Mode</label>
                                    <select name="mode" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;" required>
                                        <option value="offline">Offline</option>
                                        <option value="online">Online</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ruangan / Link</label>
                                <input type="text" name="ruangan_link" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;">
                            </div>
                            <div class="form-group">
                                <label>Kuota</label>
                                <input type="number" name="kuota" value="0" min="0" style="width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;background:#fff;">
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;margin-top:12px;">
                            <button type="submit" class="btn-submit" style="padding:10px 20px;font-size:13px;width:auto;">Simpan Jadwal</button>
                            <button type="button" onclick="document.getElementById('form-{{ $prog->id }}').classList.remove('open')" style="padding:10px 20px;font-size:13px;background:var(--gray-200);color:var(--gray-700);border:none;border-radius:8px;cursor:pointer;">Batal</button>
                        </div>
                    </form>
                </div>

                @if($jadwalProgram->count())
                    @php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                    @foreach($hariList as $hari)
                        @php $hariJadwal = $jadwalProgram->where('hari', $hari); @endphp
                        @if($hariJadwal->count())
                            <div style="margin-bottom:12px;">
                                <p style="font-size:13px;font-weight:700;color:var(--teal-700);margin:0 0 6px;">{{ $hari }}</p>
                                @foreach($hariJadwal as $item)
                                    <div class="jadwal-row">
                                        <div style="flex:1;min-width:120px;">
                                            <p style="font-weight:600;font-size:13px;color:var(--gray-900);margin:0;">
                                                {{ $item->tanggal ? $item->tanggal->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') . ' (' . $item->hari . ')' : $item->hari }}
                                                &middot; {{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }} - {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}
                                            </p>
                                            @if($item->pengajar)
                                                <p style="font-size:11px;color:var(--gray-400);margin:2px 0 0;">{{ $item->pengajar }}</p>
                                            @endif
                                        </div>
                                        <div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap;">
                                            <span style="display:inline-block;padding:2px 6px;border-radius:50px;font-size:10px;font-weight:600;background:#21262d;color:#c9d1d9;border:1px solid #30363d;">{{ ucfirst($item->jenis) }}</span>
                                            <span style="display:inline-block;padding:2px 6px;border-radius:50px;font-size:10px;font-weight:600;background:#21262d;color:#c9d1d9;border:1px solid #30363d;">{{ ucfirst($item->mode) }}</span>
                                            @if($item->ruangan_link)
                                                <span style="font-size:10px;color:var(--gray-500);">{{ $item->ruangan_link }}</span>
                                            @endif
                                            @if($item->kuota > 0)
                                                <span style="font-size:10px;font-weight:600;color:#c9d1d9;">Kuota:{{ $item->kuota }}</span>
                                            @endif
                                        </div>
                                        <div style="display:flex;gap:4px;">
                                            <form action="{{ route('admin.jadwal-kelas.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-sm btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    <p style="font-size:13px;color:var(--gray-400);text-align:center;padding:20px;">Belum ada jadwal untuk program ini.</p>
                @endif

                <button type="button" class="btn-add-jadwal" onclick="document.getElementById('form-{{ $prog->id }}').classList.toggle('open')">+ Tambah Jadwal</button>
            </div>
        </div>
    @endforeach
@else
    <div style="text-align:center;padding:60px;">
        <p style="color:var(--gray-400);margin-bottom:20px;">Belum ada program kelas.</p>
        <a href="{{ route('admin.program.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:#3fb950;color:#0d1117;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Program Kelas
        </a>
    </div>
@endif

<script>
function toggleProgram(id) {
    const body = document.getElementById('body-' + id);
    const toggle = document.getElementById('toggle-' + id);
    if (body.style.display === 'none') {
        body.style.display = 'block';
        toggle.classList.add('open');
    } else {
        body.style.display = 'none';
        toggle.classList.remove('open');
    }
}
</script>
@endsection
