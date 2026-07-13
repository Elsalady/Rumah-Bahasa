@extends('layouts.admin')

@section('content')
<div class="admin-grid-2" style="display:grid;grid-template-columns:1fr 2fr;gap:32px;align-items:start;">
    <div class="dashboard-card">
        <h3>Tambah Layanan</h3>
        <form action="{{ route('admin.layanan.store') }}" method="POST" class="dashboard-form">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Layanan</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="urutan">Urutan</label>
                <input type="number" id="urutan" name="urutan" value="0" min="0">
            </div>
            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>
    <div class="dashboard-card">
        <h3>Semua Layanan ({{ $layanan->count() }})</h3>
        @if($layanan->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Nama</th><th>Urutan</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($layanan as $item)
                            <tr>
                                <td><div class="title-cell">{{ $item->nama }}</div></td>
                                <td>{{ $item->urutan }}</td>
                                <td class="action-cell">
                                    <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus?')">
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
            <p class="text-muted" style="text-align:center;padding:40px;">Belum ada layanan.</p>
        @endif
    </div>
</div>
@endsection
