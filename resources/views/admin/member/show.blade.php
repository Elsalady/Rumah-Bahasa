@extends('layouts.admin')

@section('title', 'Detail Member — ' . $member->name)

@section('content')
<style>
    /* Styling Header & Navigation */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .detail-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--gray-900);
    }
    .back-link {
        color: var(--gray-500);
        font-size: 13px;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: var(--teal-700);
    }

    /* Grid Layout Responsive */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        align-items: start;
    }

    /* Avatar & Profile Card Header */
    .profile-card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--gray-100);
    }
    .profile-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .profile-avatar-placeholder {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-title {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Key-Value Detail List */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .info-label {
        font-size: 12px;
        color: var(--gray-400);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .info-value {
        font-size: 14px;
        color: var(--gray-800);
        font-weight: 500;
        word-break: break-word;
    }

    /* Document Row List */
    .doc-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--gray-100);
        gap: 12px;
    }
    .doc-item:last-child {
        border-bottom: none;
    }
    .doc-label {
        font-size: 13px;
        color: var(--gray-700);
        font-weight: 500;
        line-height: 1.4;
    }

    /* Form Section */
    .form-card {
        margin-top: 24px;
        padding: 28px;
    }
    .form-group-custom {
        margin-bottom: 16px;
    }
    .form-group-custom label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 6px;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--gray-200);
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        background: #ffffff;
        color: var(--gray-900);
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .form-control-custom:focus {
        border-color: var(--teal-600);
    }

    /* Mobile Breakpoint Optimization */
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr; /* Tumpuk 1 kolom di HP */
            gap: 16px;
        }
        .dashboard-card {
            padding: 20px !important;
        }
        .form-card {
            padding: 20px !important;
            margin-top: 16px;
        }
    }
</style>

<div class="detail-header">
    <h3>Detail Member</h3>
    <a href="{{ route('admin.member.kelola') }}" class="back-link" style="display:inline-flex;align-items:center;gap:6px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali ke Data Member</a>
</div>

<div class="detail-grid">
    {{-- Data Diri Card --}}
    <div class="dashboard-card" style="padding:28px;">
        <div class="profile-card-header">
            @if($member->foto_profile)
                <img src="{{ asset('storage/' . $member->foto_profile) }}" alt="Foto Profil" class="profile-avatar">
            @else
                <div class="profile-avatar-placeholder">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            @endif
            <div>
                <h4 class="card-title">Data Diri</h4>
                <div style="font-size:13px;color:var(--gray-500);margin-top:2px;">
                    <span style="font-family:monospace;font-weight:700;color:var(--teal-700);letter-spacing:0.5px;">{{ $member->member_code ?: 'ID Member #' . $member->id }}</span>
                </div>
            </div>
        </div>

        <div class="info-list">
            <div class="info-item">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value" style="font-size:15px;font-weight:700;color:var(--gray-900);">{{ $member->name }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $member->email }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Telepon</span>
                <span class="info-value">{{ $member->phone ?: '-' }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Alamat</span>
                <span class="info-value">{{ $member->address ?: '-' }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Status</span>
                <div>
                    <span style="display:inline-block;padding:6px 14px;border-radius:50px;font-size:12px;font-weight:700;color:#ffffff;
                        {{ $member->status === 'approved' ? 'background:#1d4ed8;' : '' }}
                        {{ $member->status === 'pending' ? 'background:#eab308;' : '' }}
                        {{ $member->status === 'rejected' ? 'background:#dc2626;' : '' }}">
                        {{ ucfirst($member->status) }}
                    </span>
                </div>
            </div>

            <div class="info-item">
                <span class="info-label">Bergabung Pada</span>
                <span class="info-value">{{ $member->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</span>
            </div>

            @if($member->catatan_member)
            <div class="info-item">
                <span class="info-label">Catatan Admin</span>
                <span class="info-value" style="font-style:italic;color:var(--gray-600);">"{{ $member->catatan_member }}"</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Dokumen Card --}}
    <div class="dashboard-card" style="padding:28px;">
        <h4 class="card-title" style="margin-bottom:20px;">Dokumen Pendukung</h4>
        @php
            $dokList = [
                'foto_profile' => 'Foto Profil',
                'ktp' => 'KTP',
                'surat_domisili' => 'Surat Domisili / Bekerja',
                'ktm' => 'KTM / Kartu Pelajar / Identitas',
                'kk' => 'Kartu Keluarga (KK)',
            ];
        @endphp

        <div>
            @foreach($dokList as $field => $label)
                <div class="doc-item">
                    <span class="doc-label">{{ $label }}</span>
                    @if($member->$field)
                        <a href="{{ asset('storage/' . $member->$field) }}" target="_blank" class="btn-sm btn-edit" style="text-decoration:none;font-size:12px;white-space:nowrap;">Lihat</a>
                    @else
                        <span style="font-size:12px;color:var(--gray-400);white-space:nowrap;">Belum ada</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Form Approval Card --}}
<div class="dashboard-card form-card">
    <h4 class="card-title" style="margin-bottom:20px;">Update Status Member</h4>
    <form action="{{ route('admin.member.update', $member->id) }}" method="POST" style="max-width:500px;">
        @csrf @method('PUT')
        
        <div class="form-group-custom">
            <label for="status">Status Keanggotaan</label>
            <select id="status" name="status" class="form-control-custom" required>
                <option value="pending" {{ $member->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $member->status === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $member->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <div class="form-group-custom">
            <label for="catatan_member">
                Catatan <span id="catatan-label-wajib" style="color:#dc2626;display:none;">(wajib jika ditolak)</span><span id="catatan-label-opsional">(opsional)</span>
            </label>
            <textarea id="catatan_member" name="catatan_member" rows="3" class="form-control-custom" placeholder="Alasan penolakan atau catatan lainnya..." style="resize:vertical;">{{ $member->catatan_member }}</textarea>
            @error('catatan_member')
                <p style="color:#dc2626;font-size:12px;margin-top:6px;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-submit" style="width:100%;max-width:200px;margin-top:8px;">Simpan Perubahan</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const status = document.getElementById('status');
    const wajib = document.getElementById('catatan-label-wajib');
    const opsional = document.getElementById('catatan-label-opsional');
    const catatan = document.getElementById('catatan_member');

    function updateLabel() {
        const isRejected = status.value === 'rejected';
        wajib.style.display = isRejected ? 'inline' : 'none';
        opsional.style.display = isRejected ? 'none' : 'inline';
        catatan.required = isRejected;
    }

    status.addEventListener('change', updateLabel);
    updateLabel();
});
</script>
@endsection