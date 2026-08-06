@extends('layouts.admin')

@section('title', 'Konten Website')

@section('content')
<style>
    .konten-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 32px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .konten-grid { grid-template-columns: 1fr; gap: 20px; }
    }
</style>

<div class="dashboard-card" style="padding:32px;">
    <h3 style="margin-top:0;">Konten Profil Website</h3>
    <div class="konten-grid">
        {{-- Form --}}
        <div class="dashboard-card" style="padding:28px;">
            @if($editProfil)
                <h3 style="margin-top:0;">Edit Konten Profil</h3>
                <form action="{{ route('admin.profil.update', $editProfil->id) }}" method="POST" class="dashboard-form">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label for="judul_profil">Judul</label>
                        <input type="text" id="judul_profil" name="judul" value="{{ $editProfil->judul }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                            <option value="sejarah" {{ $editProfil->kategori == 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                            <option value="visi_misi" {{ $editProfil->kategori == 'visi_misi' ? 'selected' : '' }}>Visi & Misi</option>
                            <option value="tugas_fungsi" {{ $editProfil->kategori == 'tugas_fungsi' ? 'selected' : '' }}>Tugas & Fungsi</option>
                            <option value="struktur" {{ $editProfil->kategori == 'struktur' ? 'selected' : '' }}>Struktur</option>
                            <option value="volunteer" {{ $editProfil->kategori == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                            <option value="gambaran_umum" {{ $editProfil->kategori == 'gambaran_umum' ? 'selected' : '' }}>Gambaran Umum</option>
                            <option value="sasaran" {{ $editProfil->kategori == 'sasaran' ? 'selected' : '' }}>Sasaran Kegiatan Pembelajaran</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_profil">Deskripsi</label>
                        <textarea id="deskripsi_profil" name="deskripsi" rows="4" required>{{ $editProfil->deskripsi }}</textarea>
                    </div>
                    <div style="display:flex;gap:10px;">
                        <button type="submit" class="btn-submit" style="width:auto;padding:10px 20px;font-size:13px;">Update</button>
                        <a href="{{ route('admin.konten.index') }}" style="display:inline-flex;align-items:center;padding:10px 20px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:13px;">Batal</a>
                    </div>
                </form>
            @else
                <h3 style="margin-top:0;">Tambah Konten Profil</h3>
                <form action="{{ route('admin.profil.store') }}" method="POST" class="dashboard-form">
                    @csrf
                    <div class="form-group">
                        <label for="judul_profil">Judul</label>
                        <input type="text" id="judul_profil" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-50);">
                            <option value="sejarah">Sejarah</option>
                            <option value="visi_misi">Visi & Misi</option>
                            <option value="tugas_fungsi">Tugas & Fungsi</option>
                            <option value="struktur">Struktur</option>
                            <option value="volunteer">Volunteer</option>
                            <option value="gambaran_umum">Gambaran Umum</option>
                            <option value="sasaran">Sasaran Kegiatan Pembelajaran</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_profil">Deskripsi</label>
                        <textarea id="deskripsi_profil" name="deskripsi" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit" style="width:auto;padding:10px 20px;font-size:13px;">Simpan</button>
                </form>
            @endif
        </div>

        {{-- Daftar Profil --}}
        <div class="dashboard-card" style="padding:28px;">
            <h3 style="margin-top:0;">Semua Konten Profil ({{ $profil->count() }})</h3>
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
                                        <a href="{{ route('admin.konten.index', ['edit_profil' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
                                        <form action="{{ route('admin.profil.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus konten profil ini?')">
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
                <p class="text-muted" style="text-align:center;padding:24px;">Belum ada konten profil.</p>
            @endif
        </div>
    </div>
</div>
@endsection
