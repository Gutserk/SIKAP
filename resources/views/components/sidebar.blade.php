<div class="drawer-side z-50">
    <label for="admin-drawer" class="drawer-overlay"></label>
    <aside class="flex flex-col h-full min-h-screen w-64 bg-surface-container-high border-r border-outline-variant text-on-surface overflow-y-auto">
        
        <!-- Branding -->
        <div class="h-20 w-full flex items-center gap-3 px-5 border-b border-outline-variant shrink-0">
            <div class="w-12 h-12 bg-primary text-on-primary rounded-xl flex items-center justify-center font-bold text-2xl shadow-sm shrink-0">
                S
            </div>
            <div class="leading-tight">
                <div class="font-bold text-lg text-primary tracking-tight">SIKAP</div>
                <div class="font-medium text-xs text-on-surface-variant">Diskominfo Batam</div>
            </div>
        </div>

        <!-- Menus -->
        <ul class="menu p-4 w-full text-on-surface-variant font-medium space-y-2 mt-2 grow">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-on-primary font-semibold shadow-md hover:bg-primary/90' : 'hover:bg-surface-container hover:text-on-surface transition-colors' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.surveys.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl {{ request()->routeIs('admin.surveys.*') ? 'bg-primary text-on-primary font-semibold shadow-md hover:bg-primary/90' : 'hover:bg-surface-container hover:text-on-surface transition-colors' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Kelola Survei
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.admins.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl {{ request()->routeIs('admin.admins.*') ? 'bg-primary text-on-primary font-semibold shadow-md hover:bg-primary/90' : 'hover:bg-surface-container hover:text-on-surface transition-colors' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Manajemen Admin
                </a>
            </li>

            <!-- Logout Link -->
            <li class="mt-4 border-t border-outline-variant pt-4">
                <label for="logout-modal" class="flex items-center gap-3 px-4 py-2 rounded-xl text-error hover:bg-error/10 cursor-pointer transition-colors font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Logout
                </label>
            </li>
        </ul>

    </aside>
</div>
