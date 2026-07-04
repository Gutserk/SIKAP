@extends('layouts.admin')

@section('header_title', 'Kelola Survei')

@section('admin_content')
<div class="flex flex-col gap-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Daftar Survei</h2>
            <p class="text-sm text-on-surface-variant mt-1">Kelola semua survei yang ada di dalam sistem.</p>
        </div>
        <a href="{{ route('admin.surveys.create') }}" class="btn btn-primary text-on-primary rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Survei Baru
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-surface-container-high rounded-2xl shadow-sm border border-outline-variant overflow-hidden">
        
        <!-- Toolbar (Search & Filter) -->
        <form method="GET" action="{{ route('admin.surveys.index') }}" class="p-4 lg:p-5 border-b border-outline-variant bg-surface-container-high flex flex-col sm:flex-row gap-4 items-center justify-start">
            <input type="hidden" name="status" id="status-hidden" value="{{ request('status', 'Semua Status') }}">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-on-surface-variant" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" id="search-surveys" value="{{ request('search') }}" class="input input-sm h-10 w-full pl-10 {{ request('search') ? 'pr-9' : '' }} rounded-xl bg-surface-container border-none focus:ring-2 focus:ring-primary text-on-surface" placeholder="Cari judul survei...">
                @if(request('search'))
                <button type="button" onclick="document.getElementById('search-surveys').value=''; this.closest('form').submit();" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-error transition-colors" aria-label="Hapus pencarian">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                @endif
            </div>
            
            <div class="w-full sm:w-auto flex overflow-x-auto pb-2 sm:pb-0 hide-scrollbar">
                <div class="flex gap-1 bg-surface-container p-1 rounded-xl shrink-0">
                    <button type="button" onclick="document.getElementById('status-hidden').value='Semua Status'; this.form.submit();" class="btn btn-sm rounded-lg border-none shadow-none no-animation focus:outline-none {{ request('status', 'Semua Status') == 'Semua Status' ? 'bg-white text-on-surface hover:bg-white font-bold' : 'bg-transparent text-on-surface-variant hover:bg-surface-container-high font-normal' }}">Semua</button>
                    <button type="button" onclick="document.getElementById('status-hidden').value='Aktif'; this.form.submit();" class="btn btn-sm rounded-lg border-none shadow-none no-animation focus:outline-none {{ request('status') == 'Aktif' ? 'bg-white text-on-surface hover:bg-white font-bold' : 'bg-transparent text-on-surface-variant hover:bg-surface-container-high font-normal' }}">Aktif</button>
                    <button type="button" onclick="document.getElementById('status-hidden').value='Draft'; this.form.submit();" class="btn btn-sm rounded-lg border-none shadow-none no-animation focus:outline-none {{ request('status') == 'Draft' ? 'bg-white text-on-surface hover:bg-white font-bold' : 'bg-transparent text-on-surface-variant hover:bg-surface-container-high font-normal' }}">Draft</button>
                    <button type="button" onclick="document.getElementById('status-hidden').value='Ditutup'; this.form.submit();" class="btn btn-sm rounded-lg border-none shadow-none no-animation focus:outline-none {{ request('status') == 'Ditutup' ? 'bg-white text-on-surface hover:bg-white font-bold' : 'bg-transparent text-on-surface-variant hover:bg-surface-container-high font-normal' }}">Ditutup</button>
                </div>
            </div>
            <button type="submit" class="hidden"></button>
        </form>

        <!-- Cards Container -->
        <div class="p-4 lg:p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($surveys as $index => $survey)
            <!-- Card Item -->
            <div class="bg-surface border border-outline-variant rounded-2xl p-5 hover:border-primary/50 hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative flex flex-col group">
                
                <!-- 3 Dots Menu (Dropdown) -->
                <div class="absolute top-4 right-4 z-20">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-sm btn-ghost btn-circle shadow-none text-on-surface-variant hover:bg-surface-container hover:shadow-none border-none relative z-30 no-animation">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                        </label>
                        <ul tabindex="0" class="dropdown-content z-[40] menu p-2 shadow-lg bg-surface-container-high rounded-xl w-44 border border-outline-variant text-sm mt-1">
                            <li>
                                <a href="{{ route('admin.surveys.edit', $survey->id) }}" class="hover:bg-blue-50 text-blue-600 rounded-lg font-medium shadow-none hover:shadow-none relative z-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    Edit Survei
                                </a>
                            </li>
                            <li>
                                <label for="modal-delete-survey-{{ $survey->id }}" class="hover:bg-rose-50 text-rose-600 rounded-lg font-medium shadow-none hover:shadow-none cursor-pointer relative z-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus Survei
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card Content (Clickable Area) -->
                <a href="{{ route('admin.surveys.show', $survey->id) }}" class="pr-8 grow block focus:outline-none before:absolute before:inset-0 before:z-10 before:rounded-2xl group-hover:text-primary transition-colors">
                    <!-- Status Badge -->
                    @if($survey->status == 'aktif')
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </div>
                    @elseif($survey->status == 'draf')
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-100 text-amber-800 text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Draft
                        </div>
                    @else
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-100 text-rose-800 text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            Ditutup
                        </div>
                    @endif

                    <h3 class="font-bold text-lg text-on-surface mt-3 line-clamp-1 group-hover:text-primary transition-colors" title="{{ $survey->judul }}">{{ $survey->judul }}</h3>
                    <p class="text-sm text-on-surface-variant mt-1.5 line-clamp-2 leading-relaxed">{{ $survey->deskripsi }}</p>
                </a>

                <!-- Card Footer (Date & Respondents) -->
                <div class="mt-5 pt-4 border-t border-outline-variant flex items-center justify-between text-xs text-on-surface-variant">
                    <div class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span>{{ \Carbon\Carbon::parse($survey->tanggal_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($survey->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-1 font-semibold text-primary bg-primary/10 px-2 py-1 rounded-md tooltip tooltip-top" data-tip="Total Responden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <span>{{ number_format($survey->respondents_count, 0, ',', '.') }}</span>
                    </div>
                </div>
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
            @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center text-on-surface-variant border-2 border-dashed border-outline-variant rounded-2xl bg-surface/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <p class="text-lg font-medium">Belum ada survei</p>
                <p class="text-sm mt-1">Klik tombol "Buat Survei Baru" untuk memulai.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center w-full">
            <div class="w-full bg-surface border border-outline-variant rounded-2xl p-4 shadow-sm">
                {{ $surveys->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>

@endsection
