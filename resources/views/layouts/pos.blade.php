<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')

</head>
<body class="font-sans antialiased">
    <div class="h-screen flex flex-col bg-gray-100">

        <!-- Header / Top Bar -->
        <header class="bg-white border-b border-gray-200 flex-shrink-0">
            {{-- Memanggil file header yang sudah kita buat --}}
            @include('layouts.partials.pos-header')
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-hidden">
            {{-- Konten dari komponen Livewire akan dimasukkan di sini --}}
            {{ $slot }}
        </main>

    </div>
</body>

</html>
