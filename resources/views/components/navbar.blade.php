<header class="navbar h-20 bg-surface-container-high border-b border-outline-variant text-on-surface shadow-sm z-10 px-4 lg:px-6">
    <div class="flex-none lg:hidden">
        <label for="admin-drawer" class="btn btn-ghost p-2 rounded-xl text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>
    </div>
    <div class="flex-1">
    </div>
    <div class="flex items-center gap-3">
        <div class="leading-tight text-right hidden sm:block">
            <div class="font-semibold text-sm truncate max-w-40">
                {{ auth('admin')->user()->name ?? 'Admin Diskominfo' }}
            </div>
            <div class="text-xs text-on-surface-variant truncate max-w-40">
                {{ auth('admin')->user()->email ?? 'admin@batam.go.id' }}
            </div>
        </div>
        <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-lg shadow-sm">
                {{ substr(auth('admin')->user()->name ?? 'A', 0, 1) }}
            </div>
        </div>
    </div>
</header>
