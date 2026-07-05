@extends('layouts.admin')

@section('title', 'Buat Survei Baru')

@section('admin_content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Unified Hero Card -->
    <div class="bg-surface-container-high rounded-3xl shadow-sm border border-outline-variant overflow-hidden">
        
        <!-- Top Bar -->
        <div class="p-5 lg:px-8 border-b border-outline-variant/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-container-lowest/50">
            <a href="{{ route('admin.surveys.index') }}" class="btn btn-sm btn-ghost bg-surface hover:bg-surface-container-high border border-outline-variant text-on-surface rounded-xl shadow-none hover:shadow-none no-animation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Survei
            </a>
            <div class="px-3 py-1 bg-primary/10 text-primary font-bold tracking-wide rounded-full text-xs uppercase border border-primary/20">
                Mode Pembuatan
            </div>
        </div>

        <form action="{{ route('admin.surveys.store') }}" method="POST">
            @csrf
            
            <!-- Hero Content (Survey Info) -->
            <div class="p-6 lg:p-10 bg-surface">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-on-surface tracking-tight mb-8">Buat Survei Baru</h1>
                
                <div class="space-y-6 max-w-3xl">
                    <!-- Title -->
                    <div class="form-control w-full">
                        <label class="label pb-1">
                            <span class="label-text font-bold text-on-surface">Judul Survei <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" class="input input-lg input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface text-lg font-semibold @error('title') border-error focus:border-error @enderror" placeholder="Contoh: Indeks Kepuasan Masyarakat 2026" required maxlength="200" />
                        @error('title')
                            <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-control w-full">
                        <label class="label pb-1">
                            <span class="label-text font-bold text-on-surface">Deskripsi Survei <span class="text-error">*</span></span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface h-28 leading-relaxed @error('description') border-error focus:border-error @enderror" placeholder="Jelaskan tujuan dan konteks dari survei ini secara singkat..." required>{{ old('description') }}</textarea>
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
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" min="{{ now()->toDateString() }}" onclick="this.showPicker && this.showPicker()" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface cursor-pointer @error('start_date') border-error focus:border-error @enderror" />
                            @error('start_date')
                                <label class="label pt-1 pb-0"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="form-control w-full">
                            <label class="label pb-1">
                                <span class="label-text font-bold text-on-surface">Tanggal Selesai</span>
                            </label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" min="{{ now()->toDateString() }}" onclick="this.showPicker && this.showPicker()" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface cursor-pointer @error('end_date') border-error focus:border-error @enderror" />
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
                                <option value="draf" {{ old('status', 'draf') == 'draf' ? 'selected' : '' }}>Draft (Belum Rilis)</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif (Publik)</option>
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
                    <!-- Dynamic Questions will be appended here -->
                </div>
                
                <div class="text-center mt-8">
                    <button type="button" id="add-question-btn" class="btn bg-primary hover:bg-primary-focus text-primary-content border-none rounded-xl shadow-sm no-animation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Pertanyaan
                    </button>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-5 lg:px-8 bg-surface-container-lowest/50 border-t border-outline-variant flex justify-end gap-3">
                <a href="{{ route('admin.surveys.index') }}" class="btn bg-surface hover:bg-surface-container-high border-outline-variant text-on-surface font-semibold no-animation shadow-none rounded-xl">Batal</a>
                <button type="submit" class="btn btn-primary no-animation shadow-sm rounded-xl">Simpan & Selesai</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (startDateInput.value) {
                endDateInput.min = startDateInput.value;
            }
        });
    }

    let questionCount = 0;
    const container = document.getElementById('questions-container');
    const addBtn = document.getElementById('add-question-btn');

    function updateQuestionNumbers() {
        const blocks = container.querySelectorAll('.question-block');
        blocks.forEach((block, index) => {
            const badge = block.querySelector('.question-number-badge');
            if(badge) badge.textContent = index + 1;
        });
    }

    addBtn.addEventListener('click', function() {
        const qIndex = questionCount++;
        const qHtml = `
            <div class="question-block p-5 border border-outline-variant rounded-xl bg-surface relative transition-all" data-index="${qIndex}">

                <button type="button" class="absolute top-4 right-4 btn btn-sm btn-circle btn-ghost text-rose-500 hover:bg-rose-50 hover:text-rose-600 no-animation btn-remove-question transition-colors" title="Hapus Pertanyaan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 shrink-0 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-bold text-sm question-number-badge">1</div>

                    <div class="flex-1 pt-1 space-y-4 pr-10">
                        <div class="form-control w-full">
                            <label class="label pb-1 pt-0"><span class="label-text font-bold text-on-surface text-[15px]">Teks Pertanyaan <span class="text-error">*</span></span></label>
                            <input type="text" name="questions[${qIndex}][question_text]" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary focus:ring-2 focus:ring-primary/20 text-on-surface text-base" placeholder="Ketik pertanyaan Anda di sini..." required>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 mt-2">
                            <div class="form-control w-full sm:w-72">
                                <label class="label pb-1 pt-0"><span class="label-text font-bold text-on-surface text-sm">Jenis Jawaban</span></label>
                                <select name="questions[${qIndex}][question_type]" class="select select-bordered rounded-xl w-full bg-surface-container-high border-primary/30 question-type-select font-medium text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="esai">Esai Bebas (Teks Panjang)</option>
                                    <option value="pilihan_ganda">Pilihan Ganda (Satu Jawaban)</option>
                                    <option value="skala_linear">Skala Linear (Rating 1–10)</option>
                                </select>
                            </div>
                            <div class="form-control pt-5">
                                <input type="hidden" name="questions[${qIndex}][is_required]" value="0">
                                <label class="cursor-pointer flex items-center gap-2.5 px-3 py-2 rounded-xl border transition-all w-fit select-none border-slate-200 bg-slate-100 text-slate-500 has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50 has-[:checked]:text-emerald-700">
                                    <input type="checkbox" name="questions[${qIndex}][is_required]" value="1" class="sr-only peer" checked />
                                    <div class="relative w-9 h-5 shrink-0 rounded-full transition-colors bg-slate-300 peer-checked:bg-emerald-400 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:w-4 after:h-4 after:rounded-full after:bg-white after:shadow after:transition-all peer-checked:after:translate-x-4"></div>
                                    <span class="text-sm font-bold">Wajib Diisi</span>
                                </label>
                            </div>
                        </div>

                        <!-- Options Container -->
                        <div class="options-container hidden mt-4 pt-5 border-t border-outline-variant/50">
                            <label class="label pb-3"><span class="label-text font-bold text-on-surface text-[15px]">Opsi Jawaban</span></label>
                            <div class="options-list grid grid-cols-1 sm:grid-cols-2 gap-3"></div>
                            <button type="button" class="btn btn-sm bg-surface-container hover:bg-surface-container-high border border-outline-variant/60 text-on-surface font-semibold mt-4 no-animation btn-add-option rounded-xl shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                Tambah Opsi Lainnya
                            </button>
                        </div>

                        <!-- Scale Container -->
                        <div class="scale-container hidden mt-4 pt-5 border-t border-outline-variant/50">
                            <label class="label pb-3"><span class="label-text font-bold text-on-surface text-[15px]">Konfigurasi Skala Linear</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label pb-1 pt-0"><span class="label-text text-sm font-semibold text-on-surface">Nilai Minimum</span></label>
                                    <select name="questions[${qIndex}][scale_min]" class="select select-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary scale-min-input text-on-surface font-medium">
                                        <option value="1" selected>1</option>
                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="label pb-1 pt-0"><span class="label-text text-sm font-semibold text-on-surface">Nilai Maksimum</span></label>
                                    <select name="questions[${qIndex}][scale_max]" class="select select-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary scale-max-input text-on-surface font-medium">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10" selected>10</option>
                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="label pb-1 pt-0"><span class="label-text text-sm font-semibold text-on-surface">Label Minimum <span class="font-normal text-on-surface-variant">(opsional)</span></span></label>
                                    <input type="text" name="questions[${qIndex}][scale_min_label]" placeholder="Contoh: Sangat Buruk" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary scale-min-label-input text-on-surface">
                                </div>
                                <div class="form-control">
                                    <label class="label pb-1 pt-0"><span class="label-text text-sm font-semibold text-on-surface">Label Maksimum <span class="font-normal text-on-surface-variant">(opsional)</span></span></label>
                                    <input type="text" name="questions[${qIndex}][scale_max_label]" placeholder="Contoh: Sangat Baik" class="input input-bordered rounded-xl w-full bg-surface-container-high border-primary/30 focus:border-primary scale-max-label-input text-on-surface">
                                </div>
                            </div>
                            <div class="mt-4 p-4 bg-surface-container rounded-xl border border-outline-variant/50">
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide mb-3">Pratinjau Skala</p>
                                <div class="flex items-center gap-3">
                                    <span class="flex-1 min-w-0 truncate text-xs text-on-surface-variant font-medium text-right scale-min-label-preview"></span>
                                    <div class="flex gap-1.5 shrink-0 scale-preview-numbers"></div>
                                    <span class="flex-1 min-w-0 truncate text-xs text-on-surface-variant font-medium scale-max-label-preview"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', qHtml);
        const newBlock = container.lastElementChild;
        updateQuestionNumbers();

        newBlock.querySelector('.btn-remove-question').addEventListener('click', function() {
            newBlock.style.opacity = '0';
            newBlock.style.transform = 'scale(0.98)';
            setTimeout(() => { newBlock.remove(); updateQuestionNumbers(); }, 200);
        });

        const typeSelect = newBlock.querySelector('.question-type-select');
        const optsContainer = newBlock.querySelector('.options-container');
        const optsList = newBlock.querySelector('.options-list');
        const scaleContainer = newBlock.querySelector('.scale-container');

        typeSelect.addEventListener('change', function() {
            if(this.value === 'pilihan_ganda') {
                optsContainer.classList.remove('hidden');
                scaleContainer.classList.add('hidden');
                if(optsList.children.length === 0) {
                    addOption(optsList, qIndex, 'Sangat Setuju');
                    addOption(optsList, qIndex, 'Tidak Setuju');
                }
            } else if(this.value === 'skala_linear') {
                optsContainer.classList.add('hidden');
                scaleContainer.classList.remove('hidden');
                updateScalePreview(newBlock);
            } else {
                optsContainer.classList.add('hidden');
                scaleContainer.classList.add('hidden');
            }
        });

        newBlock.querySelector('.btn-add-option').addEventListener('click', function() {
            addOption(optsList, qIndex, '');
        });

        ['.scale-min-input', '.scale-max-input', '.scale-min-label-input', '.scale-max-label-input'].forEach(sel => {
            const el = newBlock.querySelector(sel);
            if(el) el.addEventListener('input', () => updateScalePreview(newBlock));
        });
    });

    function updateScalePreview(block) {
        const min = parseInt(block.querySelector('.scale-min-input').value) || 1;
        const max = Math.min(parseInt(block.querySelector('.scale-max-input').value) || 10, min + 9);
        const preview = block.querySelector('.scale-preview-numbers');
        const minLabelEl = block.querySelector('.scale-min-label-preview');
        const maxLabelEl = block.querySelector('.scale-max-label-preview');
        if(!preview) return;
        preview.innerHTML = '';
        for(let i = min; i <= max; i++) {
            const div = document.createElement('div');
            div.className = 'w-10 h-10 rounded-full border-2 border-primary/30 text-primary font-bold flex items-center justify-center text-sm bg-primary/5';
            div.textContent = i;
            preview.appendChild(div);
        }
        const minLabel = block.querySelector('.scale-min-label-input').value;
        const maxLabel = block.querySelector('.scale-max-label-input').value;
        if(minLabelEl) minLabelEl.textContent = minLabel || '';
        if(maxLabelEl) maxLabelEl.textContent = maxLabel || '';
    }

    function updateOptionLetters(list) {
        list.querySelectorAll('.option-letter').forEach((badge, index) => {
            badge.textContent = String.fromCharCode(65 + index);
        });
    }

    function addOption(list, qIndex, defaultVal) {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-3 p-3 rounded-xl bg-surface border border-outline-variant/60 focus-within:border-primary focus-within:bg-primary/5 transition-all group relative pr-10 shadow-sm';
        div.innerHTML = `
            <div class="flex items-center justify-center w-7 h-7 shrink-0 rounded-lg bg-primary/20 text-primary font-bold text-xs option-letter">A</div>
            <input type="text" name="questions[${qIndex}][options][]" value="${defaultVal}" class="input input-sm w-full bg-transparent border-none px-0 focus:outline-none focus:ring-0 text-sm font-medium h-auto py-0" placeholder="Ketik opsi..." required>
            <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-xs btn-circle btn-ghost text-rose-400 hover:bg-rose-100 hover:text-rose-600 no-animation btn-remove-option transition-colors">
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

    addBtn.click();
});
</script>
@endpush
