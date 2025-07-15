<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold mb-2">Login</h1>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email"
                            class="block mt-1 w-full"
                            type="email" name="email"
                            :value="old('email')"
                            placeholder="{{ __('Masukkan Email') }}"
                            required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="{{ __('   Masukkan Password') }}"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <span class="text-gray-600">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-green-600 font-semibold underline">Daftar</a>
        </div>
    </form>
</x-guest-layout>
