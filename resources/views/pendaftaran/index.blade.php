@extends('layouts.app')

@section('title', 'Pendaftaran')
@section('meta_desc', 'Daftar program Rumah Belajar Surabaya.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container" style="max-width:640px;">
        <div class="section-title">
            <h2>Pendaftaran Program</h2>
            <p>Daftar program yang kamu minati</p>
        </div>

        @if(session('success'))
            <div class="alert-success" style="margin-bottom:28px;">{{ session('success') }}</div>
        @endif

        @auth
            <div class="dashboard-card">
                <h3 style="margin-bottom:20px;">Pilih Program</h3>
                <form action="{{ route('pendaftaran.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="program">Program</label>
                        <select id="program" name="program" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);">
                            <option value="">— Pilih Program —</option>
                            @foreach($programs as $p)
                                <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p style="color:var(--gray-400);font-size:13px;margin-bottom:20px;">
                        Kamu terdaftar sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                    </p>
                    <button type="submit" class="btn-submit">Kirim Pendaftaran</button>
                </form>
            </div>
        @else
            <div class="dashboard-card" style="text-align:center;padding:60px 40px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gray-300)" stroke-width="1.5" style="margin:0 auto 16px;display:block;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <p style="color:var(--gray-500);margin-bottom:16px;">Silakan login atau daftar terlebih dahulu untuk mendaftar program.</p>
                <div style="display:flex;gap:12px;justify-content:center;">
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-login" style="background:var(--teal-500);">Daftar</a>
                </div>
            </div>
        @endauth
    </div>
</section>
@endsection
