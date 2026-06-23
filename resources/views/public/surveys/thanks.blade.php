@extends('layouts.public')

@section('title', 'Terima Kasih - SIKAP ')

@section('public_content')
<div class="min-h-screen flex items-center justify-center py-16 px-4">
    <div class="max-w-md w-full text-center">

        <!-- Success Icon -->
        <div class="w-24 h-24 rounded-3xl bg-primary mx-auto flex items-center justify-center mb-8 shadow-xl shadow-primary/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-on-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-extrabold text-on-surface mb-4">Terima Kasih!</h1>
        <p class="text-on-surface-variant text-lg leading-relaxed mb-8">
            Jawaban Anda telah berhasil dikirim dan tercatat. Partisipasi Anda sangat berarti bagi peningkatan kualitas layanan publik Kota Batam.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="btn bg-primary hover:bg-primary/90 text-on-primary rounded-xl px-8 shadow-lg shadow-primary/30 border-none no-animation">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
