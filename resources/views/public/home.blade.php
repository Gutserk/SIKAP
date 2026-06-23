@extends('layouts.public')

@section('title', 'Beranda - SIKAP')

@section('public_content')

<!-- 1. HERO SECTION -->
<div class="bg-surface relative overflow-hidden pt-16 pb-24 sm:pt-24 sm:pb-32 border-b border-outline-variant/30">
    <!-- Background Decoration -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-primary/5 rounded-full blur-3xl mix-blend-multiply pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-secondary/5 rounded-full blur-3xl mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
        <!-- Text Content -->
        <div class="flex-1 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary font-medium text-xs sm:text-sm mb-6 border border-primary/20 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                Portal Resmi Diskominfo Kota Batam
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-on-surface tracking-tight mb-6 leading-[1.1]">
                Bangun Kota Batam dengan <span class="text-primary relative inline-block">
                    Suara Anda
                    <svg class="absolute w-full h-3 -bottom-2 left-0 text-secondary opacity-70" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
                </span>
            </h1>
            
            <p class="text-lg text-on-surface-variant mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                Sistem Informasi Kepuasan dan Evaluasi Layanan Aplikasi (SIKAP) mempermudah Anda memberikan penilaian, saran, dan masukan demi terwujudnya layanan publik yang prima, cerdas, dan transparan.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                <a href="{{ route('surveys.index') }}" class="btn btn-primary btn-lg rounded-2xl text-on-primary shadow-lg shadow-primary/25 hover:shadow-primary/40 hover:-translate-y-1 transition-all duration-300 px-8 w-full sm:w-auto">
                    Mulai Isi Survei
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
                <a href="#cara-kerja" class="btn bg-surface-container hover:bg-surface-container-high border border-outline-variant text-on-surface shadow-sm btn-lg rounded-2xl px-8 w-full sm:w-auto flex items-center gap-2 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-on-surface-variant" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Cara Kerja
                </a>
            </div>
        </div>

        <!-- Hero Graphic (Replaces 3D Illustration) -->
        <div class="flex-1 w-full max-w-lg lg:max-w-none relative mt-10 lg:mt-0">
            <!-- Modern Glassmorphism Graphic Representation -->
            <div class="relative w-full aspect-square md:aspect-[4/3] rounded-[2rem] bg-gradient-to-br from-primary/10 via-surface to-secondary/10 border border-outline-variant shadow-xl overflow-hidden flex items-center justify-center p-8 group">
                <!-- Decorative Blobs inside -->
                <div class="absolute top-10 right-10 w-32 h-32 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/30 transition-colors duration-700"></div>
                <div class="absolute bottom-10 left-10 w-40 h-40 bg-secondary/20 rounded-full blur-2xl group-hover:bg-secondary/30 transition-colors duration-700"></div>
                
                <!-- Center Floating UI Mockup -->
                <div class="relative z-10 w-full max-w-sm bg-surface/80 backdrop-blur-md rounded-2xl border border-white/50 shadow-2xl p-6 transform rotate-2 group-hover:rotate-0 group-hover:scale-105 transition-all duration-500">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                        </div>
                        <div>
                            <div class="h-4 w-32 bg-surface-container-high rounded mb-2"></div>
                            <div class="h-3 w-20 bg-surface-container rounded"></div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="h-3 w-full bg-surface-container rounded"></div>
                        <div class="h-3 w-5/6 bg-surface-container rounded"></div>
                        <div class="h-3 w-4/6 bg-surface-container rounded"></div>
                    </div>
                    <div class="mt-6 flex gap-2">
                        <div class="h-8 w-24 bg-primary/20 rounded-lg"></div>
                        <div class="h-8 w-24 bg-surface-container-high rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. FOUR FEATURES CARDS (Overlapping) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-10 mb-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        
        <!-- Feature 1 -->
        <div class="bg-surface rounded-2xl p-6 border border-outline-variant shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-5 border border-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </div>
            <h3 class="font-bold text-lg text-on-surface mb-2">Transparan</h3>
            <p class="text-sm text-on-surface-variant leading-relaxed">Seluruh pengelolaan masukan dilakukan secara terbuka untuk evaluasi publik.</p>
        </div>
        
        <!-- Feature 2 -->
        <div class="bg-surface rounded-2xl p-6 border border-outline-variant shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-5 border border-emerald-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <h3 class="font-bold text-lg text-on-surface mb-2">Cepat & Mudah</h3>
            <p class="text-sm text-on-surface-variant leading-relaxed">Pengisian kuesioner didesain sangat ringkas, hanya memakan waktu 2-3 menit.</p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-surface rounded-2xl p-6 border border-outline-variant shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-5 border border-rose-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <h3 class="font-bold text-lg text-on-surface mb-2">Aman & Anonim</h3>
            <p class="text-sm text-on-surface-variant leading-relaxed">Identitas Anda terlindungi. Berikan kritik dan saran tanpa rasa ragu.</p>
        </div>

        <!-- Feature 4 -->
        <div class="bg-surface rounded-2xl p-6 border border-outline-variant shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-5 border border-amber-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <h3 class="font-bold text-lg text-on-surface mb-2">Berdampak Nyata</h3>
            <p class="text-sm text-on-surface-variant leading-relaxed">Setiap data yang masuk dianalisis langsung untuk perbaikan mutu layanan.</p>
        </div>
    </div>
