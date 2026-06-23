@extends('layouts.public')

@section('title', 'Daftar Survei - SIKAP')

@section('public_content')
<div class="bg-surface py-12 lg:py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-12">
            <div class="inline-block px-3 py-1 bg-primary/10 text-primary font-semibold text-sm rounded-lg mb-4 border border-primary/20">Survei Publik</div>
            <h1 class="text-3xl sm:text-4xl font-bold text-on-surface tracking-tight mb-3">Daftar Survei Aktif</h1>
            <p class="text-on-surface-variant text-lg max-w-2xl">Pilih survei di bawah ini dan bagikan pendapat Anda untuk pelayanan publik Kota Batam yang lebih baik.</p>
        </div>

        <!-- Survey Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($surveys as $survey)
            <div class="flex flex-col bg-surface-container-high rounded-3xl border border-outline-variant shadow-sm hover:shadow-xl hover:shadow-primary/5 hover:-translate-y-2 transition-all duration-300 overflow-hidden group">

                <!-- Card Header (Decorative) -->
                <div class="h-24 bg-gradient-to-br from-primary/20 to-secondary/10 relative p-6">
                    <div class="absolute top-4 right-4 badge bg-surface text-success font-semibold border-success/20 shadow-sm gap-1.5 py-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Aktif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-xl font-bold text-on-surface mb-3 group-hover:text-primary transition-colors line-clamp-2">
                        {{ $survey->judul }}
                    </h3>
                    <p class="text-on-surface-variant text-sm mb-6 line-clamp-3 flex-grow leading-relaxed">
                        {{ $survey->deskripsi }}
                    </p>

                    <!-- Meta Info -->
                    <div class="flex items-center gap-4 text-xs font-semibold text-on-surface-variant mb-6 bg-surface p-3 rounded-xl border border-outline-variant">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            {{ $survey->questions_count }} Pertanyaan
                        </div>
                        @if($survey->tanggal_selesai)
                        <div class="w-px h-4 bg-outline-variant"></div>
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Sampai {{ $survey->tanggal_selesai->format('d M Y') }}
                        </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-primary w-full text-on-primary rounded-xl shadow-none hover:shadow-md transition-all no-animation">
                        Mulai Isi Survei
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-24 text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2">Belum Ada Survei Aktif</h3>
                <p class="text-on-surface-variant max-w-sm">Saat ini tidak ada survei yang sedang berjalan. Silakan periksa kembali nanti.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
