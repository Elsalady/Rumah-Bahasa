@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
<div class="admin-grid-2" style="display:grid;grid-template-columns:1fr 2fr;gap:32px;align-items:start;">
    {{-- Form --}}
    <div class="dashboard-card">
        @if(isset($editItem))
            <h3>Edit Foto Galeri</h3>
            <form action="{{ route('admin.galeri.update', $editItem->id) }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ $editItem->judul }}" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi <span style="font-weight:400;color:var(--gray-400);">(opsional)</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="2">{{ $editItem->deskripsi }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $editItem->tanggal ?: now()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                        <option value="foto" {{ $editItem->kategori === 'foto' ? 'selected' : '' }}>Foto</option>
                        <option value="video" {{ $editItem->kategori === 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Ganti Gambar (biarkan kosong jika tidak diganti)</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                </div>
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="{{ route('admin.galeri.index') }}" style="display:inline-flex;align-items:center;padding:12px 24px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">Batal</a>
                </div>
            </form>
        @else
            <h3>Tambah Foto Galeri</h3>
            <form action="{{ route('admin.galeri.store') }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi <span style="font-weight:400;color:var(--gray-400);">(opsional)</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ now()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                        <option value="foto">Foto</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" required style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                </div>
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        @endif
    </div>

    {{-- Daftar --}}
    <div class="dashboard-card">
        <h3>Semua Galeri ({{ $galeri->count() }})</h3>
        @if($galeri->count())
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:14px; margin-top:16px;">
                @foreach($galeri as $item)
                    <div style="border:1px solid var(--gray-100); border-radius:12px; overflow:hidden; background:#fff;">
                        <div style="aspect-ratio:4/3; background:var(--gray-50); overflow:hidden;">
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" loading="lazy" style="width:100%; height:100%; object-fit:cover; display:block;">
                        </div>
                        <div style="padding:10px 12px;">
                            <div style="font-size:13px; font-weight:600; color:var(--gray-900); margin-bottom:4px; line-height:1.4;">{{ $item->judul }}</div>
                            <div style="font-size:11px; color:var(--gray-400); margin-bottom:8px;">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') : '-' }}
                            </div>
                            <div style="display:flex; gap:6px;">
                                <a href="{{ route('admin.galeri.index', ['edit' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada foto galeri.</p>
        @endif
    </div>
</div>
@endsection
