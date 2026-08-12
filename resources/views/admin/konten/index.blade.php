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

    /* ===== Tombol pilih menu (Profil / Berita) ===== */
    .konten-switch {
        display: flex;
        gap: 12px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .konten-switch a {
        flex: 1;
        min-width: 220px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border: 1px solid #30363d;
        background: #0d1117;
        color: #8b949e;
        transition: all 0.15s;
    }
    .konten-switch a svg { width: 20px; height: 20px; flex-shrink: 0; }
    .konten-switch a .switch-title { display: block; font-size: 14px; }
    .konten-switch a .switch-sub { display: block; font-size: 11px; font-weight: 400; color: #8b949e; margin-top: 2px; }
    .konten-switch a:hover {
        border-color: #3fb950;
        color: #e6edf3;
        background: #161b22;
    }
    .konten-switch a.active {
        background: #3fb950;
        border-color: #3fb950;
        color: #0d1117;
    }
    .konten-switch a.active .switch-sub { color: rgba(13, 17, 23, 0.7); }
    .konten-switch a.active svg { color: #0d1117; }
</style>

{{-- ===== PENGALIH MENU: PROFIL / BERITA (mencolok) ===== --}}
<div class="konten-switch">
    <a href="{{ route('admin.konten.index') }}" class="{{ !request()->has('tab') || request()->tab === 'profil' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        <span>
            <span class="switch-title">Edit Konten Profil</span>
        </span>
    </a>
    <a href="{{ route('admin.konten.index', ['tab' => 'berita']) }}" class="{{ request()->tab === 'berita' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        <span>
            <span class="switch-title">Edit Berita</span>
        </span>
    </a>
</div>

@if(!request()->has('tab') || request()->tab === 'profil')
{{-- ================= TAB PROFIL ================= --}}
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
@else
{{-- ================= TAB BERITA ================= --}}
<div class="dashboard-card" style="padding:32px;">
    <h3 style="margin-top:0;">Konten Berita</h3>
    <div class="konten-grid">
        {{-- Form --}}
        <div class="dashboard-card" style="padding:28px;">
            @if($editBerita)
                <h3 style="margin-top:0;">Edit Berita</h3>
                <form action="{{ route('admin.berita.update', $editBerita->id) }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label for="judul_berita">Judul Berita</label>
                        <input type="text" id="judul_berita" name="judul" value="{{ $editBerita->judul }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berita">Tanggal</label>
                        <input type="date" id="tanggal_berita" name="tanggal" value="{{ $editBerita->tanggal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis_berita">Penulis</label>
                        <input type="text" id="penulis_berita" name="penulis" value="{{ $editBerita->penulis }}">
                    </div>
                    <div class="form-group">
                        <label for="ringkasan_berita">Ringkasan</label>
                        <textarea id="ringkasan_berita" name="ringkasan" rows="2">{{ $editBerita->ringkasan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="isi_berita">Isi Berita</label>
                        <textarea id="isi_berita" name="isi" rows="6" required>{{ $editBerita->isi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="gambar_berita">Gambar (opsional)</label>
                        <input type="file" id="gambar_berita" name="gambar" accept="image/*">
                        @if($editBerita->gambar)
                            <div style="margin-top:8px;font-size:12px;color:#8b949e;">
                                Gambar saat ini: <a href="{{ asset('storage/' . $editBerita->gambar) }}" target="_blank" style="color:#58a6ff;">lihat</a>
                            </div>
                        @endif
                    </div>
                    <div style="display:flex;gap:10px;">
                        <button type="submit" class="btn-submit" style="width:auto;padding:10px 20px;font-size:13px;">Update</button>
                        <a href="{{ route('admin.konten.index', ['tab' => 'berita']) }}" style="display:inline-flex;align-items:center;padding:10px 20px;background:var(--gray-200);color:var(--gray-700);border-radius:10px;text-decoration:none;font-weight:600;font-size:13px;">Batal</a>
                    </div>
                </form>
            @else
                <h3 style="margin-top:0;">Tambah Berita</h3>
                <form action="{{ route('admin.berita.store') }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="judul_berita">Judul Berita</label>
                        <input type="text" id="judul_berita" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berita">Tanggal</label>
                        <input type="date" id="tanggal_berita" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis_berita">Penulis</label>
                        <input type="text" id="penulis_berita" name="penulis">
                    </div>
                    <div class="form-group">
                        <label for="ringkasan_berita">Ringkasan</label>
                        <textarea id="ringkasan_berita" name="ringkasan" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="isi_berita">Isi Berita</label>
                        <textarea id="isi_berita" name="isi" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="gambar_berita">Gambar (opsional)</label>
                        <input type="file" id="gambar_berita" name="gambar" accept="image/*">
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
                        <thead><tr><th>Judul</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @foreach($berita as $item)
                                <tr>
                                    <td><div class="title-cell">{{ $item->judul }}</div></td>
                                    <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($item->tanggal)->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</td>
                                    <td class="action-cell">
                                        <a href="{{ route('admin.konten.index', ['tab' => 'berita', 'edit_berita' => $item->id]) }}" class="btn-sm btn-edit">Edit</a>
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
@endif
@endsection
