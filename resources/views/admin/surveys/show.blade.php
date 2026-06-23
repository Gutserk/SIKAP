@extends('layouts.admin')

@section('title', 'Detail Survei')

@section('admin_content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Unified Hero Card -->
    <div class="bg-surface-container-high rounded-3xl shadow-sm border border-outline-variant overflow-hidden">
        
        <!-- Top Bar: Back & Actions -->
        <div class="p-5 lg:px-8 border-b border-outline-variant/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-container-lowest/50">
            <a href="{{ route('admin.surveys.index') }}" class="btn btn-sm btn-ghost bg-surface hover:bg-surface-container-high border border-outline-variant text-on-surface rounded-xl shadow-none hover:shadow-none no-animation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.surveys.export_excel', $survey) }}" class="btn btn-sm bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border-emerald-200 rounded-xl shadow-none no-animation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    Excel
                </a>
                <a href="{{ route('admin.surveys.export_pdf', $survey) }}" target="_blank" class="btn btn-sm bg-rose-50 hover:bg-rose-100 text-rose-700 border-rose-200 rounded-xl shadow-none no-animation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" /></svg>
                    PDF
                </a>
                
                <div class="w-px h-6 bg-outline-variant hidden sm:block mx-1"></div>
                
                <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-sm bg-surface hover:bg-surface-container-high text-on-surface border border-outline-variant rounded-xl shadow-none no-animation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                    Edit
                </a>
                <label for="modal-delete-survey-{{ $survey->id }}" class="btn btn-sm bg-rose-600 hover:bg-rose-700 text-white border-none rounded-xl shadow-none no-animation cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    Hapus
                </label>
            </div>
            
            <!-- Modal Konfirmasi Hapus Survei per item -->
            <input type="checkbox" id="modal-delete-survey-{{ $survey->id }}" class="modal-toggle" />
            <label for="modal-delete-survey-{{ $survey->id }}" class="modal cursor-pointer backdrop-blur-sm transition-all duration-300">
                <label class="modal-box relative bg-surface-container-high border border-outline-variant rounded-2xl shadow-xl max-w-sm text-center" for="">
                    <div class="w-16 h-16 mx-auto bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-on-surface mb-2">Konfirmasi Hapus Survei</h3>
                    <p class="text-sm text-on-surface-variant mb-6 whitespace-normal">Apakah Anda yakin ingin menghapus survei <strong>{{ $survey->judul }}</strong> secara permanen? Seluruh pertanyaan dan respons dari masyarakat akan ikut terhapus.</p>
                    <form action="{{ route('admin.surveys.destroy', $survey->id) }}" method="POST" class="flex justify-center gap-3">
                        @csrf
                        @method('DELETE')
                        <label for="modal-delete-survey-{{ $survey->id }}" class="btn bg-slate-100 hover:bg-slate-200 text-slate-700 border-none shadow-none px-6 rounded-xl cursor-pointer transition-colors">Batal</label>
                        <button type="submit" class="btn bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-6 border-none shadow-none transition-colors">Hapus</button>
                    </form>
                </label>
            </label>
        </div>

        <!-- Hero Content (Title, Desc, Stats) -->
        <div class="p-6 lg:p-10 bg-surface">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl flex items-center gap-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-wrap items-center gap-3 mb-5">
                @if($survey->status == 'aktif')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">Aktif</span>
                @elseif($survey->status == 'draf')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-surface-container-highest text-on-surface-variant">Draft</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-rose-100 text-rose-700">Ditutup</span>
                @endif
                
                @if($survey->tanggal_mulai && $survey->tanggal_selesai)
                    <div class="text-sm font-medium text-on-surface-variant flex items-center gap-1.5 px-3 py-1 bg-surface-container rounded-full border border-outline-variant/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        {{ $survey->tanggal_mulai->format('d M Y') }} - {{ $survey->tanggal_selesai->format('d M Y') }}
                    </div>
                @endif
            </div>

            <h1 class="text-3xl lg:text-4xl font-extrabold text-on-surface tracking-tight mb-4">{{ $survey->judul }}</h1>

            @if($survey->deskripsi)
                <p class="text-lg text-on-surface-variant leading-relaxed max-w-4xl mb-10 whitespace-pre-wrap">{{ $survey->deskripsi }}</p>
            @else
                <p class="text-lg text-on-surface-variant italic max-w-4xl mb-10">Tidak ada deskripsi yang ditambahkan.</p>
            @endif

            <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-4">
                <div class="flex items-center gap-4 bg-primary/10 px-5 py-4 rounded-2xl border border-primary/20">
                    <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-primary uppercase tracking-wider mb-0.5">Pertanyaan</p>
                        <p class="text-2xl font-black text-on-surface leading-none">{{ $survey->questions_count }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-secondary/10 px-5 py-4 rounded-2xl border border-secondary/20">
                    <div class="w-12 h-12 rounded-full bg-secondary/20 text-secondary flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-0.5">Responden</p>
                        <p class="text-2xl font-black text-on-surface leading-none">{{ $survey->submissions_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="bg-surface-container-high rounded-2xl shadow-sm border border-outline-variant overflow-hidden mt-8" x-data="{ tab: new URLSearchParams(location.search).get('page') ? 'responden' : 'pertanyaan' }">
        <div class="border-b border-outline-variant px-6 overflow-x-auto hide-scrollbar">
            <div class="flex gap-6 min-w-max">
                <button @click="tab = 'pertanyaan'" :class="tab === 'pertanyaan' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-on-surface font-medium'" class="py-4 text-sm transition-colors focus:outline-none cursor-pointer">
                    Daftar Pertanyaan
                </button>
                <button @click="tab = 'analitik'" :class="tab === 'analitik' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-on-surface font-medium'" class="py-4 text-sm transition-colors focus:outline-none cursor-pointer">
                    Respon Jawaban
                </button>
                <button @click="tab = 'responden'" :class="tab === 'responden' ? 'text-primary border-b-2 border-primary font-bold' : 'text-on-surface-variant hover:text-on-surface font-medium'" class="py-4 text-sm transition-colors focus:outline-none cursor-pointer flex items-center gap-2">
                    Daftar Responden
                    <span class="px-2 py-0.5 rounded-full bg-primary/10 text-primary text-xs">{{ $survey->submissions_count }}</span>
                </button>
            </div>
        </div>
        
        <div class="p-6 lg:p-8">
            <!-- TAB: Pertanyaan -->
            <div x-show="tab === 'pertanyaan'" class="space-y-6">
                @if($survey->questions->count() > 0)
                    @foreach($survey->questions->sortBy('urutan')->values() as $index => $question)
                        <div class="p-5 border border-outline-variant rounded-xl bg-surface">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 shrink-0 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 pt-1">
                                    <h4 class="font-semibold text-on-surface text-lg">
                                        {{ $question->teks_pertanyaan }}
                                        @if($question->wajib_diisi)
                                            <span class="text-error ml-1">*</span>
                                        @endif
                                    </h4>
                                    <p class="text-sm text-on-surface-variant mt-1 mb-4">Jenis: {{ $question->tipe_pertanyaan == 'esai' ? 'Esai Bebas' : ($question->tipe_pertanyaan == 'skala_linear' ? 'Skala Linear' : 'Pilihan Ganda') }}</p>

                                    @if($question->tipe_pertanyaan == 'pilihan_ganda')
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                            @foreach($question->options()->orderBy('urutan')->get() as $optIndex => $option)
                                                <div class="flex items-center gap-3 p-3 rounded-xl bg-surface border border-outline-variant cursor-default">
                                                    <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-primary/20 text-primary font-bold text-xs">
                                                        {{ chr(65 + $optIndex) }}
                                                    </div>
                                                    <span class="text-on-surface text-sm font-medium">{{ $option->teks_pilihan }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($question->tipe_pertanyaan == 'skala_linear')
                                        @php $sMin = $question->skala_min ?? 1; $sMax = $question->skala_max ?? 10; @endphp
                                        <div class="mt-4 space-y-2">
                                            @if($question->skala_min_label || $question->skala_max_label)
                                                <div class="flex justify-between text-xs text-on-surface-variant font-medium">
                                                    <span>{{ $question->skala_min_label ?: '' }}</span>
                                                    <span>{{ $question->skala_max_label ?: '' }}</span>
                                                </div>
                                            @endif
                                            <div class="flex flex-wrap justify-center gap-2">
                                                @for($si = $sMin; $si <= $sMax; $si++)
                                                    <div class="w-10 h-10 rounded-full border-2 border-primary/30 bg-primary/5 text-primary font-bold flex items-center justify-center text-sm">{{ $si }}</div>
                                                @endfor
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-4 p-4 rounded-xl bg-surface border border-outline-variant/50 relative min-h-[100px] hover:border-outline-variant transition-colors group cursor-text shadow-sm">
                                            <div class="text-sm text-on-surface-variant/40 group-hover:text-on-surface-variant/60 transition-colors">
                                                Jawaban teks panjang...
                                            </div>
                                            <svg class="absolute bottom-2 right-2 w-3 h-3 text-outline-variant/30 group-hover:text-outline-variant/60 transition-colors" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M10 16v-2h2v-2h2v4h-4zm-4 0v-2h2v-2h2v-2h2v6H6z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <p class="text-on-surface-variant italic">Belum ada pertanyaan yang ditambahkan ke survei ini.</p>
                        <a href="{{ route('admin.surveys.edit', $survey) }}" class="btn btn-sm bg-surface-container hover:bg-surface-container-high border border-outline-variant text-on-surface mt-4 no-animation shadow-none hover:shadow-none">Tambah Pertanyaan</a>
                    </div>
                @endif
            </div>

            <!-- TAB: Analitik -->
            <div x-show="tab === 'analitik'" style="display: none;" class="space-y-8">
                @if($survey->questions->count() > 0 && $survey->submissions_count > 0)
                    @foreach($survey->questions->sortBy('urutan')->values() as $index => $question)
                        <div class="p-6 border border-outline-variant rounded-xl bg-surface">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
                                <div>
                                    <h4 class="font-bold text-on-surface text-lg">{{ $index + 1 }}. {{ $question->teks_pertanyaan }}</h4>
                                    <p class="text-sm text-on-surface-variant mt-1">Total Jawaban: <span class="font-bold text-on-surface">{{ $question->answers_count }}</span></p>
                                </div>
                                @if($question->tipe_pertanyaan == 'pilihan_ganda' || $question->tipe_pertanyaan == 'skala_linear')
                                    <select class="select select-bordered select-sm w-full sm:w-auto chart-type-selector bg-surface-container" data-chart-id="{{ $question->id }}">
                                        <option value="pie">Pie Chart</option>
                                        <option value="bar" {{ $question->tipe_pertanyaan == 'skala_linear' ? 'selected' : '' }}>Bar Chart</option>
                                        <option value="doughnut">Doughnut Chart</option>
                                    </select>
                                @endif
                            </div>

                            @if($question->tipe_pertanyaan == 'pilihan_ganda')
                                <div class="w-full max-w-xs sm:max-w-sm mx-auto h-64 relative flex justify-center">
                                    <canvas id="chart-{{ $question->id }}"></canvas>
                                </div>
                            @elseif($question->tipe_pertanyaan == 'skala_linear')
                                @php
                                    $sMin = $question->skala_min ?? 1;
                                    $sMax = $question->skala_max ?? 10;
                                @endphp
                                <div class="space-y-4">
                                    <div class="w-full h-64 relative">
                                        <canvas id="chart-{{ $question->id }}"></canvas>
                                    </div>
                                    @if($question->skala_min_label || $question->skala_max_label)
                                        <div class="flex justify-between text-xs text-on-surface-variant">
                                            <span>{{ $sMin }} = {{ $question->skala_min_label ?: '-' }}</span>
                                            <span>{{ $sMax }} = {{ $question->skala_max_label ?: '-' }}</span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                @php
                                    $sentimentResults = $question->answers->pluck('sentimentResult')->filter();
                                    $totalSentiment = $sentimentResults->count();
                                    $pctPositif = $totalSentiment > 0 ? round($sentimentResults->where('sentimen', 'positif')->count() / $totalSentiment * 100, 1) : 0;
                                    $pctNetral = $totalSentiment > 0 ? round($sentimentResults->where('sentimen', 'netral')->count() / $totalSentiment * 100, 1) : 0;
                                    $pctNegatif = $totalSentiment > 0 ? round($sentimentResults->where('sentimen', 'negatif')->count() / $totalSentiment * 100, 1) : 0;
                                @endphp
                                <div class="bg-surface-container rounded-xl p-4">
                                    <h5 class="text-sm font-bold text-on-surface-variant uppercase tracking-wider mb-3">Analisis Sentimen</h5>
                                    @if($totalSentiment > 0)
                                        <p class="text-sm text-on-surface mb-3">Dari {{ $totalSentiment }} jawaban esai yang sudah dianalisis, berikut sentimen secara umum:</p>
                                        <div class="space-y-3">
                                            <div>
                                                <div class="flex justify-between text-xs font-semibold mb-1">
                                                    <span class="text-green-600">Positif</span>
                                                    <span class="text-on-surface-variant">{{ $pctPositif }}%</span>
                                                </div>
                                                <progress class="progress progress-success w-full" value="{{ $pctPositif }}" max="100"></progress>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-xs font-semibold mb-1">
                                                    <span class="text-slate-600">Netral</span>
                                                    <span class="text-on-surface-variant">{{ $pctNetral }}%</span>
                                                </div>
                                                <progress class="progress w-full" value="{{ $pctNetral }}" max="100"></progress>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-xs font-semibold mb-1">
                                                    <span class="text-red-600">Negatif</span>
                                                    <span class="text-on-surface-variant">{{ $pctNegatif }}%</span>
                                                </div>
                                                <progress class="progress progress-error w-full" value="{{ $pctNegatif }}" max="100"></progress>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-sm text-on-surface-variant italic">Belum ada jawaban esai yang berhasil dianalisis sentimennya.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface-container mb-4 text-on-surface-variant">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-on-surface mb-2">Data Analitik Belum Tersedia</h3>
                        <p class="text-on-surface-variant max-w-sm mx-auto">Grafik dan analitik akan otomatis muncul setelah ada masyarakat yang mengisi survei ini.</p>
                    </div>
                @endif
            </div>

            <!-- TAB: Responden -->
            <div x-show="tab === 'responden'" style="display: none;" class="space-y-6">
                @if($survey->submissions->count() > 0)
                    <div class="bg-surface rounded-2xl border border-outline-variant/60 shadow-sm overflow-hidden">

                        <!-- Mobile Card View -->
                        <div class="divide-y divide-outline-variant/40 sm:hidden">
                            @foreach($submissions as $submission)
                                @php
                                    $words = explode(' ', $submission->respondent->nama);
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                @endphp
                                <div class="p-4 flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 border border-primary/20">
                                        {{ $initials }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <div class="font-bold text-on-surface truncate">{{ $submission->respondent->nama }}</div>
                                            <a href="{{ route('admin.surveys.submissions.show', [$survey->id, $submission->id]) }}" class="btn btn-xs btn-ghost text-primary hover:bg-primary/10 shadow-none no-animation shrink-0">
                                                Detail
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                            </a>
                                        </div>
                                        <div class="text-xs text-on-surface-variant mt-0.5 truncate">{{ $submission->respondent->email }}</div>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-surface-container font-semibold text-xs text-on-surface-variant border border-outline-variant/40">
                                                {{ $submission->respondent->jenis_kelamin }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-surface-container font-medium text-xs text-on-surface-variant border border-outline-variant/40">
                                                {{ $submission->respondent->usia }} Thn
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-secondary/10 text-secondary font-medium text-xs border border-secondary/20">
                                                {{ $submission->respondent->pendidikan }}
                                            </span>
                                            <span class="text-xs text-on-surface-variant ml-auto">
                                                {{ $submission->dikirim_pada ? \Carbon\Carbon::parse($submission->dikirim_pada)->format('d M Y') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop Table View -->
                        <div class="overflow-x-auto hidden sm:block">
                            <table class="table w-full text-left">
                                <thead>
                                    <tr class="bg-surface-container-lowest/50 border-b border-outline-variant/60 text-on-surface-variant text-xs uppercase tracking-widest font-bold">
                                        <th class="py-4 px-6">Responden</th>
                                        <th class="py-4 px-6">Demografi</th>
                                        <th class="py-4 px-6">Waktu Pengisian</th>
                                        <th class="py-4 px-6 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/40">
                                    @foreach($submissions as $index => $submission)
                                        @php
                                            $words = explode(' ', $submission->respondent->nama);
                                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                        @endphp
                                        <tr>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="avatar placeholder">
                                                        <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm border border-primary/20">
                                                            {{ $initials }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-on-surface">{{ $submission->respondent->nama }}</div>
                                                        <div class="text-xs text-on-surface-variant mt-0.5">{{ $submission->respondent->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-2">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-surface-container font-semibold text-xs text-on-surface-variant border border-outline-variant/40" title="Jenis Kelamin">
                                                        {{ $submission->respondent->jenis_kelamin }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-surface-container font-medium text-xs text-on-surface-variant border border-outline-variant/40">
                                                        {{ $submission->respondent->usia }} Thn
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-secondary/10 text-secondary font-medium text-xs border border-secondary/20">
                                                        {{ $submission->respondent->pendidikan }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="text-sm font-medium text-on-surface">
                                                    {{ $submission->dikirim_pada ? \Carbon\Carbon::parse($submission->dikirim_pada)->format('d M Y') : '-' }}
                                                </div>
                                                <div class="text-xs text-on-surface-variant mt-0.5">
                                                    {{ $submission->dikirim_pada ? \Carbon\Carbon::parse($submission->dikirim_pada)->format('H:i') : '-' }} WIB
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-right">
                                                <a href="{{ route('admin.surveys.submissions.show', [$survey->id, $submission->id]) }}" class="btn btn-sm btn-ghost text-on-surface hover:text-primary hover:bg-primary/10 shadow-none no-animation border border-transparent hover:border-primary/20 rounded-xl">
                                                    Detail
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="p-4 lg:p-5 border-t border-outline-variant/60 bg-surface">
                            {{ $submissions->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface-container mb-4 text-on-surface-variant">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-on-surface mb-2">Belum Ada Responden</h3>
                        <p class="text-on-surface-variant max-w-sm mx-auto">Tabel ini akan menampilkan daftar nama dan data demografis masyarakat yang telah mengisi survei Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- AlpineJS for Tabs -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Chart.js for Analytics -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.surveyCharts = {};
        window.surveyChartConfigs = {};
        
        @if($survey->questions->count() > 0 && $survey->submissions_count > 0)
            @foreach($survey->questions()->where('tipe_pertanyaan', 'pilihan_ganda')->get() as $question)
                @php
                    $labels = [];
                    $data = [];
                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6'];

                    $optionsCount = [];
                    foreach($question->options as $opt) {
                        $optionsCount[$opt->id] = 0;
                        $labels[] = $opt->teks_pilihan;
                    }

                    foreach($survey->submissions as $submission) {
                        $ans = $submission->answers->where('pertanyaan_id', $question->id)->first();
                        if($ans && $ans->pilihan_id && isset($optionsCount[$ans->pilihan_id])) {
                            $optionsCount[$ans->pilihan_id]++;
                        }
                    }

                    foreach($question->options as $opt) {
                        $data[] = $optionsCount[$opt->id];
                    }
                @endphp
                
                const ctx_{{ $question->id }} = document.getElementById('chart-{{ $question->id }}');
                if (ctx_{{ $question->id }}) {
                    window.surveyChartConfigs[{{ $question->id }}] = {
                        type: 'pie',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Jumlah Responden',
                                data: @json($data),
                                backgroundColor: @json(array_slice($colors, 0, count($labels))),
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            family: "'Plus Jakarta Sans', sans-serif"
                                        }
                                    }
                                }
                            }
                        }
                    };
                    
                    window.surveyCharts[{{ $question->id }}] = new Chart(ctx_{{ $question->id }}, window.surveyChartConfigs[{{ $question->id }}]);
                }
            @endforeach

            @foreach($survey->questions()->where('tipe_pertanyaan', 'skala_linear')->get() as $question)
                @php
                    $sMin = $question->skala_min ?? 1;
                    $sMax = $question->skala_max ?? 10;
                    $colorPalette = ['#3b82f6','#6366f1','#8b5cf6','#a855f7','#ec4899','#ef4444','#f97316','#f59e0b','#10b981','#06b6d4'];
                    $scaleLabels = [];
                    $scaleData = [];
                    $scaleColors = [];
                    for($si = $sMin; $si <= $sMax; $si++) {
                        $scaleLabels[] = (string) $si;
                        $cnt = 0;
                        foreach($survey->submissions as $submission) {
                            $ans = $submission->answers->where('pertanyaan_id', $question->id)->first();
                            if($ans && is_numeric($ans->teks_jawaban) && (int) $ans->teks_jawaban === $si) $cnt++;
                        }
                        $scaleData[] = $cnt;
                        $scaleColors[] = $colorPalette[($si - $sMin) % count($colorPalette)];
                    }
                @endphp

                const ctx_{{ $question->id }} = document.getElementById('chart-{{ $question->id }}');
                if (ctx_{{ $question->id }}) {
                    window.surveyChartConfigs[{{ $question->id }}] = {
                        type: 'bar',
                        data: {
                            labels: @json($scaleLabels),
                            datasets: [{
                                label: 'Jumlah Responden',
                                data: @json($scaleData),
                                backgroundColor: @json($scaleColors),
                                borderWidth: 2,
                                borderColor: '#ffffff',
                                borderRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                    position: 'bottom',
                                    labels: { padding: 20, font: { family: "'Plus Jakarta Sans', sans-serif" } }
                                }
                            },
                            scales: {
                                y: { beginAtZero: true, ticks: { stepSize: 1 } }
                            }
                        }
                    };
                    window.surveyCharts[{{ $question->id }}] = new Chart(ctx_{{ $question->id }}, window.surveyChartConfigs[{{ $question->id }}]);
                }
            @endforeach
        @endif

        // Handle Dynamic Chart Type Change
        document.querySelectorAll('.chart-type-selector').forEach(selector => {
            selector.addEventListener('change', function() {
                const chartId = this.getAttribute('data-chart-id');
                const newType = this.value;
                
                if (window.surveyCharts[chartId]) {
                    window.surveyCharts[chartId].destroy();
                }
                
                const config = window.surveyChartConfigs[chartId];
                config.type = newType;
                
                // Adjust options based on type (e.g. scales for bar)
                if (newType === 'bar') {
                    config.options.scales = {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    };
                    config.options.plugins.legend.display = false; // Hide legend for single dataset bar
                } else {
                    config.options.scales = {};
                    config.options.plugins.legend.display = true;
                }
                
                const ctx = document.getElementById('chart-' + chartId);
                window.surveyCharts[chartId] = new Chart(ctx, config);
            });
        });
    });
</script>
@endpush
