@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
<section class="py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('berita') }}" class="text-blue-600 hover:text-blue-700 inline-flex items-center mb-8">
            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Berita
        </a>
        <p class="text-gray-400 text-center py-12">Halaman detail berita.</p>
    </div>
</section>
@endsection
