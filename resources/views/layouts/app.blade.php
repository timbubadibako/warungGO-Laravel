<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest"></script>

        @stack('scripts')
    </head>
    <body class="font-sans antialiased">
        <div class="h-screen flex bg-white">

            <!-- Memanggil Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Konten Utama -->
            <div class="flex-1 flex flex-col overflow-hidden w-full">
                <!-- Area Konten Halaman (Slot) -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto">
                    <div class="container mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
