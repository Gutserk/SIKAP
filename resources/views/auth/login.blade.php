@extends('layouts.app')

@section('title', 'Login ')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-6 md:p-10">

    <div class="w-full max-w-sm md:max-w-4xl">
        {{-- Card --}}
        <div class="card bg-surface-container-high shadow-2xl overflow-hidden border border-outline-variant rounded-2xl">
            <div class="grid md:grid-cols-2">

                {{-- Form Section (Left) --}}
                <form method="POST" action="{{ route('login') }}" class="p-6 md:p-8">
                    @csrf
                    <div class="flex flex-col gap-6">

                        {{-- Header --}}
                        <div class="flex flex-col items-center gap-2 text-center">
                            <h1 class="text-2xl font-bold text-on-surface">Selamat Datang di SIKAP</h1>
                            <p class="text-on-surface-variant text-sm text-balance">
                                Masuk ke akun admin
                            </p>
                        </div>

                        {{-- Error Alert --}}
                        @if ($errors->any())
                            <div class="bg-error/10 text-error px-4 py-3 rounded-xl border border-error/20 text-sm">
                                <ul class="list-none space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Email Field --}}
                        <div class="form-control w-full">
                            <label class="label" for="email">
                                <span class="label-text font-medium text-on-surface">Email</span>
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="contoh@batam.go.id"
                                class="input input-bordered border-outline w-full rounded-xl bg-surface-container text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/30 transition-all duration-200"
                                required
                                autofocus
                            />
                        </div>

                        {{-- Password Field --}}
                        <div class="form-control w-full">
                            <label class="label" for="password">
                                <span class="label-text font-medium text-on-surface">Password</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="••••••••"
                                    class="input input-bordered border-outline w-full pr-10 rounded-lg  bg-surface-container text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/30 transition-all duration-200"
                                    required
                                />
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary transition-colors" data-toggle-password="#password" aria-label="Tampilkan/sembunyikan password">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Login Button --}}
                        <button type="submit" class="btn bg-primary text-on-primary rounded-lg  border-none w-full font-semibold tracking-wide hover:brightness-110 active:scale-[0.98] transition-all duration-200">
                            Login
                        </button>

                        {{-- Footer Info --}}
                        <p class="text-center text-xs text-on-surface-variant mt-12">
                            &copy; {{ date('Y') }} Diskominfo Kota Batam. All rights reserved.
                        </p>

                    </div>
                </form>

                {{-- Image Section (Right) --}}
                <div class="relative hidden md:block bg-surface-container">
                    <img
                        src="{{ asset('images/login-illustration.png') }}"
                        alt="Ilustrasi Survei Digital"
                        class="absolute inset-0 h-full w-full object-cover"
                    />
                    {{-- Overlay gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/30 to-transparent"></div>
                </div>

            </div>
        </div>
    </div>

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
