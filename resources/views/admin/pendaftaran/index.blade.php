@extends('layouts.admin')

@section('content')
<div class="dashboard-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h3 style="margin:0;border:none;padding:0;">Data Pendaftar ({{ $daftar->count() }})</h3>
        <a href="{{ route('admin.pendaftaran.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </a>
    </div>
    @if($daftar->count())
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Program</th><th>Status</th><th>Tanggal Daftar</th><th>Aksi</th></tr></thead>
                <tbody>
                    @foreach($daftar as $item)
                        <tr>
                            <td><div class="title-cell">{{ $item->user->name }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $item->user->email }}</div></td>
                            <td>{{ $item->program }}</td>
                            <td>
                                <span style="display:inline-block;padding:2px 10px;border-radius:50px;font-size:12px;font-weight:600;
                                    {{ $item->status === 'confirmed' ? 'background:#ecfdf5;color:#166534;' : '' }}
                                    {{ $item->status === 'rejected' ? 'background:#fef2f2;color:#dc2626;' : '' }}
                                    {{ $item->status === 'pending' ? 'background:#fffbeb;color:#b45309;' : '' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td style="font-size:13px;">{{ $item->created_at->locale('id')->isoFormat('D MMM YYYY') }}</td>
                            <td class="action-cell">
                                <form action="{{ route('admin.pendaftaran.update', $item->id) }}" method="POST" style="display:flex;gap:4px;">
                                    @csrf @method('PUT')
                                    <select name="status" style="padding:4px 8px;border:1px solid var(--gray-200);border-radius:6px;font-size:12px;background:var(--gray-50);">
                                        <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $item->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="rejected" {{ $item->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn-sm btn-edit">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted" style="text-align:center;padding:40px;">Belum ada pendaftar.</p>
    @endif
</div>
@endsection
