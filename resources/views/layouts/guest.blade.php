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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-200 overflow-hidden">
        {{-- Kontainer utama dengan margin di sekelilingnya --}}
        <div class="absolute inset-8 rounded-3xl shadow-lg overflow-hidden">

            {{-- Div dengan gambar latar yang mengisi kontainer utama --}}
            <div
                class="h-full w-full flex items-center justify-end bg-cover bg-center"
                style="background-image: url('https://placehold.co/1920x1080/a3e635/44403c?text=WarungGo+Background');"
            >
                {{-- Card Form di sisi kanan dengan ukuran yang disesuaikan --}}
                <div class="w-1/3 min-h-[90vh] bg-white rounded-2xl shadow-2xl p-12 mr-8 flex flex-col justify-center">

                    {{-- Logo Aplikasi --}}
                    <div class="w-xl mx-40 my-40">
                        <div class="text-center mb-8">
                            <a href="/">
                                <x-application-logo class="w-20 h-20 fill-current text-gray-500 mx-auto" />
                            </a>
                        </div>

                        {{-- Slot untuk konten form (login.blade.php) --}}
                        {{ $slot }}
                    </div>
                </div>

            </div>

        </div>
    </body>
</html>
