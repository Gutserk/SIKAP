@extends('layouts.admin')

@section('title', 'Detail Jawaban - ' . $survey->judul)

@section('admin_content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Unified Hero Card -->
    <div class="bg-surface-container-high rounded-3xl shadow-sm border border-outline-variant overflow-hidden">
        
        <!-- Top Bar: Back & Actions -->
        <div class="p-5 lg:px-8 border-b border-outline-variant/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-container-lowest/50">
            <a href="{{ route('admin.surveys.show', ['survey' => $survey->id, 'page' => request('page') ?: 1]) }}" class="btn btn-sm btn-ghost bg-surface hover:bg-surface-container-high border border-outline-variant text-on-surface rounded-xl shadow-none hover:shadow-none no-animation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Detail Survei
            </a>
            
            <div class="px-3 py-1 bg-green-100 text-green-700 font-bold tracking-wide rounded-full text-xs uppercase border border-green-200">
                Telah Mengisi
            </div>
        </div>

        <!-- Hero Content (Profile) -->
        <div class="p-6 lg:p-10 bg-surface">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-on-surface tracking-tight mb-8">Rincian Jawaban</h1>
            
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 bg-surface-container-lowest/50 p-6 rounded-2xl border border-outline-variant/40">
                @php
                    $words = explode(' ', $submission->respondent->nama);
                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                @endphp
                <div class="w-20 h-20 rounded-full bg-primary/10 text-primary flex items-center justify-center text-3xl font-black shrink-0 border-2 border-primary/20">
                    {{ $initials }}
                </div>
                <div class="flex-1 w-full">
                    <h2 class="text-2xl font-bold text-on-surface mb-1">{{ $submission->respondent->nama }}</h2>
                    <div class="text-sm font-medium text-on-surface-variant mb-4 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        {{ $submission->respondent->email }}
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-4 w-full">
                        <div class="flex flex-wrap gap-3">
                            <div class="text-sm font-medium text-on-surface-variant flex items-center gap-1.5 px-3 py-1 bg-surface-container rounded-lg border border-outline-variant/30">
                                Usia: <span class="text-on-surface">{{ $submission->respondent->usia }} Thn</span>
                            </div>
                            <div class="text-sm font-medium text-on-surface-variant flex items-center gap-1.5 px-3 py-1 bg-surface-container rounded-lg border border-outline-variant/30">
                                Gender: <span class="text-on-surface">{{ $submission->respondent->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="text-sm font-medium text-on-surface-variant flex items-center gap-1.5 px-3 py-1 bg-surface-container rounded-lg border border-outline-variant/30">
                                Pendidikan: <span class="text-on-surface">{{ $submission->respondent->pendidikan }}</span>
                            </div>
                        </div>
                        <div class="text-sm font-medium text-on-surface-variant flex items-center gap-2 px-3 py-1 bg-surface-container rounded-lg border border-outline-variant/30 md:ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-on-surface">{{ \Carbon\Carbon::parse($submission->dikirim_pada)->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answers List (Bottom Section) -->
        <div class="bg-surface-container-high border-t border-outline-variant p-6 lg:p-10">
            <div class="space-y-6">
                @foreach($survey->questions as $index => $question)
                    @php
                        $answer = $submission->answers->where('pertanyaan_id', $question->id)->first();
                    @endphp
                    <div class="bg-surface p-6 rounded-2xl border border-outline-variant shadow-sm">
                        <div class="flex gap-4">
                            <!-- Number Indicator -->
                            <div class="w-10 h-10 shrink-0 bg-primary/10 text-primary flex items-center justify-center rounded-xl font-bold border border-primary/20">
                                {{ $index + 1 }}
                            </div>

                            <!-- Question Content -->
                            <div class="flex-1">
                                <h4 class="font-semibold text-on-surface text-lg leading-relaxed mb-4">
                                    {{ $question->teks_pertanyaan }}
                                </h4>

                                @if($question->tipe_pertanyaan == 'pilihan_ganda')
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                        @foreach($question->options()->orderBy('urutan')->get() as $optIndex => $option)
                                            @php
                                                $isSelected = $answer && $answer->pilihan_id == $option->id;
                                            @endphp
                                            <div class="flex items-center gap-3 p-3 rounded-xl transition-all {{ $isSelected ? 'bg-primary/5 border-primary ring-1 ring-primary/20' : 'bg-surface border-outline-variant/50' }} border">
                                                <div class="flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold shrink-0 {{ $isSelected ? 'bg-primary text-primary-content' : 'bg-surface-container-high text-on-surface-variant' }}">
                                                    {{ chr(65 + $optIndex) }}
                                                </div>
                                                <span class="text-sm font-medium {{ $isSelected ? 'text-primary' : 'text-on-surface' }}">{{ $option->teks_pilihan }}</span>
                                                
                                                @if($isSelected)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary ml-auto" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Jawaban Esai -->
                                    <div class="mt-4 p-5 {{ $answer && $answer->teks_jawaban ? 'bg-surface border border-outline-variant rounded-2xl' : 'bg-surface/50 border-2 border-dashed border-outline-variant rounded-2xl flex flex-col items-center justify-center py-10' }}">
                                        @if($answer && $answer->teks_jawaban)
                                            <p class="text-on-surface text-[15px] leading-relaxed whitespace-pre-wrap">{{ $answer->teks_jawaban }}</p>
                                            @if($answer->sentimentResult)
                                                @php
                                                    $sentimen = $answer->sentimentResult->sentimen;
                                                    $badgeClass = match($sentimen) {
                                                        'positif' => 'bg-green-100 text-green-700 border-green-200',
                                                        'negatif' => 'bg-red-100 text-red-700 border-red-200',
                                                        default   => 'bg-amber-100 text-amber-700 border-amber-200',
                                                    };
                                                @endphp
                                                <div class="mt-3 flex items-center gap-2">
                                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide border {{ $badgeClass }}">
                                                        {{ ucfirst($sentimen) }}
                                                    </span>
                                                    <span class="text-xs text-on-surface-variant">{{ round($answer->sentimentResult->skor * 100, 1) }}% keyakinan</span>
                                                </div>
                                            @endif
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-3 opacity-30 text-on-surface-variant" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            <p class="text-on-surface-variant/70 text-sm font-medium">Responden tidak memberikan jawaban esai.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
