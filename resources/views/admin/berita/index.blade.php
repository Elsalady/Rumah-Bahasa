@extends('layouts.admin')

@section('title', 'Berita')
@section('content')
<div class="admin-grid-2" style="display:grid;grid-template-columns:1fr 2fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        @if(isset($editItem))
            <h3>Edit Berita</h3>
            <form action="{{ route('admin.berita.update', $editItem->id) }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ $editItem->judul }}" required>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $editItem->tanggal ?: date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ $editItem->penulis ?: 'Admin' }}">
                </div>
                <div class="form-group">
                    <label for="ringkasan">Ringkasan</label>
                    <textarea id="ringkasan" name="ringkasan" rows="2">{{ $editItem->ringkasan }}</textarea>
                </div>
                <div class="form-group">
                    <label for="isi">Isi Berita</label>
                    <textarea id="isi" name="isi" rows="6" required>{{ $editItem->isi }}</textarea>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar (biarkan kosong jika tidak diganti)</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="{{ route('admin.berita.index') }}" style="display:inline-flex;align-items:center;padding:12px 24px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">Batal</a>
                </div>
            </form>
        @else
            <h3>Tambah Berita</h3>
            <form action="{{ route('admin.berita.store') }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="Admin">
                </div>
                <div class="form-group">
                    <label for="ringkasan">Ringkasan</label>
                    <textarea id="ringkasan" name="ringkasan" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="isi">Isi Berita</label>
                    <textarea id="isi" name="isi" rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar (opsional)</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                </div>
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        @endif
    </div>
    <div class="dashboard-card">
        <h3>Semua Berita ({{ $berita->count() }})</h3>
        @if($berita->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Judul</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($berita as $item)
                            <tr>
                                <td><div class="title-cell">{{ $item->judul }}</div></td>
                                <td>{{ $item->penulis }}</td>
                                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.berita.index', ['edit' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus berita ini?')">
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
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada berita.</p>
        @endif
    </div>
</div>
@endsection
