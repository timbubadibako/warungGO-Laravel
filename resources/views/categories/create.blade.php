<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6">

        <div class="max-w-2xl mx-auto">
            <!-- Form Card -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <x-lucide-grid-3x3 class="w-6 h-6 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Informasi Kategori</h2>
                            <p class="text-blue-100">Lengkapi data kategori di bawah ini</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('categories.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <!-- Nama Kategori -->
                    <x-plain-field
                        name="name"
                        label="Nama Kategori"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama kategori"
                        required
                    >
                        @error('name')
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @enderror
                    </x-plain-field>

                    <!-- Deskripsi -->
                    <x-plain-field
                        name="description"
                        type="textarea"
                        label="Deskripsi (Opsional)"
                        value="{{ old('description') }}"
                        placeholder="Deskripsi singkat tentang kategori ini"
                        rows="4"
                    />

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <x-cancel-button :href="route('categories.index')">
                            <x-slot name="icon">
                                <x-lucide-x class="w-5 h-5 mr-2" />
                            </x-slot>
                            Batal
                        </x-cancel-button>

                        <x-primary-button type="submit">
                            <x-slot name="icon">
                                <x-lucide-save class="w-5 h-5 mr-2" />
                            </x-slot>
                            Simpan Kategori
                        </x-primary-button>
                    </div>
                </form>
        </div>
    </div>
</x-app-layout>
