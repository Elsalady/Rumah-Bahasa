@extends('layouts.admin')

@section('title', 'Detail Member — ' . $member->name)

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h3 style="margin:0;font-size:20px;">Detail Member</h3>
    <a href="{{ route('admin.member.index') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Data Member</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">
    {{-- Data Diri --}}
    <div class="dashboard-card" style="padding:28px;">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
            @if($member->foto_profile)
                <img src="{{ asset('storage/' . $member->foto_profile) }}" alt="Foto Profil" style="width:64px;height:64px;border-radius:50%;object-fit:cover;flex-shrink:0;">
            @else
                <div style="width:64px;height:64px;border-radius:50%;background:var(--gray-100);display:flex;align-items:center;justify-content:center;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--gray-400)" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            @endif
            <div>
                <h4 style="margin:0;font-size:15px;color:var(--gray-700);text-transform:uppercase;letter-spacing:0.3px;">Data Diri</h4>
            </div>
        </div>
        <table style="width:100%;font-size:14px;">
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);width:110px;">Nama</td>
                <td style="padding:8px 0;font-weight:600;color:var(--gray-900);">: {{ $member->name }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);">Email</td>
                <td style="padding:8px 0;color:var(--gray-700);">: {{ $member->email }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);">Telepon</td>
                <td style="padding:8px 0;color:var(--gray-700);">: {{ $member->phone ?: '-' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);vertical-align:top;">Alamat</td>
                <td style="padding:8px 0;color:var(--gray-700);">: {{ $member->address ?: '-' }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);">Status</td>
                <td style="padding:8px 0;">
                    <span style="display:inline-block;padding:2px 10px;border-radius:50px;font-size:12px;font-weight:600;
                        {{ $member->status === 'approved' ? 'background:#ecfdf5;color:#166534;' : '' }}
                        {{ $member->status === 'rejected' ? 'background:#fef2f2;color:#dc2626;' : '' }}
                        {{ $member->status === 'pending' ? 'background:#fffbeb;color:#b45309;' : '' }}">
                        : {{ ucfirst($member->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);">Bergabung</td>
                <td style="padding:8px 0;color:var(--gray-700);">: {{ $member->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
            </tr>
            @if($member->catatan_member)
            <tr>
                <td style="padding:8px 0;color:var(--gray-400);vertical-align:top;">Catatan</td>
                <td style="padding:8px 0;color:var(--gray-700);font-style:italic;">: {{ $member->catatan_member }}</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- Dokumen --}}
    <div class="dashboard-card" style="padding:28px;">
        <h4 style="margin:0 0 16px;font-size:15px;color:var(--gray-700);text-transform:uppercase;letter-spacing:0.3px;">Dokumen</h4>
        @php
            $dokList = [
                'foto_profile' => 'Foto Profil',
                'ktp' => 'KTP',
                'surat_domisili' => 'Surat Domisili / Bekerja',
                'ktm' => 'KTM / Kartu Pelajar / Identitas Lembaga Pendidikan',
                'kk' => 'Kartu Keluarga (KK)',
            ];
        @endphp
        @foreach($dokList as $field => $label)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--gray-50);">
                <span style="font-size:13px;color:var(--gray-700);">{{ $label }}</span>
                @if($member->$field)
                    <a href="{{ asset('storage/' . $member->$field) }}" target="_blank" class="btn-sm btn-edit" style="text-decoration:none;font-size:12px;">Lihat</a>
                @else
                    <span style="font-size:11px;color:var(--gray-400);">Belum diupload</span>
                @endif
            </div>
        @endforeach
    </div>
</div>

{{-- Form Approval --}}
<div class="dashboard-card" style="padding:28px;margin-top:24px;">
    <h4 style="margin:0 0 16px;font-size:15px;color:var(--gray-700);text-transform:uppercase;letter-spacing:0.3px;">Update Status Member</h4>
    <form action="{{ route('admin.member.update', $member->id) }}" method="POST" style="max-width:500px;">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);" required>
                <option value="pending" {{ $member->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $member->status === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $member->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="form-group">
            <label for="catatan_member">Catatan (opsional)</label>
            <textarea id="catatan_member" name="catatan_member" rows="3" placeholder="Alasan penolakan atau catatan lainnya..." style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);resize:vertical;">{{ $member->catatan_member }}</textarea>
        </div>
        <button type="submit" class="btn-submit" style="max-width:200px;">Simpan</button>
    </form>
</div>
@endsection
