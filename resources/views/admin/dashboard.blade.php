<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-page">
        {{-- Admin Header --}}
        <header class="admin-header">
            <div class="container">
                <h2>Dashboard Admin</h2>
                <div class="admin-header-right">
                    <span>Selamat datang, Admin</span>
                    <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <div class="container">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <div class="dashboard-grid">
                    {{-- LEFT: Form Tambah Berita --}}
                    <div class="dashboard-card">
                        <h3>Tambah Berita Baru</h3>
                        <form action="{{ route('admin.berita.store') }}" method="POST" class="dashboard-form">
                            @csrf
                            <div class="form-group">
                                <label for="judul">Judul Berita</label>
                                <input type="text" id="judul" name="judul" placeholder="Masukkan judul berita" required>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Penulis</label>
                                <input type="text" id="penulis" name="penulis" placeholder="Nama penulis">
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ringkasan">Ringkasan</label>
                                <textarea id="ringkasan" name="ringkasan" rows="2" placeholder="Ringkasan singkat berita"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="isi">Isi Berita</label>
                                <textarea id="isi" name="isi" rows="5" placeholder="Tulis isi berita lengkap di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">Simpan Berita</button>
                        </form>
                    </div>

                    {{-- RIGHT: Daftar Berita --}}
                    <div class="dashboard-card">
                        <h3>Semua Berita ({{ $berita->count() }})</h3>

                        @if($berita->count())
                            <div class="table-wrap">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($berita as $item)
                                            <tr>
                                                <td>
                                                    <div class="title-cell">{{ $item->judul }}</div>
                                                    <div class="text-muted">{{ Str::limit($item->ringkasan ?: strip_tags($item->isi), 80) }}</div>
                                                </td>
                                                <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</td>
                                                <td class="action-cell">
                                                    {{-- Edit Form (inline) --}}
                                                    <button onclick="toggleEdit({{ $item->id }})" class="btn-sm btn-edit">Edit</button>

                                                    {{-- Hapus --}}
                                                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus berita ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm btn-delete">Hapus</button>
                                                    </form>

                                                    {{-- Inline Edit Form --}}
                                                    <div id="edit-form-{{ $item->id }}" style="display:none;margin-top:12px;padding-top:12px;border-top:1px solid var(--gray-100);">
                                                        <form action="{{ route('admin.berita.update', $item->id) }}" method="POST" class="dashboard-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <input type="text" name="judul" value="{{ $item->judul }}" required>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group" style="flex:1;">
                                                                    <input type="text" name="penulis" value="{{ $item->penulis }}" placeholder="Penulis">
                                                                </div>
                                                                <div class="form-group" style="flex:1;">
                                                                    <input type="date" name="tanggal" value="{{ $item->tanggal }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea name="ringkasan" rows="2" placeholder="Ringkasan">{{ $item->ringkasan }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea name="isi" rows="4" required>{{ $item->isi }}</textarea>
                                                            </div>
                                                            <div class="form-row">
                                                                <button type="submit" class="btn-submit" style="width:auto;padding:8px 20px;font-size:13px;">Simpan</button>
                                                                <button type="button" onclick="toggleEdit({{ $item->id }})" class="btn-cancel">Batal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted" style="text-align:center;padding:40px 0;">Belum ada berita. Silakan tambah berita baru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleEdit(id) {
            const form = document.getElementById('edit-form-' + id);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
