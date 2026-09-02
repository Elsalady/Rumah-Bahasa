@extends('layouts.admin')

@section('title', 'Data Member')

@section('content')
<div class="dashboard-card">
    <div class="card-header-row" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <h3 style="margin:0;border:none;padding:0;">Data Pendaftar Member ({{ $members->count() }})</h3>
        <a href="{{ route('admin.member.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;flex-shrink:0;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </a>
    </div>
    @if($members->count())
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Member</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td><span style="font-family:monospace;font-size:12px;font-weight:600;color:var(--teal-700);">{{ $member->member_code ?: '-' }}</span></td>
                            <td><div class="title-cell">{{ $member->name }}</div></td>
                            <td style="font-size:13px;">{{ $member->email }}</td>
                            <td style="font-size:13px;">{{ $member->phone ?: '-' }}</td>
                            <td style="font-size:13px;">{{ $member->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                            <td>
                                <span style="display:inline-block;padding:6px 14px;border-radius:50px;font-size:12px;font-weight:700;color:#ffffff;
                                    {{ $member->status === 'approved' ? 'background:#1d4ed8;' : '' }}
                                    {{ $member->status === 'pending' ? 'background:#eab308;' : '' }}
                                    {{ $member->status === 'rejected' ? 'background:#dc2626;' : '' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td class="action-cell">
                                <a href="{{ route('admin.member.show', $member->id) }}" class="btn-sm btn-edit" style="text-decoration:none;display:inline-block;">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted" style="text-align:center;padding:40px;">Belum ada member terdaftar.</p>
    @endif
</div>
@endsection
