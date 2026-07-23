@extends('layouts.admin')

@section('title', 'Jadwal Kelas')
@section('content')
<div class="admin-grid-2" style="display:grid;grid-template-columns:1fr 2fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        @if(isset($editItem))
            <h3>Edit Jadwal Kelas</h3>
            <form action="{{ route('admin.jadwal-kelas.update', $editItem->id) }}" method="POST" class="dashboard-form">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" value="{{ $editItem->nama_kelas }}" required>
                </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select id="hari" name="hari" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                            <option value="{{ $h }}" {{ $editItem->hari === $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" value="{{ $editItem->jam_mulai }}" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" value="{{ $editItem->jam_selesai }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pengajar">Pengajar</label>
                    <input type="text" id="pengajar" name="pengajar" value="{{ $editItem->pengajar }}">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="form-group">
                        <label for="jenis">Jenis Kelas</label>
                        <select id="jenis" name="jenis" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                            <option value="tematik" {{ $editItem->jenis === 'tematik' ? 'selected' : '' }}>Tematik</option>
                            <option value="tentative" {{ $editItem->jenis === 'tentative' ? 'selected' : '' }}>Tentative</option>
                        </select>
                        <p style="font-size:12px;color:var(--gray-400);margin-top:6px;"><strong>Tematik:</strong> Kelas rutin dengan jadwal tetap. <strong>Tentative:</strong> Kelas bersifat sementara/kondisional.</p>
                    </div>
                    <div class="form-group">
                        <label for="mode">Mode</label>
                        <select id="mode" name="mode" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                            <option value="offline" {{ $editItem->mode === 'offline' ? 'selected' : '' }}>Offline</option>
                            <option value="online" {{ $editItem->mode === 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ruangan_link">Ruangan / Link Meeting</label>
                    <input type="text" id="ruangan_link" name="ruangan_link" value="{{ $editItem->ruangan_link }}" placeholder="Nama ruangan atau link meeting">
                </div>
                <div class="form-group">
                    <label for="kuota">Kuota</label>
                    <input type="number" id="kuota" name="kuota" value="{{ $editItem->kuota }}" min="0">
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="{{ route('admin.jadwal-kelas.index') }}" style="display:inline-flex;align-items:center;padding:12px 24px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">Batal</a>
                </div>
            </form>
        @else
            <h3>Tambah Jadwal Kelas</h3>
            <form action="{{ route('admin.jadwal-kelas.store') }}" method="POST" class="dashboard-form">
                @csrf
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" required>
                </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select id="hari" name="hari" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                        <option value="">— Pilih Hari —</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pengajar">Pengajar</label>
                    <input type="text" id="pengajar" name="pengajar">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="form-group">
                        <label for="jenis">Jenis Kelas</label>
                        <select id="jenis" name="jenis" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                            <option value="tematik">Tematik</option>
                            <option value="tentative">Tentative</option>
                        </select>
                        <p style="font-size:12px;color:var(--gray-400);margin-top:6px;"><strong>Tematik:</strong> Kelas rutin dengan jadwal tetap. <strong>Tentative:</strong> Kelas bersifat sementara/kondisional.</p>
                    </div>
                    <div class="form-group">
                        <label for="mode">Mode</label>
                        <select id="mode" name="mode" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ruangan_link">Ruangan / Link Meeting</label>
                    <input type="text" id="ruangan_link" name="ruangan_link" placeholder="Nama ruangan atau link meeting">
                </div>
                <div class="form-group">
                    <label for="kuota">Kuota</label>
                    <input type="number" id="kuota" name="kuota" value="0" min="0">
                </div>
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        @endif
    </div>
    <div class="dashboard-card">
        <h3>Semua Jadwal ({{ $jadwalKelas->count() }})</h3>
        @if($jadwalKelas->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>No</th><th>Nama Kelas</th><th>Hari</th><th>Jam</th><th>Pengajar</th><th>Jenis</th><th>Mode</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($jadwalKelas as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><div class="title-cell">{{ $item->nama_kelas }}</div></td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $item->pengajar ?: '-' }}</td>
                                <td><span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;{{ $item->jenis === 'tematik' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#fef3c7;color:#b45309;' }}">{{ ucfirst($item->jenis) }}</span></td>
                                <td><span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;{{ $item->mode === 'online' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#ecfdf5;color:#166534;' }}">{{ ucfirst($item->mode) }}</span></td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.jadwal-kelas.index', ['edit' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.jadwal-kelas.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada jadwal kelas.</p>
        @endif
    </div>
</div>
@endsection
