<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Aplikasi Survei Diskominfo Kota Batam')">
    <title>@yield('title')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Global Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</head>
<body class="bg-surface text-on-surface min-h-screen antialiased font-sans">
    
    <!-- Konten halaman akan dirender di sini -->
    @yield('content')

    @stack('scripts')
</body>
</html>
