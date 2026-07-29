@extends('layouts.admin')

@section('title', 'Program & Jadwal')

@section('content')
<style>
    .program-card {
        background: #fff;
        border: 1px solid var(--gray-100);
        border-radius: 16px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .program-card-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, #f8fafc, #f0fdfa);
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        cursor: pointer;
        transition: background 0.2s;
    }
    .program-card-header:hover { background: linear-gradient(135deg, #f1f5f9, #e8f5e9); }
    .program-card-header .left { display:flex;align-items:center;gap:12px;flex:1;min-width:0; }
    .program-card-header h3 { margin:0;font-size:18px;font-weight:700;color:var(--gray-900); }
    .program-card-body { padding: 24px; }
    .toggle-icon { font-size:12px;color:var(--gray-400);transition:transform 0.2s; }
    .toggle-icon.open { transform:rotate(90deg); }
    .jadwal-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .jadwal-row:hover { background: #f1f5f9; }
    .btn-add-jadwal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #0c4e91;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-add-jadwal:hover { background: #4d9ce2; }
    .jadwal-form {
        background: #f8fafc;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
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

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h3 style="margin:0;">Program & Jadwal Kelas</h3>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if($layanan->count())
    @foreach($layanan as $program)
        @php
            $keyword = str_replace('Kelas ', '', $program->nama);
            $jadwalProgram = $allJadwal->filter(function($items, $key) use ($keyword) {
                return stripos($key, $keyword) !== false;
            })->flatten();
        @endphp
        <div class="program-card">
            <div class="program-card-header" onclick="toggleProgram({{ $program->id }})">
                <div class="left">
                    @if($program->ikon)
                        <span style="font-size:24px;">{!! $program->ikon !!}</span>
                    @endif
                    <div>
                        <h3>{{ $program->nama }}</h3>
                        <p style="font-size:12px;color:var(--gray-400);margin:2px 0 0;">
                            {{ $jadwalProgram->count() }} jadwal
                            @if($program->link_wa) &middot; <a href="{{ $program->link_wa }}" target="_blank" style="color:#25d366;">WA Grup</a> @endif
                        </p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <a href="{{ route('admin.layanan.index', ['edit' => $program->id]) }}" class="btn-sm btn-edit" style="text-decoration:none;" onclick="event.stopPropagation();">Edit</a>
                    <span class="toggle-icon" id="toggle-{{ $program->id }}">▶</span>
                </div>
            </div>
            <div class="program-card-body" id="body-{{ $program->id }}" style="display:none;">
                {{-- Form tambah jadwal --}}
                <div class="jadwal-form" id="form-{{ $program->id }}">
                    <h4 style="margin:0 0 12px;font-size:14px;">Tambah Jadwal untuk {{ $program->nama }}</h4>
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
                            <button type="button" onclick="document.getElementById('form-{{ $program->id }}').classList.remove('open')" style="padding:10px 20px;font-size:13px;background:var(--gray-200);color:var(--gray-700);border:none;border-radius:8px;cursor:pointer;">Batal</button>
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
                                            <p style="font-weight:600;font-size:13px;color:var(--gray-900);margin:0;">{{ $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-' }} - {{ $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-' }}</p>
                                            @if($item->pengajar)
                                                <p style="font-size:11px;color:var(--gray-400);margin:2px 0 0;">{{ $item->pengajar }}</p>
                                            @endif
                                        </div>
                                        <div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap;">
                                            <span style="display:inline-block;padding:2px 6px;border-radius:50px;font-size:10px;font-weight:600;{{ $item->jenis === 'tematik' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#fef3c7;color:#b45309;' }}">{{ ucfirst($item->jenis) }}</span>
                                            <span style="display:inline-block;padding:2px 6px;border-radius:50px;font-size:10px;font-weight:600;{{ $item->mode === 'online' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#ecfdf5;color:#166534;' }}">{{ ucfirst($item->mode) }}</span>
                                            @if($item->ruangan_link)
                                                <span style="font-size:10px;color:var(--gray-500);">{{ $item->ruangan_link }}</span>
                                            @endif
                                            @if($item->kuota > 0)
                                                <span style="font-size:10px;font-weight:600;color:#1e40af;">Kuota:{{ $item->kuota }}</span>
                                            @endif
                                        </div>
                                        <div style="display:flex;gap:4px;">
                                            <a href="{{ route('admin.jadwal-kelas.index', ['edit' => $item->id]) }}" class="btn-sm btn-edit" style="text-decoration:none;">Edit</a>
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

                <button type="button" class="btn-add-jadwal" onclick="document.getElementById('form-{{ $program->id }}').classList.toggle('open')">+ Tambah Jadwal</button>
            </div>
        </div>
    @endforeach
@else
    <div style="text-align:center;padding:60px;">
        <p style="color:var(--gray-400);">Belum ada program. <a href="{{ route('admin.layanan.index') }}" style="color:var(--teal-600);">Buat program dulu</a></p>
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
