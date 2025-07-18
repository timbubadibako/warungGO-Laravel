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
                        Tambah Kategori Baru
                    </h1>
                    <p class="text-gray-600 mt-2">Buat kategori baru untuk mengorganisir produk</p>
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
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                            <x-lucide-tag class="w-4 h-4 inline mr-2" />
                            Nama Kategori
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200 @error('name') border-red-300 @enderror"
                            placeholder="Masukkan nama kategori"
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <x-lucide-alert-circle class="w-4 h-4 mr-1" />
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                            <x-lucide-file-text class="w-4 h-4 inline mr-2" />
                            Deskripsi (Opsional)
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                            placeholder="Deskripsi singkat tentang kategori ini"
                        >{{ old('description') }}</textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <x-lucide-settings class="w-4 h-4 inline mr-2" />
                            Status
                        </label>
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                >
                                <span class="ml-3 text-gray-700">Kategori Aktif</span>
                            </label>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Kategori aktif akan ditampilkan dalam daftar produk</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('categories.index') }}"
                            class="flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200">
                            <x-lucide-x class="w-5 h-5 mr-2" />
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <x-lucide-save class="w-5 h-5 mr-2" />
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-blue-50/50 backdrop-blur-sm rounded-2xl border border-blue-200/50 p-6">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                        <x-lucide-lightbulb class="w-5 h-5 text-blue-600" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">Tips Membuat Kategori</h3>
                        <ul class="space-y-1 text-sm text-blue-700">
                            <li>• Gunakan nama yang jelas dan mudah dipahami</li>
                            <li>• Hindari nama kategori yang terlalu umum atau terlalu spesifik</li>
                            <li>• Pastikan kategori dapat mengelompokkan produk dengan baik</li>
                            <li>• Deskripsi membantu tim memahami tujuan kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