</div>

<!-- 3. HOW IT WORKS (Vertical List Layout) -->
<div id="cara-kerja" class="py-20 bg-surface-container-high/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            
            <!-- Graphic Left -->
            <div class="flex-1 w-full order-2 lg:order-1">
                <div class="relative aspect-square sm:aspect-video lg:aspect-square bg-surface rounded-[2.5rem] p-8 border border-outline-variant shadow-md flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-surface-container to-surface"></div>
                    <!-- Minimalist UI representation -->
                    <div class="relative z-10 space-y-4 w-full max-w-sm">
                        <div class="bg-surface border border-outline-variant rounded-xl p-4 shadow-sm flex items-center gap-4 transform -translate-x-4">
                            <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">1</div>
                            <div class="h-3 w-32 bg-surface-container-high rounded"></div>
                        </div>
                        <div class="bg-surface border border-outline-variant rounded-xl p-4 shadow-sm flex items-center gap-4 transform translate-x-4">
                            <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">2</div>
                            <div class="h-3 w-40 bg-surface-container-high rounded"></div>
                        </div>
                        <div class="bg-surface border border-outline-variant rounded-xl p-4 shadow-sm flex items-center gap-4 transform -translate-x-2">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="h-3 w-24 bg-surface-container-high rounded"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text & List Right -->
            <div class="flex-1 order-1 lg:order-2">
                <h2 class="text-3xl sm:text-4xl font-bold text-on-surface mb-4">Langkah Sederhana!</h2>
                <p class="text-on-surface-variant mb-10 text-lg">Kami memahami waktu Anda sangat berharga. Oleh karena itu, kami merancang proses pengisian masukan dengan 3 tahap instan.</p>
                
                <div class="space-y-8">
                    <!-- Step 1 -->
                    <div class="flex gap-5">
                        <div class="w-12 h-12 shrink-0 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-xl border border-primary/20">1</div>
                        <div>
                            <h4 class="text-xl font-bold text-on-surface mb-1">Pilih Layanan</h4>
                            <p class="text-on-surface-variant leading-relaxed">Pilih survei dari daftar layanan instansi yang baru saja Anda gunakan.</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex gap-5">
                        <div class="w-12 h-12 shrink-0 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-xl border border-primary/20">2</div>
                        <div>
                            <h4 class="text-xl font-bold text-on-surface mb-1">Jawab Kuesioner</h4>
                            <p class="text-on-surface-variant leading-relaxed">Berikan penilaian Anda melalui beberapa pilihan ganda dan kolom esai untuk masukan spesifik.</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex gap-5">
                        <div class="w-12 h-12 shrink-0 rounded-full bg-primary text-on-primary font-bold flex items-center justify-center text-xl shadow-md shadow-primary/30">3</div>
                        <div>
                            <h4 class="text-xl font-bold text-on-surface mb-1">Kirim & Selesai</h4>
                            <p class="text-on-surface-variant leading-relaxed">Kirim masukan Anda. Sistem akan mengolah data secara real-time untuk ditinjau oleh pimpinan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 flex gap-4">
                    <a href="{{ route('surveys.index') }}" class="btn btn-primary rounded-xl px-8 shadow-md">Mulai Sekarang</a>

                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- 4. ABOUT AGENCY / SIKAP -->
