<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />
    <div class="text-center mb-8 animate-fade-in">
        <div class="mb-4">
            <h1 class="text-4xl font-bold text-gray-900 mb-3 hover:scale-105 transition-transform duration-300">
                Selamat Datang
            </h1>
            <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-green-500 mx-auto rounded-full"></div>
        </div>
        <p class="text-gray-600 text-base leading-relaxed">
            Silakan masuk ke sistem<br>
            <span class="font-semibold text-blue-600">Warung GO POS</span>
        </p>
        <p class="text-gray-500 text-sm mt-2">Admin & Staff Dashboard</p>
    </div>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Input -->
        <x-icon-field
            name="email"
            type="email"
            label="Email Address"
            placeholder="masukkan@email.com"
            required
            autofocus
            autocomplete="username"
        >
            <x-slot name="icon">
                <x-lucide-at-sign class="w-5 h-5 text-gray-400 transition-all duration-300" />
            </x-slot>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </x-icon-field>

        <!-- Password Input -->
        <x-icon-field
            name="password"
            type="password"
            label="Password"
            placeholder="Masukkan password"
            required
            autocomplete="current-password"
        >
            <x-slot name="icon">
                <x-lucide-lock class="w-5 h-5 text-gray-400 transition-all duration-300" />
            </x-slot>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </x-icon-field>

        <!-- Remember Me & Forgot Password -->
        <div class="form-group flex items-center justify-between">
            <label class="flex items-center cursor-pointer hover:text-gray-700 transition-colors duration-200">
                <input
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-200"
                />
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-200 hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="form-group pt-2">
            <x-primary-button
                type="submit"
                class="w-full"
            >
                <x-slot name="icon">
                    <x-lucide-log-in class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:translate-x-1" />
                </x-slot>
                Masuk ke Dashboard
            </x-primary-button>
        </div>
    </form>

    <!-- Footer Note -->
    <div class="mt-8 text-center animate-fade-in" style="animation-delay: 0.5s;">
        <x-information-box title="Akses Terbatas">
            <x-slot name="icon">
                <x-lucide-info class="w-5 h-5 text-blue-600 mr-2" />
            </x-slot>
            Sistem ini hanya untuk admin dan staff yang telah terdaftar.<br>
            Untuk pendaftaran akun baru, hubungi administrator sistem.
        </x-information-box>
    </div>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        .form-group {
            animation: fadeInUp 0.6s ease-out;
        }

        .form-group:nth-child(2) { animation-delay: 0.1s; }
        .form-group:nth-child(3) { animation-delay: 0.2s; }
        .form-group:nth-child(4) { animation-delay: 0.3s; }
        .form-group:nth-child(5) { animation-delay: 0.4s; }

        .input-with-icon {
            transition: all 0.3s ease;
        }

        .input-with-icon:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }

        .input-with-icon:focus-within svg {
            color: #3b82f6;
            transform: scale(1.1);
        }
    </style>
</x-guest-layout>
