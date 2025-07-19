<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <x-lucide-arrow-left class="w-5 h-5 mr-2" />
                    Kembali
                </a>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Edit Kategori
                    </h1>
                    <p class="text-gray-600 mt-2">Perbarui informasi kategori "{{ $category->name }}"</p>
                </div>
            </div>
        </div>

        <div class="max-w-2xl mx-auto">
            <!-- Form Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <x-lucide-edit class="w-6 h-6 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Edit Kategori</h2>
                            <p class="text-blue-100">Perbarui informasi kategori</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('categories.update', $category) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Kategori -->
                    <x-plain-field
                        name="name"
                        label="Nama Kategori"
                        value="{{ old('name', $category->name) }}"
                        placeholder="Masukkan nama kategori"
                        required
                        class="@error('name') border-red-300 @enderror"
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
                        value="{{ old('description', $category->description ?? '') }}"
                        placeholder="Deskripsi singkat tentang kategori ini"
                        rows="4"
                    />

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Status
                        </label>
                        <x-checkbox
                            name="is_active"
                            label="Kategori Aktif"
                            :checked="old('is_active', $category->is_active ?? true)"
                        />
                        <p class="mt-2 text-sm text-gray-500">Kategori aktif akan ditampilkan dalam daftar produk</p>
                    </div>

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
                            Perbarui Kategori
                        </x-primary-button>
                    </div>
                </form>
        </div>
    </div>
</x-app-layout>
