<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Warung GO POS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

        <!-- Alpine.js -->
        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Smooth page transitions */
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Gradient backgrounds */
            .bg-gradient-warung {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            }

            .bg-gradient-sidebar {
                background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            }

            /* Card animations */
            .animate-slide-in-right {
                animation: slideInRight 0.6s ease-out;
            }

            .animate-slide-in-left {
                animation: slideInLeft 0.6s ease-out;
            }

            .animate-fade-in {
                animation: fadeIn 0.8s ease-out;
            }

            /* Smooth scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 3px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #3b82f6, #10b981);
                border-radius: 3px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #2563eb, #059669);
            }

            /* Content area styling */
            .content-area {
                background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%);
                min-height: 100vh;
            }

            /* Loading shimmer effect */
            @keyframes shimmer {
                0% { background-position: -200px 0; }
                100% { background-position: calc(200px + 100%) 0; }
            }

            .shimmer {
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                background-size: 200px 100%;
                animation: shimmer 1.5s infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-warung">
        <!-- Main Container -->
        <div class="h-screen flex overflow-hidden">

            <!-- Sidebar Section -->
            <div class="animate-slide-in-left">
                @include('layouts.partials.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden animate-slide-in-right">
                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto custom-scrollbar content-area">
                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>
                </main>

                <!-- Footer (Optional) -->
                <footer class="bg-white/50 backdrop-blur-sm border-t border-gray-200 px-6 py-3">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center space-x-2">
                            <span>© 2024 Warung GO</span>
                            <span class="text-gray-400">•</span>
                            <span>POS System v1.0</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span>System Online</span>
                            </span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Scripts Stack -->
        @stack('scripts')

        <!-- Initialize Lucide Icons -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        </script>
    </body>
</html>