<div class="py-24 bg-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row-reverse items-center gap-16">
            
            <!-- Graphic Right -->
            <div class="flex-1 w-full">
                <div class="relative bg-gradient-to-br from-surface-container to-surface-container-high rounded-[2.5rem] p-10 border border-outline-variant shadow-sm aspect-video md:aspect-auto md:h-[400px] flex flex-col justify-center overflow-hidden">
                    <!-- Abstract Data visualization -->
                    <div class="flex items-end gap-3 h-40 mt-auto justify-center opacity-80">
                        <div class="w-12 bg-primary/40 rounded-t-lg h-[40%]"></div>
                        <div class="w-12 bg-primary/60 rounded-t-lg h-[70%]"></div>
                        <div class="w-12 bg-primary/80 rounded-t-lg h-[50%]"></div>
                        <div class="w-12 bg-primary rounded-t-lg h-[90%] shadow-lg shadow-primary/20"></div>
                    </div>
                </div>
            </div>

            <!-- Text Left -->
            <div class="flex-1">
                <div class="inline-block px-3 py-1 bg-surface-container-high text-on-surface font-semibold text-sm rounded-lg mb-4 border border-outline-variant">Tentang Platform</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-on-surface mb-6">Misi Kami</h2>
                <p class="text-on-surface-variant mb-6 text-lg leading-relaxed">
                    Kami percaya pada kekuatan data. Pendekatan berbasis analitik memungkinkan instansi pemerintah untuk membuat keputusan yang tepat sasaran.
                </p>
                <p class="text-on-surface-variant mb-8 leading-relaxed">
                    SIKAP (Sistem Informasi Kepuasan Masyarakat) dikembangkan oleh Dinas Komunikasi dan Informatika Kota Batam untuk menjadi jembatan komunikasi digital antara pelayanan publik dan masyarakat. Mari ubah pengalaman nyata Anda menjadi perbaikan layanan yang terukur.
                </p>

            </div>
            
        </div>
    </div>
</div>

<!-- 5. ACTIVE SURVEYS -->
<div class="py-24 bg-surface-container-high/20 border-t border-outline-variant/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <div class="inline-block px-3 py-1 bg-primary/10 text-primary font-semibold text-sm rounded-lg mb-4 border border-primary/20">Survei Tersedia</div>
            <h2 class="text-3xl sm:text-4xl font-bold text-on-surface mb-4">Survei yang Sedang Berjalan</h2>
            <p class="text-on-surface-variant max-w-2xl mx-auto text-lg">Pilih survei di bawah dan berikan penilaian Anda. Suara Anda membantu meningkatkan kualitas layanan publik Kota Batam.</p>
        </div>

        @if($activeSurveys->isEmpty())
            <div class="flex flex-col items-center justify-center text-center py-20">
                <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2">Belum Ada Survei Aktif</h3>
                <p class="text-on-surface-variant max-w-sm">Saat ini belum ada survei yang sedang berjalan. Silakan kunjungi kembali lain waktu.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($activeSurveys as $survey)
                    <div class="bg-surface rounded-3xl p-8 border border-outline-variant shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                        <!-- Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-on-primary transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>

                        <!-- Content -->
                        <h3 class="text-xl font-bold text-on-surface mb-3 leading-snug">{{ $survey->judul }}</h3>
                        <p class="text-on-surface-variant text-sm leading-relaxed flex-1 line-clamp-3 mb-6">{{ $survey->deskripsi }}</p>

                        <!-- Meta & CTA -->
                        <div class="pt-5 border-t border-outline-variant/50 flex items-center justify-between">
                            <div class="flex items-center gap-1.5 text-sm text-on-surface-variant">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="font-semibold">{{ $survey->questions_count }} pertanyaan</span>
                            </div>
                            <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-primary btn-sm rounded-xl shadow-none no-animation">
                                Isi Survei
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($activeSurveys->count() >= 6)
                <div class="text-center mt-12">
                    <a href="{{ route('surveys.index') }}" class="btn btn-outline btn-primary rounded-xl px-8 shadow-none no-animation">
                        Lihat Semua Survei
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>


@endsection
