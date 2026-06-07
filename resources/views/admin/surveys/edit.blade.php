@extends('layouts.admin')

@section('title', 'Edit Survei - ' . $survey->title)

@section('admin_content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Unified Hero Card -->
    <div class="bg-surface-container-high rounded-3xl shadow-sm border border-outline-variant overflow-hidden">
        
        <!-- Top Bar -->
        <div class="p-5 lg:px-8 border-b border-outline-variant/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-container-lowest/50">
            <a href="{{ route('admin.surveys.show', $survey) }}" class="btn btn-sm btn-ghost bg-surface hover:bg-surface-container-high border border-outline-variant text-on-surface rounded-xl shadow-none hover:shadow-none no-animation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Batal Edit
            </a>
            <div class="px-3 py-1 bg-amber-100 text-amber-700 font-bold tracking-wide rounded-full text-xs uppercase border border-amber-200">
                Mode Edit
            </div>
        </div>

        <form action="{{ route('admin.surveys.update', $survey) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Hero Content (Survey Info) -->
            <div class="p-6 lg:p-10 bg-surface">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-on-surface tracking-tight mb-8">Edit Survei</h1>
                
                <div class="space-y-6 max-w-3xl">
                    <!-- Title -->
                    <div class="form-control w-full">
                        <label class="label pb-1">
                            <span class="label-text font-bold text-on-surface">Judul Survei <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $survey->title) }}" class="input input-lg input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface text-lg font-semibold @error('title') border-error focus:border-error @enderror" placeholder="Contoh: Indeks Kepuasan Masyarakat 2026" required maxlength="200" />
                        @error('title')
                            <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-control w-full">
                        <label class="label pb-1">
                            <span class="label-text font-bold text-on-surface">Deskripsi Survei <span class="text-error">*</span></span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface h-28 leading-relaxed @error('description') border-error focus:border-error @enderror" placeholder="Jelaskan tujuan dan konteks dari survei ini secara singkat..." required>{{ old('description', $survey->description) }}</textarea>
                        @error('description')
                            <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Start Date -->
                        <div class="form-control w-full">
                            <label class="label pb-1">
                                <span class="label-text font-bold text-on-surface">Tanggal Mulai</span>
                            </label>
                            <input type="date" name="start_date" value="{{ old('start_date', $survey->start_date ? $survey->start_date->format('Y-m-d') : '') }}" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface @error('start_date') border-error focus:border-error @enderror" />
                            @error('start_date')
                                <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="form-control w-full">
                            <label class="label pb-1">
                                <span class="label-text font-bold text-on-surface">Tanggal Selesai</span>
                            </label>
                            <input type="date" name="end_date" value="{{ old('end_date', $survey->end_date ? $survey->end_date->format('Y-m-d') : '') }}" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface @error('end_date') border-error focus:border-error @enderror" />
                            @error('end_date')
                                <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-control w-full">
                            <label class="label pb-1">
                                <span class="label-text font-bold text-on-surface">Status <span class="text-error">*</span></span>
                            </label>
                            <select name="status" class="select select-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface font-semibold @error('status') border-error focus:border-error @enderror" required>
                                <option value="draft" {{ old('status', $survey->status) == 'draft' ? 'selected' : '' }}>Draft (Belum Rilis)</option>
                                <option value="active" {{ old('status', $survey->status) == 'active' ? 'selected' : '' }}>Aktif (Publik)</option>
                                <option value="closed" {{ old('status', $survey->status) == 'closed' ? 'selected' : '' }}>Ditutup</option>
                            </select>
                            @error('status')
                                <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-surface-container-high border-t border-outline-variant p-6 lg:p-10">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-on-surface">Daftar Pertanyaan</h3>
                    <p class="text-sm text-on-surface-variant mt-1">Susun daftar pertanyaan yang ingin Anda ajukan kepada masyarakat.</p>
                </div>

                <div id="questions-container" class="space-y-6 mb-6">
                    @foreach($survey->questions()->orderBy('order')->get() as $qIndex => $question)
                        <div class="question-block p-5 border border-outline-variant rounded-xl bg-surface relative group transition-all" data-index="{{ $qIndex }}">
                            <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">
                            
                            <!-- Floating Delete Button -->
                            <button type="button" class="absolute top-4 right-4 btn btn-sm btn-circle btn-ghost text-rose-500 hover:bg-rose-50 hover:text-rose-600 no-animation btn-remove-question transition-colors" title="Hapus Pertanyaan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <div class="flex items-start gap-3">
                                <!-- Number Badge -->
                                <div class="w-8 h-8 shrink-0 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold text-sm question-number-badge">
                                    {{ $qIndex + 1 }}
                                </div>
                                
                                <div class="flex-1 pt-1 space-y-4 pr-10">
                                    <div class="form-control w-full">
                                        <label class="label pb-1 pt-0"><span class="label-text font-bold text-on-surface text-[15px]">Teks Pertanyaan <span class="text-error">*</span></span></label>
                                        <input type="text" name="questions[{{ $qIndex }}][question_text]" value="{{ $question->question_text }}" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface text-base" required>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-6 mt-2">
                                        <div class="form-control w-full sm:w-64">
                                            <label class="label pb-1 pt-0"><span class="label-text font-bold text-on-surface text-sm">Jenis Jawaban</span></label>
                                            <select name="questions[{{ $qIndex }}][question_type]" class="select select-bordered rounded-xl w-full bg-surface-container-high border-primary/30 question-type-select font-medium text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20">
                                                <option value="essay" {{ $question->question_type == 'essay' ? 'selected' : '' }}>Esai Bebas (Teks Panjang)</option>
                                                <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda (Satu Jawaban)</option>
                                            </select>
                                        </div>
                                        <div class="form-control pt-5">
                                            <input type="hidden" name="questions[{{ $qIndex }}][is_required]" value="0">
                                            <label class="cursor-pointer label gap-3 p-0">
                                                <input type="checkbox" name="questions[{{ $qIndex }}][is_required]" value="1" class="toggle toggle-success" {{ $question->is_required ? 'checked' : '' }} />
                                                <span class="label-text font-bold text-on-surface text-sm">Wajib Diisi</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="options-container {{ $question->question_type == 'multiple_choice' ? '' : 'hidden' }} mt-4 pt-5 border-t border-outline-variant/50">
                                        <label class="label pb-3"><span class="label-text font-bold text-on-surface text-[15px]">Opsi Jawaban</span></label>
                                        <div class="options-list grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @if($question->question_type == 'multiple_choice')
                                                @foreach($question->options()->orderBy('order')->get() as $optIndex => $option)
                                                    <div class="flex items-center gap-3 p-3 rounded-xl bg-surface border border-outline-variant/60 focus-within:border-primary focus-within:bg-primary/5 transition-all group relative pr-10 shadow-sm">
                                                        <div class="flex items-center justify-center w-7 h-7 shrink-0 rounded-lg bg-surface-container-high group-focus-within:bg-primary group-focus-within:text-primary-content text-on-surface-variant font-bold text-xs transition-colors option-letter">
                                                            {{ chr(65 + $optIndex) }}
                                                        </div>
                                                        <input type="text" name="questions[{{ $qIndex }}][options][]" value="{{ $option->option_text }}" class="input input-sm w-full bg-transparent border-none px-0 focus:outline-none focus:ring-0 text-sm font-medium group-focus-within:text-primary transition-colors h-auto py-0" required>
                                                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-xs btn-circle btn-ghost text-outline-variant hover:bg-rose-50 hover:text-rose-500 no-animation btn-remove-option opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-sm bg-surface-container hover:bg-surface-container-high border border-outline-variant/60 text-on-surface font-semibold mt-4 no-animation btn-add-option rounded-xl shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Tambah Opsi Lainnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-8">
                    <button type="button" id="add-question-btn" class="btn bg-primary hover:bg-primary-focus text-primary-content border-none rounded-xl shadow-sm no-animation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Pertanyaan Baru
                    </button>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-5 lg:px-8 bg-surface-container-lowest/50 border-t border-outline-variant flex justify-end gap-3">
                <a href="{{ route('admin.surveys.show', $survey) }}" class="btn bg-surface hover:bg-surface-container-high border-outline-variant text-on-surface font-semibold no-animation shadow-none rounded-xl">Batal</a>
                <button type="submit" class="btn btn-primary no-animation shadow-sm rounded-xl">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = {{ $survey->questions()->count() }};
    const container = document.getElementById('questions-container');
    const addBtn = document.getElementById('add-question-btn');

    function updateQuestionNumbers() {
        const blocks = container.querySelectorAll('.question-block');
        blocks.forEach((block, index) => {
            const badge = block.querySelector('.question-number-badge');
            if(badge) {
                badge.textContent = index + 1;
            }
        });
    }

    // Attach events to existing blocks generated by Blade
    document.querySelectorAll('.question-block').forEach(block => {
        const qIndex = block.getAttribute('data-index');
        attachBlockEvents(block, qIndex);
    });

    addBtn.addEventListener('click', function() {
        const qIndex = questionCount++;
        const qHtml = `
            <div class="question-block p-5 border border-outline-variant rounded-xl bg-surface relative group transition-all" data-index="${qIndex}">
                
                <!-- Floating Delete Button -->
                <button type="button" class="absolute top-4 right-4 btn btn-sm btn-circle btn-ghost text-rose-500 hover:bg-rose-50 hover:text-rose-600 no-animation btn-remove-question transition-colors" title="Hapus Pertanyaan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <div class="flex items-start gap-3">
                    <!-- Number Badge -->
                    <div class="w-8 h-8 shrink-0 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold text-sm question-number-badge">
                        ${qIndex + 1}
                    </div>
                    
                    <div class="flex-1 pt-1 space-y-4 pr-10">
                        <div class="form-control w-full">
                            <label class="label pb-1 pt-0"><span class="label-text font-bold text-on-surface text-[15px]">Teks Pertanyaan <span class="text-error">*</span></span></label>
                            <input type="text" name="questions[${qIndex}][question_text]" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface text-base" placeholder="Ketik pertanyaan Anda di sini..." required>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-6 mt-2">
                            <div class="form-control w-full sm:w-64">
                                <label class="label pb-1 pt-0"><span class="label-text font-bold text-on-surface text-sm">Jenis Jawaban</span></label>
                                <select name="questions[${qIndex}][question_type]" class="select select-bordered rounded-xl w-full bg-surface-container-high border-primary/30 question-type-select font-medium text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="essay">Esai Bebas (Teks Panjang)</option>
                                    <option value="multiple_choice">Pilihan Ganda (Satu Jawaban)</option>
                                </select>
                            </div>
                            <div class="form-control pt-5">
                                <input type="hidden" name="questions[${qIndex}][is_required]" value="0">
                                <label class="cursor-pointer label gap-3 p-0">
                                    <input type="checkbox" name="questions[${qIndex}][is_required]" value="1" class="toggle toggle-success" checked />
                                    <span class="label-text font-bold text-on-surface text-sm">Wajib Diisi</span>
                                </label>
                            </div>
                        </div>

                        <!-- Options Container -->
                        <div class="options-container hidden mt-4 pt-5 border-t border-outline-variant/50">
                            <label class="label pb-3"><span class="label-text font-bold text-on-surface text-[15px]">Opsi Jawaban</span></label>
                            <div class="options-list grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Option inputs will go here -->
                            </div>
                            <button type="button" class="btn btn-sm bg-surface-container hover:bg-surface-container-high border border-outline-variant/60 text-on-surface font-semibold mt-4 no-animation btn-add-option rounded-xl shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Opsi Lainnya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', qHtml);
        const newBlock = container.lastElementChild;
        updateQuestionNumbers();
        attachBlockEvents(newBlock, qIndex);
    });

    function attachBlockEvents(block, qIndex) {
        // Handle Question Remove
        block.querySelector('.btn-remove-question').addEventListener('click', function() {
            block.style.opacity = '0';
            block.style.transform = 'scale(0.98)';
            setTimeout(() => {
                block.remove();
                updateQuestionNumbers();
            }, 200);
        });

        // Handle Type Change
        const typeSelect = block.querySelector('.question-type-select');
        const optsContainer = block.querySelector('.options-container');
        const optsList = block.querySelector('.options-list');
        
        typeSelect.addEventListener('change', function() {
            if(this.value === 'multiple_choice') {
                optsContainer.classList.remove('hidden');
                // add initial 2 options if empty
                if(optsList.children.length === 0) {
                    addOption(optsList, qIndex, 'Sangat Setuju');
                    addOption(optsList, qIndex, 'Tidak Setuju');
                }
            } else {
                optsContainer.classList.add('hidden');
            }
        });

        // Handle Add Option
        block.querySelector('.btn-add-option').addEventListener('click', function() {
            addOption(optsList, qIndex, '');
        });

        // Attach remove events to existing options (if any)
        optsList.querySelectorAll('.btn-remove-option').forEach(btn => {
            btn.addEventListener('click', function() {
                if(optsList.children.length > 2) {
                    this.closest('.flex').remove();
                    updateOptionLetters(optsList);
                } else {
                    alert('Pilihan ganda minimal harus memiliki 2 opsi.');
                }
            });
        });
    }

    function updateOptionLetters(list) {
        const letters = list.querySelectorAll('.option-letter');
        letters.forEach((badge, index) => {
            badge.textContent = String.fromCharCode(65 + index); // 65 is 'A'
        });
    }

    function addOption(list, qIndex, defaultVal) {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-3 p-3 rounded-xl bg-surface border border-outline-variant/60 focus-within:border-primary focus-within:bg-primary/5 transition-all group relative pr-10 shadow-sm';
        div.innerHTML = `
            <div class="flex items-center justify-center w-7 h-7 shrink-0 rounded-lg bg-surface-container-high group-focus-within:bg-primary group-focus-within:text-primary-content text-on-surface-variant font-bold text-xs transition-colors option-letter">
                A
            </div>
            <input type="text" name="questions[${qIndex}][options][]" value="${defaultVal}" class="input input-sm w-full bg-transparent border-none px-0 focus:outline-none focus:ring-0 text-sm font-medium group-focus-within:text-primary transition-colors h-auto py-0" placeholder="Ketik opsi jawaban..." required>
            <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-xs btn-circle btn-ghost text-outline-variant hover:bg-rose-50 hover:text-rose-500 no-animation btn-remove-option opacity-0 group-hover:opacity-100 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        `;
        list.appendChild(div);
        updateOptionLetters(list);
        
        div.querySelector('.btn-remove-option').addEventListener('click', function() {
            if(list.children.length > 2) {
                div.remove();
                updateOptionLetters(list);
            } else {
                alert('Pilihan ganda minimal harus memiliki 2 opsi.');
            }
        });
    }
});
</script>
@endpush
