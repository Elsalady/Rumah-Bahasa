@extends('layouts.app')

@section('title', 'Layanan')
@section('meta_desc', 'Layanan dan program Rumah Bahasa Surabaya.')

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container">
        <div class="section-title">
            <h2>Program & Layanan</h2>
            <p>Berbagai program yang tersedia untuk masyarakat Surabaya</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:28px;">
            @forelse($layanan as $item)
                <div class="dashboard-card" style="padding:32px;">
                    @if($item->ikon)
                        <div style="font-size:32px;margin-bottom:12px;">{!! $item->ikon !!}</div>
                    @endif
                    <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">{{ $item->nama }}</h3>
                    <p style="color:var(--gray-500);line-height:1.7;">{{ $item->deskripsi }}</p>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-400);">
                    <p>Belum ada layanan yang tersedia.</p>
                </div>
            @endforelse
        </div>

        @auth
            @if(auth()->user()->role === 'member')
                <div style="text-align:center;margin-top:48px;">
                    <a href="{{ route('member.program') }}" class="btn-login" style="display:inline-flex;padding:14px 32px;font-size:15px;">
                        Daftar Program
                    </a>
                </div>
            @endif
        @endauth
    </div>
</section>
@endsection
