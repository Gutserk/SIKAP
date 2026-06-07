@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen">
    
    <!-- Navbar Publik (Component) -->
    <x-public-navbar />

    <!-- Konten Utama -->
    <main class="flex-grow flex flex-col">
        @yield('public_content')
    </main>

    <!-- Footer Publik (Component) -->
    <x-public-footer />

</div>
@endsection
