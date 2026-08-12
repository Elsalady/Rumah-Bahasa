@extends('layouts.admin')

@section('title', 'Kelola Member')

@section('content')
<div class="dashboard-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h3 style="margin:0;border:none;padding:0;">Kelola Member</h3>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.member.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Member CSV
            </a>
            <a href="{{ route('admin.pendaftaran.export') }}" class="btn-login" style="padding:8px 16px;font-size:12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Pendaftar CSV
            </a>
        </div>
    </div>

    <!-- Tab Navigation (mencolok: tombol solid + ikon) -->
    <div class="member-tabs" style="display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap;">
        <button type="button" class="member-tab active" data-tab="tab-member" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;font-size:13px;font-weight:600;border-radius:10px;cursor:pointer;border:1px solid #30363d;font-family:inherit;transition:all 0.15s;background:#3fb950;color:#0d1117;border-color:#3fb950;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Pendaftar Member ({{ $members->count() }})
        </button>
        <button type="button" class="member-tab" data-tab="tab-pendaftar" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;font-size:13px;font-weight:600;border-radius:10px;cursor:pointer;border:1px solid #30363d;font-family:inherit;transition:all 0.15s;background:#21262d;color:#c9d1d9;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            Pendaftar Program ({{ $daftar->count() }})
        </button>
    </div>

    <!-- Tab: Data Member -->
    <div id="tab-member" class="tab-content">
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
                                <td style="font-size:13px;">{{ $member->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                <td>
                                    <span style="display:inline-block;padding:2px 10px;border-radius:50px;font-size:12px;font-weight:600;background:#21262d;color:#c9d1d9;border:1px solid #30363d;">
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

    <!-- Tab: Pendaftar Program -->
    <div id="tab-pendaftar" class="tab-content" style="display:none;">
        @if($daftar->count())
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>No</th><th>Nama</th><th>Program</th><th>Status</th><th>Tanggal Daftar</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($daftar as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><div class="title-cell">{{ $item->user->name }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $item->user->email }}</div></td>
                                <td>{{ $item->program }}</td>
                                <td>
                                    <span style="display:inline-block;padding:2px 10px;border-radius:50px;font-size:12px;font-weight:600;background:#21262d;color:#c9d1d9;border:1px solid #30363d;">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td style="font-size:13px;">{{ $item->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                <td class="action-cell">
                                    <form action="{{ route('admin.pendaftaran.update', $item->id) }}" method="POST" style="display:flex;gap:4px;flex-wrap:wrap;">
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
</div>

<style>
    @media (max-width: 480px) {
        .card-header-row { flex-direction: column; align-items: flex-start !important; gap: 8px !important; }
        .member-tabs { overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: none; flex-wrap: nowrap; }
        .member-tabs::-webkit-scrollbar { display: none; }
        .member-tab { font-size: 12px !important; padding: 10px 16px !important; }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.member-tab');
    const contents = {
        'tab-member': document.getElementById('tab-member'),
        'tab-pendaftar': document.getElementById('tab-pendaftar'),
    };

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Deactivate all tabs (gaya tombol tidak aktif)
            tabs.forEach(t => {
                t.style.background = '#21262d';
                t.style.color = '#c9d1d9';
                t.style.borderColor = '#30363d';
                t.style.fontWeight = '600';
            });
            // Hide all contents
            Object.values(contents).forEach(c => { if (c) c.style.display = 'none'; });

            // Activate clicked tab (hijau solid)
            this.style.background = '#3fb950';
            this.style.color = '#0d1117';
            this.style.borderColor = '#3fb950';

            const target = contents[this.dataset.tab];
            if (target) target.style.display = '';
        });
    });
});
</script>
@endsection