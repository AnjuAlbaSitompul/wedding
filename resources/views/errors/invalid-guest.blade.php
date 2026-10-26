@extends('layouts.app')

@section('content')
    <main class="min-h-screen flex items-center justify-center px-4">
        <div class="wedding-card max-w-md text-center">
            <i class="fa-solid fa-heart-crack text-5xl text-wedding-blue mb-6"></i>
            <h1 class="font-heading text-2xl text-wedding-deep mb-3">Undangan Tidak Ditemukan</h1>
            <p class="font-body text-sm text-wedding-deep/70 mb-6">
                Tautan undangan tidak valid atau sudah kedaluwarsa. Silakan hubungi keluarga mempelai untuk mendapatkan tautan terbaru.
            </p>
            <a href="{{ route('invitation') }}"
               class="inline-flex items-center gap-2 rounded-full bg-wedding-deep px-6 py-3 font-heading text-sm text-white">
                <i class="fa-solid fa-home"></i> Buka Undangan
            </a>
        </div>
    </main>
@endsection
