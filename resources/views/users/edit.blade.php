<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div style="color:red; margin-bottom: 20px;">
                    <strong>Error:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method untuk update --}}

                <div>
                    <label>Nama:
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </label>
                </div>
                <br>
                <div>
                    <label>Email:
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </label>
                </div>
                <br>
                <div>
                    <label>Password:
                        <input type="password" name="password">
                        <small>(Kosongkan jika tidak ingin mengubah password)</small>
                    </label>
                </div>
                <br>
                <div>
                    <label>Konfirmasi Password:
                        <input type="password" name="password_confirmation">
                    </label>
                </div>
                <br>
                <div>
                    <label>Role:
                        <select name="role" required>
                            @foreach($roles as $role)
                                {{-- Pilih role yang dimiliki user saat ini --}}
                                <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <br>
                <button type="submit">Update User</button>
            </form>
        </div>
    </div>
</x-app-layout>
