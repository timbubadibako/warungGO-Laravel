<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah User Baru') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div><label>Nama: <input type="text" name="name" required></label></div>
                <div><label>Email: <input type="email" name="email" required></label></div>
                <div><label>Password: <input type="password" name="password" required></label></div>
                <div><label>Konfirmasi Password: <input type="password" name="password_confirmation" required></label></div>
                <div>
                    <label>Role:
                        <select name="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
