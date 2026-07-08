<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container">
                <h2>Edit Profil</h2>
                <div class="admin-header-right">
                    <span>{{ $user->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn-logout">Logout</button></form>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <div class="container" style="max-width:520px;margin:0 auto;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        <ul style="margin:0;padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="dashboard-card">
                    <h3>Update Data Diri</h3>
                    <form action="{{ route('member.update') }}" method="POST" class="dashboard-form">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $user->email }}" disabled style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-100);color:var(--gray-400);">
                            <p style="font-size:12px;color:var(--gray-400);margin-top:4px;">Email tidak dapat diubah.</p>
                        </div>
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                        </div>
                        <hr style="border:none;border-top:1px solid var(--gray-100);margin:20px 0;">
                        <div class="form-group">
                            <label for="password">Password Baru (kosongkan jika tidak ingin ganti)</label>
                            <input type="password" id="password" name="password" placeholder="Min. 6 karakter">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">
                        </div>
                        <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    </form>
                    <p style="text-align:center;margin-top:16px;">
                        <a href="{{ route('member.dashboard') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Dashboard</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
