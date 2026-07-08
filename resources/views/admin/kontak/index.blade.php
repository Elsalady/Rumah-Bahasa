@extends('layouts.admin')

@section('content')
<div class="dashboard-card">
    <h3>Pesan Masuk ({{ $pesan->count() }})</h3>
    @if($pesan->count())
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Pesan</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($pesan as $item)
                        <tr style="{{ !$item->sudah_dibaca ? 'background:var(--teal-50);' : '' }}">
                            <td><div class="title-cell">{{ $item->nama }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $item->email }}</div></td>
                            <td><div style="font-size:13px;">{{ $item->subjek ?: '(tanpa subjek)' }}</div><div style="font-size:12px;color:var(--gray-400);">{{ Str::limit($item->pesan, 60) }}</div></td>
                            <td>@if($item->sudah_dibaca)<span style="color:var(--gray-400);font-size:12px;">Dibaca</span>@else<span style="color:var(--teal-700);font-weight:600;font-size:12px;">Baru</span>@endif</td>
                            <td style="white-space:nowrap;font-size:13px;">{{ $item->created_at->locale('id')->isoFormat('D MMM, HH:mm') }}</td>
                            <td class="action-cell">
                                <div style="display:flex;gap:4px;">
                                    @if(!$item->sudah_dibaca)
                                        <a href="{{ route('admin.kontak.markRead', $item->id) }}" class="btn-sm btn-edit">Tandai Dibaca</a>
                                    @endif
                                    <form action="{{ route('admin.kontak.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted" style="text-align:center;padding:40px;">Belum ada pesan masuk.</p>
    @endif
</div>
@endsection
