<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold mb-2">Register</h1>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-text-input id="name" class="block mt-1 w-full"
                                        type="text"
                                        name="name"
                                        :value="old('name')"
                                        placeholder="{{ __('Masukkan Nama') }}"
                                        required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        placeholder="{{ __('Masukkan Email') }}"
                                        required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="{{ __('Masukkan Password') }}"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            placeholder="{{ __('Konfirmasi Password') }}"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button class="w-full">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <div class="text-center mt-4">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-green-600 font-semibold underline">Masuk</a>
        </div>
    </form>
</x-guest-layout>
