@extends('layouts.app')

@section('title', $item->judul)
@section('meta_desc', Str::limit(strip_tags($item->deskripsi), 160))

@section('content')
<section style="padding:120px 0 80px;">
    <div class="container" style="max-width:800px;">
        <a href="{{ route('profil') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--teal-700);text-decoration:none;font-weight:500;font-size:14px;margin-bottom:24px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Profil
        </a>

        <div class="dashboard-card" style="padding:40px;">
            <h2 style="font-size:24px;font-weight:700;color:var(--gray-900);margin-bottom:20px;">{{ $item->judul }}</h2>
            @if($item->kategori === 'visi_misi')
                @php $paragraf = explode("\n\n", $item->deskripsi); @endphp
                @foreach($paragraf as $p)
                    @php $parts = explode("\n", trim($p), 2); @endphp
                    @if(!$loop->first)
                        <div style="margin-top:24px;"></div>
                    @endif
                    <div style="font-weight:700;font-size:16px;color:var(--gray-900);margin-bottom:6px;">{{ $parts[0] ?? '' }}</div>
                    <p style="color:var(--gray-500);line-height:1.9;font-size:15px;margin:0;">{{ $parts[1] ?? $parts[0] ?? '' }}</p>
                @endforeach
            @else
                <div style="color:var(--gray-500);line-height:1.9;font-size:15px;">
                    {!! nl2br(e($item->deskripsi)) !!}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
