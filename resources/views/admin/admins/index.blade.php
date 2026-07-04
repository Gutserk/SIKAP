@extends('layouts.admin')

@section('header_title', 'Manajemen Admin -')

@section('admin_content')
<div class="flex flex-col gap-6">

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-xl border-none text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error shadow-sm rounded-xl border-none text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-on-surface">Daftar Admin</h2>
            <p class="text-sm text-on-surface-variant mt-1">Kelola staf yang memiliki akses ke portal ini.</p>
        </div>
        
        <!-- Tombol untuk memicu Modal -->
        <label for="modal-add-admin" class="btn btn-primary text-on-primary rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah
        </label>
    </div>

    <!-- Main Card -->
    <div class="bg-surface-container-high rounded-2xl shadow-sm border border-outline-variant overflow-hidden">
        
        <form method="GET" action="{{ route('admin.admins.index') }}" class="p-4 lg:p-5 border-b border-outline-variant bg-surface-container-high flex flex-col sm:flex-row gap-4 items-center justify-start">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-on-surface-variant" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" id="search-admins" value="{{ request('search') }}" class="input input-sm h-10 w-full pl-10 {{ request('search') ? 'pr-9' : '' }} rounded-xl bg-surface-container border-none focus:ring-2 focus:ring-primary text-on-surface" placeholder="Cari nama atau email...">
                @if(request('search'))
                <button type="button" onclick="document.getElementById('search-admins').value=''; this.closest('form').submit();" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-error transition-colors" aria-label="Hapus pencarian">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                @endif
            </div>
            <div class="dropdown w-full sm:w-auto">
                <label tabindex="0" class="btn btn-sm h-10 w-full sm:w-48 rounded-xl bg-surface-container border-none text-on-surface hover:bg-primary/10 hover:text-primary font-normal justify-between shadow-none flex items-center no-animation focus:outline-none transition-colors">
                    <span class="truncate">
                        @if(request('sort') == 'oldest') Terlama Ditambahkan
                        @elseif(request('sort') == 'name_asc') Nama (A-Z)
                        @else Terbaru Ditambahkan
                        @endif
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </label>
                <ul tabindex="0" class="dropdown-content z-[20] menu p-2 shadow-lg bg-surface-container-high rounded-xl w-52 border border-outline-variant text-sm mt-1">
                    <li><button type="submit" name="sort" value="newest" class="{{ request('sort', 'newest') == 'newest' ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface hover:bg-primary/5 hover:text-primary transition-colors' }}">Terbaru Ditambahkan</button></li>
                    <li><button type="submit" name="sort" value="oldest" class="{{ request('sort') == 'oldest' ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface hover:bg-primary/5 hover:text-primary transition-colors' }}">Terlama Ditambahkan</button></li>
                    <li><button type="submit" name="sort" value="name_asc" class="{{ request('sort') == 'name_asc' ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface hover:bg-primary/5 hover:text-primary transition-colors' }}">Nama (A-Z)</button></li>
                </ul>
            </div>
            <button type="submit" class="hidden"></button>
        </form>

        <!-- Mobile Card View -->
        <div class="divide-y divide-outline-variant/40 sm:hidden">
            @forelse($admins as $index => $admin)
            <div class="p-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 border border-primary/20">
                    {{ strtoupper(substr($admin->nama_lengkap, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5 min-w-0">
                            <span class="font-semibold text-on-surface truncate">{{ $admin->nama_lengkap }}</span>
                            @if(auth('admin')->id() === $admin->id)
                                <span class="badge badge-primary badge-sm text-[10px] shrink-0">Anda</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <label for="modal-edit-admin-{{ $admin->id }}" class="btn btn-sm btn-ghost text-blue-600 hover:bg-blue-50 cursor-pointer p-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </label>
                            @if(auth('admin')->id() !== $admin->id)
                            <label for="modal-delete-admin-{{ $admin->id }}" class="btn btn-sm btn-ghost text-rose-600 hover:bg-rose-50 cursor-pointer p-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </label>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-0.5 truncate">{{ $admin->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="badge badge-outline border-outline-variant text-on-surface-variant font-medium text-xs">Administrator</div>
                        <span class="text-xs text-on-surface-variant">{{ $admin->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-10 text-center text-on-surface-variant">
                <p class="font-medium">Belum ada admin lain.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="overflow-x-auto w-full hidden sm:block">
            <table class="table w-full text-left">
                <!-- head -->
                <thead class="bg-surface text-on-surface-variant text-sm border-b border-outline-variant">
                    <tr>
                        <th class="py-4 font-semibold w-12 text-center">No</th>
                        <th class="py-4 font-semibold">Nama Lengkap</th>
                        <th class="py-4 font-semibold">Email</th>
                        <th class="py-4 font-semibold">Role</th>
                        <th class="py-4 font-semibold">Tanggal Bergabung</th>
                        <th class="py-4 font-semibold text-right pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-on-surface">
                    @forelse($admins as $index => $admin)
                    <tr class="hover:bg-surface-container/50 border-b border-outline-variant transition-colors group">
                        <td class="text-center text-on-surface-variant">{{ $admins->firstItem() + $index }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <span class="text-on-surface-variant group-hover:text-primary transition-colors">{{ $admin->nama_lengkap }}</span>
                                @if(auth('admin')->id() === $admin->id)
                                    <span class="badge badge-primary badge-sm text-[10px] ml-2">Anda</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="text-on-surface-variant">{{ $admin->email }}</span>
                        </td>
                        <td>
                            <div class="badge badge-outline border-outline-variant text-on-surface-variant font-medium">Administrator</div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $admin->created_at->translatedFormat('d M Y') }}
                            </div>
                        </td>
                        <td class="text-right pr-6">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Edit Button -->
                                <label for="modal-edit-admin-{{ $admin->id }}" class="btn btn-sm btn-square btn-ghost shadow-none hover:shadow-none text-blue-600 hover:bg-blue-50 tooltip tooltip-left cursor-pointer" data-tip="Edit Profil">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </label>

                                <!-- Delete Button -->
                                @if(auth('admin')->id() !== $admin->id)
                                <label for="modal-delete-admin-{{ $admin->id }}" class="btn btn-sm btn-square btn-ghost shadow-none hover:shadow-none text-rose-600 hover:bg-rose-50 tooltip tooltip-left cursor-pointer" data-tip="Hapus Admin">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </label>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit Admin -->
                    <input type="checkbox" id="modal-edit-admin-{{ $admin->id }}" class="modal-toggle" @if($errors->any() && old('admin_id') == $admin->id) checked @endif />
                    <div class="modal backdrop-blur-sm transition-all duration-300" role="dialog">
                        <div class="modal-box bg-surface-container-high border border-outline-variant rounded-2xl shadow-xl max-w-md text-left whitespace-normal">
                            <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                                <!-- Header -->
                                <div class="flex justify-between items-center border-b border-outline-variant pb-4 mb-4">
                                    <h3 class="font-bold text-xl text-on-surface flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </div>
                                        Edit Profil Admin
                                    </h3>
                                    <label for="modal-edit-admin-{{ $admin->id }}" class="btn btn-sm btn-circle btn-ghost text-on-surface-variant hover:bg-error/10 hover:text-error transition-colors">✕</label>
                                </div>
                                
                                <!-- Body -->
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <label class="label py-1"><span class="label-text font-semibold text-on-surface">Nama Lengkap</span></label>
                                        <input type="text" name="full_name" value="{{ old('admin_id') == $admin->id ? old('full_name') : $admin->nama_lengkap }}" class="input input-bordered w-full rounded-xl bg-surface focus:border-primary text-on-surface {{ (old('admin_id') == $admin->id && $errors->has('full_name')) ? 'border-error focus:border-error' : '' }}">
                                        @if(old('admin_id') == $admin->id)
                                            @error('full_name')
                                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label class="label py-1"><span class="label-text font-semibold text-on-surface">Email</span></label>
                                        <input type="email" name="email" value="{{ old('admin_id') == $admin->id ? old('email') : $admin->email }}" class="input input-bordered w-full rounded-xl bg-surface focus:border-primary text-on-surface {{ (old('admin_id') == $admin->id && $errors->has('email')) ? 'border-error focus:border-error' : '' }}">
                                        @if(old('admin_id') == $admin->id)
                                            @error('email')
                                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label class="label py-1"><span class="label-text font-semibold text-on-surface">Password Baru</span></label>
                                        <div class="relative">
                                            <input type="password" id="edit-password-{{ $admin->id }}" name="password" placeholder="Min. 8 karakter, huruf besar, kecil, angka & simbol" class="input input-bordered w-full pr-10 rounded-xl bg-surface focus:border-primary text-on-surface {{ (old('admin_id') == $admin->id && $errors->has('password')) ? 'border-error focus:border-error' : '' }}">
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary transition-colors" data-toggle-password="#edit-password-{{ $admin->id }}" aria-label="Tampilkan/sembunyikan password">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                            </button>
                                        </div>
                                        @if(old('admin_id') == $admin->id)
                                            @error('password')
                                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label class="label py-1"><span class="label-text font-semibold text-on-surface">Konfirmasi Password Baru</span></label>
                                        <div class="relative">
                                            <input type="password" id="edit-password-confirmation-{{ $admin->id }}" name="password_confirmation" placeholder="Opsional (isi jika mengubah password)" class="input input-bordered w-full pr-10 rounded-xl bg-surface focus:border-primary text-on-surface {{ (old('admin_id') == $admin->id && $errors->has('password_confirmation')) ? 'border-error focus:border-error' : '' }}">
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary transition-colors" data-toggle-password="#edit-password-confirmation-{{ $admin->id }}" aria-label="Tampilkan/sembunyikan password">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                            </button>
                                        </div>
                                        @if(old('admin_id') == $admin->id)
                                            @error('password_confirmation')
                                                <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Footer -->
                                <div class="modal-action mt-6 pt-4 border-t border-outline-variant">
                                    <label for="modal-edit-admin-{{ $admin->id }}" class="btn bg-slate-100 hover:bg-slate-200 text-slate-700 border-none shadow-none px-6 rounded-xl cursor-pointer transition-colors">Batal</label>
                                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-8 shadow-md transition-all border-none">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                        <label class="modal-backdrop" for="modal-edit-admin-{{ $admin->id }}">Close</label>
                    </div>
                    
                    <!-- Modal Konfirmasi Hapus -->
                    <input type="checkbox" id="modal-delete-admin-{{ $admin->id }}" class="modal-toggle" />
                    <label for="modal-delete-admin-{{ $admin->id }}" class="modal cursor-pointer backdrop-blur-sm transition-all duration-300">
                        <label class="modal-box relative bg-surface-container-high border border-outline-variant rounded-2xl shadow-xl max-w-sm text-center" for="">
                            <div class="w-16 h-16 mx-auto bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-on-surface mb-2">Konfirmasi Hapus</h3>
                            <p class="text-sm text-on-surface-variant mb-6 whitespace-normal">Apakah Anda yakin ingin menghapus <strong>{{ $admin->nama_lengkap }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="flex justify-center gap-6">
                                @csrf
                                @method('DELETE')
                                <label for="modal-delete-admin-{{ $admin->id }}" class="btn bg-slate-100 hover:bg-slate-200 text-slate-700 border-none shadow-none px-8 rounded-xl cursor-pointer transition-colors">Batal</label>
                                <button type="submit" class="btn bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-8 border-none shadow-none transition-colors">Hapus</button>
                            </form>
                        </label>
                    </label>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">
                            <div class="flex justify-center mb-4 text-on-surface-variant/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <h3 class="text-lg font-bold text-on-surface mb-1">Belum Ada Admin Lain</h3>
                            <p class="text-sm text-on-surface-variant">Klik "Tambah" untuk memberikan akses kepada staf lainnya.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 lg:p-5 border-t border-outline-variant bg-surface-container-high">
            {{ $admins->links('vendor.pagination.custom') }}
        </div>
    </div>

</div>

<!-- Modal Tambah Admin Menggunakan Checkbox (Murni HTML/CSS) -->
<input type="checkbox" id="modal-add-admin" class="modal-toggle" @if($errors->any() && !old('admin_id')) checked @endif />
<div class="modal backdrop-blur-sm transition-all duration-300" role="dialog">
    <div class="modal-box bg-surface-container-high border border-outline-variant rounded-2xl shadow-xl max-w-md">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            
            <!-- Header Modal -->
            <div class="flex justify-between items-center border-b border-outline-variant pb-4 mb-4">
                <h3 class="font-bold text-xl text-on-surface flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </div>
                    Tambah Admin
                </h3>
                <label for="modal-add-admin" class="btn btn-sm btn-circle btn-ghost text-on-surface-variant hover:bg-error/10 hover:text-error transition-colors">✕</label>
            </div>
            
            <!-- Body Modal (Form) -->
            <div class="flex flex-col gap-4">
                <!-- Nama Lengkap -->
                <div>
                    <label class="label py-1"><span class="label-text font-semibold text-on-surface">Nama Lengkap</span></label>
                    <input type="text" name="full_name" value="{{ !old('admin_id') ? old('full_name') : '' }}" placeholder="Masukkan nama..." class="input input-bordered w-full rounded-xl bg-surface focus:border-primary text-on-surface {{ (!old('admin_id') && $errors->has('full_name')) ? 'border-error focus:border-error' : '' }}">
                    @if(!old('admin_id'))
                        @error('full_name')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <!-- Email -->
                <div>
                    <label class="label py-1"><span class="label-text font-semibold text-on-surface">Email</span></label>
                    <input type="text" name="email" value="{{ !old('admin_id') ? old('email') : '' }}" placeholder="contoh@batam.go.id" class="input input-bordered w-full rounded-xl bg-surface focus:border-primary text-on-surface {{ (!old('admin_id') && $errors->has('email')) ? 'border-error focus:border-error' : '' }}">
                    @if(!old('admin_id'))
                        @error('email')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <!-- Password -->
                <div>
                    <label class="label py-1"><span class="label-text font-semibold text-on-surface">Password</span></label>
                    <div class="relative">
                        <input type="password" id="create-password" name="password" placeholder="Min. 8 karakter, huruf besar, kecil, angka & simbol" class="input input-bordered w-full pr-10 rounded-xl bg-surface focus:border-primary text-on-surface {{ (!old('admin_id') && $errors->has('password')) ? 'border-error focus:border-error' : '' }}">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary transition-colors" data-toggle-password="#create-password" aria-label="Tampilkan/sembunyikan password">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @if(!old('admin_id'))
                        @error('password')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="label py-1"><span class="label-text font-semibold text-on-surface">Konfirmasi Password</span></label>
                    <div class="relative">
                        <input type="password" id="create-password-confirmation" name="password_confirmation" placeholder="Ulangi password" class="input input-bordered w-full pr-10 rounded-xl bg-surface focus:border-primary text-on-surface {{ (!old('admin_id') && $errors->has('password_confirmation')) ? 'border-error focus:border-error' : '' }}">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary transition-colors" data-toggle-password="#create-password-confirmation" aria-label="Tampilkan/sembunyikan password">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @if(!old('admin_id'))
                        @error('password_confirmation')
                            <span class="text-error text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <!-- Info Keamanan -->
                <div class="bg-primary/10 text-primary p-3 rounded-xl text-sm flex items-start gap-3 mt-2 border border-primary/20 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p>Admin baru akan memiliki hak akses penuh ke seluruh fitur, termasuk membuat dan menghapus survei dari sistem.</p>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="modal-action mt-6 pt-4 border-t border-outline-variant">
                <label for="modal-add-admin" class="btn bg-slate-100 hover:bg-slate-200 text-slate-700 border-none shadow-none px-6 rounded-xl cursor-pointer transition-colors">Batal</label>
                <button type="submit" class="btn btn-primary text-on-primary rounded-xl px-8 shadow-md hover:shadow-lg transition-all">Simpan Admin</button>
            </div>
        </form>
    </div>
    
    <!-- Background overlay klik luar untuk menutup -->
    <label class="modal-backdrop" for="modal-add-admin">Close</label>
</div>

@push('scripts')
<script>
    document.querySelectorAll('[data-toggle-password]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(btn.dataset.togglePassword);
            const showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            btn.querySelectorAll('svg').forEach(svg => svg.classList.toggle('hidden'));
        });
    });
</script>
@endpush

@endsection
