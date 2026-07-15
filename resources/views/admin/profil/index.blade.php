@extends('layouts.admin')

@section('content')
<div class="admin-grid-2" style="display:grid;grid-template-columns:1fr 2fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        @if(isset($editItem))
            <h3>Edit Konten Profil</h3>
            <form action="{{ route('admin.profil.update', $editItem->id) }}" method="POST" class="dashboard-form">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ $editItem->judul }}" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                        <option value="sejarah" {{ $editItem->kategori == 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                        <option value="visi_misi" {{ $editItem->kategori == 'visi_misi' ? 'selected' : '' }}>Visi & Misi</option>
                        <option value="tugas_fungsi" {{ $editItem->kategori == 'tugas_fungsi' ? 'selected' : '' }}>Tugas & Fungsi</option>
                        <option value="struktur" {{ $editItem->kategori == 'struktur' ? 'selected' : '' }}>Struktur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required>{{ $editItem->deskripsi }}</textarea>
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="{{ route('admin.profil.index') }}" style="display:inline-flex;align-items:center;padding:12px 24px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">Batal</a>
                </div>
            </form>
        @else
            <h3>Tambah Konten Profil</h3>
            <form action="{{ route('admin.profil.store') }}" method="POST" class="dashboard-form">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                        <option value="sejarah">Sejarah</option>
                        <option value="visi_misi">Visi & Misi</option>
                        <option value="tugas_fungsi">Tugas & Fungsi</option>
                        <option value="struktur">Struktur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        @endif
    </div>
    <div class="dashboard-card">
        <h3>Semua Konten ({{ $profil->count() }})</h3>
        @if($profil->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Judul</th><th>Kategori</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($profil as $item)
                            <tr>
                                <td><div class="title-cell">{{ $item->judul }}</div></td>
                                <td style="text-transform:capitalize;">{{ str_replace('_', ' ', $item->kategori) }}</td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.profil.index', ['edit' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('admin.profil.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
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
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada konten.</p>
        @endif
    </div>
</div>
@endsection
