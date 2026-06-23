<nav class="navbar bg-surface-container-high border-b border-outline-variant px-4 lg:px-12 py-3 sticky top-0 z-50">
    <div class="flex-1">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <!-- Logo Dummy -->
            <div class="w-10 h-10 bg-primary text-on-primary rounded-xl flex items-center justify-center font-bold text-xl shadow-sm">
                S
            </div>
            <div>
                <h1 class="font-bold text-xl leading-tight text-primary">SIKAP</h1>
                <p class="text-[10px] uppercase tracking-wider text-on-surface-variant font-semibold">Diskominfo Kota Batam</p>
            </div>
        </a>
    </div>
    <div class="flex-none gap-2 hidden md:flex items-center">
        <ul class="menu menu-horizontal px-1 font-medium text-on-surface-variant [&_a:active]:!bg-primary/20 [&_a:active]:!text-primary [&_a:focus]:!bg-primary/10 [&_a:focus]:!text-primary">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-primary bg-primary/10' : 'hover:text-primary' }}">Beranda</a></li>
            <li><a href="{{ route('surveys.index') }}" class="{{ request()->routeIs('surveys.*') ? 'text-primary bg-primary/10' : 'hover:text-primary' }}">Daftar Survei</a></li>
        </ul>
        <div class="divider divider-horizontal mx-1"></div>
        @auth('admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline border-primary text-primary hover:bg-primary hover:text-on-primary rounded-xl btn-sm">Dashboard Admin</a>
        @else
            <a href="{{ route('login') }}" class="btn bg-surface border border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary shadow-sm rounded-xl btn-sm px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                Login Admin
            </a>
        @endauth
    </div>
    
    <!-- Mobile Menu Toggle -->
    <div class="flex-none md:hidden dropdown dropdown-end">
        <label tabindex="0" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </label>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-surface-container-high rounded-box w-52 border border-outline-variant [&_a:active]:!bg-primary/20 [&_a:active]:!text-primary [&_a:focus]:!bg-primary/10 [&_a:focus]:!text-primary">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('surveys.index') }}">Daftar Survei</a></li>
            <li class="menu-title">Admin</li>
            @auth('admin')
                <li><a href="{{ route('admin.dashboard') }}" class="text-primary">Dashboard Admin</a></li>
            @else
                <li><a href="{{ route('login') }}">Login Admin</a></li>
            @endauth
        </ul>
    </div>
</nav>
