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

        <style>
            /* Floating Animation untuk ornamen */
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(2deg); }
            }

            @keyframes floatSlow {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(-2deg); }
            }

            @keyframes floatFast {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-8px) rotate(1deg); }
            }

            /* Pulse animation untuk logo */
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.3); }
                50% { box-shadow: 0 0 30px rgba(255, 255, 255, 0.5), 0 0 40px rgba(255, 255, 255, 0.2); }
            }

            /* Gradient shift animation */
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .floating-1 { animation: float 3s ease-in-out infinite; }
            .floating-2 { animation: floatSlow 4s ease-in-out infinite 0.5s; }
            .floating-3 { animation: floatFast 2.5s ease-in-out infinite 1s; }
            .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
            .gradient-shift {
                background: linear-gradient(-45deg, #10b981, #3b82f6, #8b5cf6, #06b6d4);
                background-size: 400% 400%;
                animation: gradientShift 8s ease infinite;
            }

            /* Hover effects */
            .feature-item {
                transition: all 0.3s ease;
            }
            .feature-item:hover {
                transform: translateX(5px);
            }
            .feature-item:hover .feature-icon {
                transform: scale(1.1) rotate(5deg);
                background: linear-gradient(135deg, #10b981, #06b6d4);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-green-400 via-blue-500 to-purple-600 min-h-screen overflow-hidden">
        {{-- Container utama full screen --}}
        <div class="relative min-h-screen flex">

            {{-- Background Section - Kiri (60% width) --}}
            <div class="w-3/5 relative gradient-shift flex items-center justify-center overflow-hidden">
                {{-- Background Pattern/Decoration --}}
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="absolute top-10 left-10 w-32 h-32 bg-white bg-opacity-10 rounded-full floating-1"></div>
                <div class="absolute bottom-20 right-20 w-24 h-24 bg-white bg-opacity-20 rounded-full floating-2"></div>
                <div class="absolute top-1/2 left-20 w-16 h-16 bg-white bg-opacity-15 rounded-full floating-3"></div>

                {{-- Main Illustration/Content --}}
                <div class="relative z-10 text-center text-white px-12">
                    {{-- Logo Warung GO --}}
                    <div class="mx-auto w-24 h-24 bg-white bg-opacity-20 backdrop-blur-sm rounded-3xl flex items-center justify-center mb-6 shadow-lg pulse-glow hover:scale-105 transition-transform duration-300">
                        <svg class="w-12 h-12 text-white transition-transform duration-300 hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0L17 18M9.5 18H17m0 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>

                    {{-- Hero Text --}}
                    <h1 class="text-5xl font-bold mb-4 leading-tight hover:scale-105 transition-transform duration-300">
                        Warung<span class="text-yellow-300 hover:text-yellow-200 transition-colors duration-300">GO</span>
                    </h1>
                    <p class="text-xl text-blue-100 mb-8 max-w-md hover:text-white transition-colors duration-300">
                        Sistem Point of Sales modern untuk mengelola warung Anda dengan mudah dan efisien
                    </p>

                    {{-- Features List --}}
                    <div class="grid grid-cols-1 gap-4 max-w-sm mx-auto text-left">
                        <div class="flex items-center space-x-3 feature-item">
                            <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center feature-icon transition-all duration-300">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-blue-100">Manajemen Inventory</span>
                        </div>
                        <div class="flex items-center space-x-3 feature-item">
                            <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center feature-icon transition-all duration-300">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-blue-100">Laporan Keuangan</span>
                        </div>
                        <div class="flex items-center space-x-3 feature-item">
                            <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center feature-icon transition-all duration-300">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-blue-100">Multi Payment Gateway</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Section - Kanan (40% width) --}}
            <div class="w-2/5 bg-white flex items-center justify-center relative">
                {{-- Background decoration untuk form area --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-green-100 opacity-50 rounded-bl-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-green-100 to-blue-100 opacity-50 rounded-tr-full"></div>

                {{-- Form Container --}}
                <div class="w-full max-w-md px-8 relative z-10">
                    {{-- Slot untuk konten form (login.blade.php) --}}
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
