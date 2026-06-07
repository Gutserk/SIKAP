@extends('layouts.app')

@section('content')
<div class="drawer lg:drawer-open h-full">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
    
    <!-- Main Content Area -->
    <div class="drawer-content flex flex-col">
        
        <!-- Navbar / Topbar -->
        <x-navbar />
        
        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto bg-surface">
            @yield('admin_content')
        </main>
        
    </div> 
    
    <!-- Sidebar / Drawer Side -->
    <x-sidebar />
</div>

<!-- Logout Modal -->
<input type="checkbox" id="logout-modal" class="modal-toggle" />
<label for="logout-modal" class="modal cursor-pointer backdrop-blur-sm transition-all duration-300">
    <label class="modal-box relative bg-surface-container-high border border-outline-variant rounded-2xl shadow-xl max-w-sm text-center" for="">
        <div class="w-16 h-16 mx-auto bg-error/10 text-error rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2">Anda yakin ingin keluar?</h3>
        <p class="text-sm text-on-surface-variant mb-6">Anda harus login kembali untuk mengakses panel admin.</p>
        <div class="flex justify-center gap-3">
            <label for="logout-modal" class="btn bg-slate-100 hover:bg-slate-200 text-slate-700 border-none shadow-none px-6 rounded-xl cursor-pointer transition-colors">Batal</label>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-6 border-none shadow-none transition-colors">Keluar</button>
            </form>
        </div>
    </label>
</label>
@endsection
