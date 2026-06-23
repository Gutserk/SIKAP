@extends('layouts.public')

@section('title', $survey->judul . ' - SIKAP')

@section('public_content')
<div class="bg-surface-container py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="max-w-3xl mx-auto">

        <!-- Back Button -->
        <a href="{{ route('surveys.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-medium mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Daftar Survei
        </a>

        @if(session('error'))
            <div class="alert alert-error rounded-2xl mb-6 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Survey Header Card -->
        <div class="bg-surface rounded-3xl shadow-sm border-t-8 border-t-primary border border-outline-variant overflow-hidden mb-8">
            <div class="p-8 md:p-10">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center gap-1.5 px-2.5 py-1 bg-success/10 text-success text-xs font-bold rounded-full border border-success/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
                        Survei Aktif
                    </span>
                    <span class="text-xs text-on-surface-variant">{{ $survey->questions->count() }} pertanyaan</span>
                </div>
                <h1 class="text-3xl font-extrabold text-on-surface mb-4">{{ $survey->judul }}</h1>
                <p class="text-lg text-on-surface-variant leading-relaxed">{{ $survey->deskripsi }}</p>

                <div class="mt-6 pt-6 border-t border-outline-variant text-sm text-on-surface-variant flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Identitas Anda akan dirahasiakan. Mohon isi dengan jujur dan objektif.</span>
                </div>
            </div>
        </div>

        <!-- Survey Form -->
        <form action="{{ route('surveys.submit', $survey->id) }}" method="POST" class="flex flex-col gap-8">
            @csrf

            <!-- Respondent Identity Card -->
            <div class="bg-surface rounded-3xl shadow-sm border border-outline-variant p-8 md:p-10">
                <h2 class="text-xl font-bold text-on-surface mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    Identitas Responden
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Name -->
                    <div class="sm:col-span-2 form-control">
                        <label class="label pb-1"><span class="label-text font-bold text-on-surface">Nama Lengkap <span class="text-error">*</span></span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered rounded-xl bg-surface-container-high border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 @error('name') border-error @enderror" placeholder="Masukkan nama lengkap Anda" required>
                        @error('name')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <!-- Gender -->
                    <div class="form-control">
                        <label class="label pb-1"><span class="label-text font-bold text-on-surface">Jenis Kelamin <span class="text-error">*</span></span></label>
                        <select name="gender" class="select select-bordered rounded-xl bg-surface-container-high border-outline-variant focus:border-primary @error('gender') border-error @enderror" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih...</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <!-- Age -->
                    <div class="form-control">
                        <label class="label pb-1"><span class="label-text font-bold text-on-surface">Usia <span class="text-error">*</span></span></label>
                        <input type="number" name="age" value="{{ old('age') }}" class="input input-bordered rounded-xl bg-surface-container-high border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 @error('age') border-error @enderror" placeholder="Contoh: 25" min="1" max="120" required>
                        @error('age')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <!-- Education -->
                    <div class="form-control">
                        <label class="label pb-1"><span class="label-text font-bold text-on-surface">Pendidikan Terakhir <span class="text-error">*</span></span></label>
                        <select name="education" class="select select-bordered rounded-xl bg-surface-container-high border-outline-variant focus:border-primary @error('education') border-error @enderror" required>
                            <option value="" disabled {{ old('education') ? '' : 'selected' }}>Pilih...</option>
                            <option value="SD" {{ old('education') == 'SD' ? 'selected' : '' }}>SD/Sederajat</option>
                            <option value="SMP" {{ old('education') == 'SMP' ? 'selected' : '' }}>SMP/Sederajat</option>
                            <option value="SMA" {{ old('education') == 'SMA' ? 'selected' : '' }}>SMA/Sederajat</option>
                            <option value="D3" {{ old('education') == 'D3' ? 'selected' : '' }}>D3/D4</option>
                            <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('education')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                    <!-- Email -->
                    <div class="form-control">
                        <label class="label pb-1"><span class="label-text font-bold text-on-surface">Email <span class="text-error">*</span></span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered rounded-xl bg-surface-container-high border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 @error('email') border-error @enderror" placeholder="email@contoh.com" required>
                        @error('email')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <!-- Questions -->
            @foreach($survey->questions->sortBy('urutan') as $index => $question)
            <div class="bg-surface rounded-3xl shadow-sm border {{ $errors->has('answers.' . $question->id) ? 'border-error ring-1 ring-error/30' : 'border-outline-variant hover:border-primary/50' }} p-8 md:p-10 relative overflow-hidden group transition-colors">

                <!-- Left accent bar -->
                <div class="absolute top-0 left-0 w-1.5 h-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-l-3xl"></div>

                <!-- Question Text -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-on-surface leading-snug">
                        <span class="inline-flex items-center justify-center w-7 h-7 bg-primary/10 text-primary rounded-lg text-sm font-bold mr-2">{{ $index + 1 }}</span>
                        {{ $question->teks_pertanyaan }}
                        @if($question->wajib_diisi)
                            <span class="text-error ml-1 text-base">*</span>
                        @endif
                    </h3>
                </div>

                <!-- Answer Input -->
                <div class="pl-0 sm:pl-9">
                    @if($question->tipe_pertanyaan === 'pilihan_ganda')
                        <div class="flex flex-col gap-3">
                            @foreach($question->options->sortBy('urutan')->values() as $optIndex => $option)
                            <label class="flex items-center gap-4 p-4 rounded-xl border border-outline-variant cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 has-[:checked]:ring-1 has-[:checked]:ring-primary">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->teks_pilihan }}" class="hidden peer" {{ $question->wajib_diisi ? 'required' : '' }} {{ old('answers.' . $question->id) == $option->teks_pilihan ? 'checked' : '' }}>
                                <div class="flex items-center justify-center w-8 h-8 shrink-0 rounded-lg bg-primary/20 text-primary font-bold text-sm transition-colors peer-checked:bg-primary peer-checked:text-on-primary peer-checked:shadow-md peer-checked:shadow-primary/30">
                                    {{ chr(65 + $optIndex) }}
                                </div>
                                <span class="text-on-surface font-medium peer-checked:text-primary transition-colors">{{ $option->teks_pilihan }}</span>
                            </label>
                            @endforeach
                        </div>
                    @elseif($question->tipe_pertanyaan === 'skala_linear')
                        @php $sMin = $question->skala_min ?? 1; $sMax = $question->skala_max ?? 5; @endphp
                        <div class="space-y-3">
                            @if($question->skala_min_label || $question->skala_max_label)
                                <div class="flex justify-between text-sm text-on-surface-variant font-medium px-1">
                                    <span>{{ $question->skala_min_label ?: '' }}</span>
                                    <span>{{ $question->skala_max_label ?: '' }}</span>
                                </div>
                            @endif
                            <!-- Lingkaran angka (Google Forms style) -->
                            <div class="flex flex-wrap justify-center gap-2">
                                @for($si = $sMin; $si <= $sMax; $si++)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $si }}" class="hidden peer" {{ $question->wajib_diisi ? 'required' : '' }} {{ old('answers.' . $question->id) == $si ? 'checked' : '' }}>
                                    <div class="w-12 h-12 rounded-full border-2 border-outline-variant font-bold flex items-center justify-center text-on-surface-variant transition-all select-none text-base
                                        peer-checked:border-primary peer-checked:bg-primary peer-checked:text-primary-content peer-checked:shadow-md peer-checked:shadow-primary/30
                                        hover:border-primary hover:bg-primary/10 hover:text-primary">{{ $si }}</div>
                                </label>
                                @endfor
                            </div>
                        </div>
                    @elseif($question->tipe_pertanyaan === 'esai')
                        <textarea name="answers[{{ $question->id }}]" rows="4" class="textarea textarea-bordered w-full rounded-xl bg-surface-container-high border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface text-base" placeholder="Ketik jawaban Anda di sini..." {{ $question->wajib_diisi ? 'required' : '' }}>{{ old('answers.' . $question->id) }}</textarea>
                    @endif
                </div>
                @error('answers.' . $question->id)
                    <p class="text-error text-sm mt-3 pl-0 sm:pl-9 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            @endforeach

            <!-- Submit Area -->
            <div class="bg-surface rounded-3xl shadow-sm border border-outline-variant p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-on-surface-variant">
                    <span class="text-error font-bold">*</span> Wajib diisi. Pastikan semua pertanyaan wajib telah dijawab.
                </p>
                <button type="submit" class="btn btn-primary btn-lg rounded-2xl text-on-primary px-10 shadow-md shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all w-full sm:w-auto no-animation">
                    Kirim Jawaban
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
