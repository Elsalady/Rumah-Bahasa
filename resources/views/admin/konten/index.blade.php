@extends('layouts.admin')

@section('title', 'Konten Website')

@section('content')
<style>
    .tab-nav {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 24px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .tab-nav::-webkit-scrollbar { display: none; }
    .tab-btn {
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        color: #6b7280;
        cursor: pointer;
        margin-bottom: -2px;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .tab-btn.active {
        border-bottom-color: #0167a2;
        color: #0167a2;
    }
    .tab-btn:hover { color: #0167a2; }

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

<div class="dashboard-card" style="padding:0 32px 32px;">
    <div class="tab-nav">
        <button type="button" class="tab-btn active" data-tab="tab-profil">Profil Website</button>
        <button type="button" class="tab-btn" data-tab="tab-berita">Berita</button>
    </div>

    {{-- ===================== TAB PROFIL ===================== --}}
    <div id="tab-profil" class="tab-content">
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

    {{-- ===================== TAB BERITA ===================== --}}
    <div id="tab-berita" class="tab-content" style="display:none;">
        <div class="konten-grid">
            {{-- Form --}}
            <div class="dashboard-card" style="padding:28px;">
                @if($editBerita)
                    <h3 style="margin-top:0;">Edit Berita</h3>
                    <form action="{{ route('admin.berita.update', $editBerita->id) }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="judul_berita">Judul</label>
                            <input type="text" id="judul_berita" name="judul" value="{{ $editBerita->judul }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ $editBerita->tanggal ?: date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" id="penulis" name="penulis" value="{{ $editBerita->penulis ?: 'Admin' }}">
                        </div>
                        <div class="form-group">
                            <label for="ringkasan">Ringkasan</label>
                            <textarea id="ringkasan" name="ringkasan" rows="2">{{ $editBerita->ringkasan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="isi">Isi Berita</label>
                            <textarea id="isi" name="isi" rows="5" required>{{ $editBerita->isi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar (biarkan kosong jika tidak diganti)</label>
                            <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                        </div>
                        <div style="display:flex;gap:10px;">
                            <button type="submit" class="btn-submit" style="width:auto;padding:10px 20px;font-size:13px;">Update</button>
                            <a href="{{ route('admin.konten.index') }}" style="display:inline-flex;align-items:center;padding:10px 20px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:13px;">Batal</a>
                        </div>
                    </form>
                @else
                    <h3 style="margin-top:0;">Tambah Berita</h3>
                    <form action="{{ route('admin.berita.store') }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="judul_berita">Judul</label>
                            <input type="text" id="judul_berita" name="judul" required>
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
                            <textarea id="isi" name="isi" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar (opsional)</label>
                            <input type="file" id="gambar" name="gambar" accept="image/*" style="width:100%;padding:10px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;background:var(--gray-50);">
                        </div>
                        <button type="submit" class="btn-submit" style="width:auto;padding:10px 20px;font-size:13px;">Simpan</button>
                    </form>
                @endif
            </div>

            {{-- Daftar Berita --}}
            <div class="dashboard-card" style="padding:28px;">
                <h3 style="margin-top:0;">Semua Berita ({{ $berita->count() }})</h3>
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
                                            <a href="{{ route('admin.konten.index', ['edit_berita' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
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
                    <p class="text-muted" style="text-align:center;padding:24px;">Belum ada berita.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            contents.forEach(c => c.style.display = 'none');
            const target = document.getElementById(this.dataset.tab);
            if (target) target.style.display = '';
        });
    });

    // Auto-switch to berita tab if editing a berita
    @if(request()->has('edit_berita'))
        document.querySelector('.tab-btn[data-tab="tab-berita"]').click();
    @endif
});
</script>
@endsection
