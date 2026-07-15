@extends('layouts.admin')

@section('content')
<div class="admin-grid-2" style="display:grid;grid-template-columns:1fr 2fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        @if(isset($editItem))
            <h3>Edit Galeri</h3>
            <form action="{{ route('admin.galeri.update', $editItem->id) }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ $editItem->judul }}" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                        <option value="foto" {{ $editItem->kategori == 'foto' ? 'selected' : '' }}>Foto</option>
                        <option value="video" {{ $editItem->kategori == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Upload Gambar (biarkan kosong jika tidak diganti)</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="2">{{ $editItem->deskripsi }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $editItem->tanggal ?: date('Y-m-d') }}">
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="{{ route('admin.galeri.index') }}" style="display:inline-flex;align-items:center;padding:12px 24px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">Batal</a>
                </div>
            </form>
        @else
            <h3>Tambah Galeri</h3>
            <form action="{{ route('admin.galeri.store') }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                        <option value="foto">Foto</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Upload Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">
                </div>
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        @endif
    </div>
    <div class="dashboard-card">
        <h3>Semua Galeri ({{ $galeri->count() }})</h3>
        @if($galeri->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($galeri as $item)
                            <tr>
                                <td>
                                    @if($item->gambar && $item->gambar !== 'placeholder')
                                        <img src="{{ asset('storage/'.$item->gambar) }}" style="width:60px;height:40px;object-fit:cover;border-radius:6px;">
                                    @else
                                        <div style="width:60px;height:40px;background:var(--teal-50);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:10px;color:var(--teal-300);">No img</div>
                                    @endif
                                </td>
                                <td><div class="title-cell">{{ $item->judul }}</div></td>
                                <td style="text-transform:capitalize;">{{ $item->kategori }}</td>
                                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.galeri.index', ['edit' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
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
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada galeri.</p>
        @endif
    </div>
</div>
@endsection
