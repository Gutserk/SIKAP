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
                                Masuk ke akun Petugas
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
                                placeholder="admin@batam.go.id"
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
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                class="input input-bordered border-outline w-full rounded-lg  bg-surface-container text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/30 transition-all duration-200"
                                required
                            />
                        </div>

                        {{-- Login Button --}}
                        <button type="submit" class="btn bg-primary text-on-primary rounded-lg  border-none w-full font-semibold tracking-wide hover:brightness-110 active:scale-[0.98] transition-all duration-200">
                            Masuk
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
@endsection
