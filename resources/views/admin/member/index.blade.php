@extends('layouts.admin')

@section('title', 'Data Member')

@section('content')
<div class="dashboard-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h3 style="margin:0;border:none;padding:0;">Data Member ({{ $members->count() }})</h3>
        <a href="{{ route('admin.member.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </a>
    </div>
    @if($members->count())
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $i => $member)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><div class="title-cell">{{ $member->name }}</div></td>
                            <td style="font-size:13px;">{{ $member->email }}</td>
                            <td style="font-size:13px;">{{ $member->phone ?: '-' }}</td>
                            <td style="font-size:13px;">{{ $member->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                            <td>
                                <span style="display:inline-block;padding:2px 10px;border-radius:50px;font-size:12px;font-weight:600;
                                    {{ $member->status === 'approved' ? 'background:#ecfdf5;color:#166534;' : '' }}
                                    {{ $member->status === 'rejected' ? 'background:#fef2f2;color:#dc2626;' : '' }}
                                    {{ $member->status === 'pending' ? 'background:#fffbeb;color:#b45309;' : '' }}">
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
