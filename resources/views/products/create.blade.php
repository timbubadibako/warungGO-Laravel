<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('products.index') }}"
                    class="flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <x-lucide-arrow-left class="w-5 h-5 mr-2" />
                    Kembali
                </a>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Tambah Produk Baru
                    </h1>
                    <p class="text-gray-600 mt-2">Buat produk baru untuk inventori toko</p>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50/50 backdrop-blur-sm border border-red-200 rounded-2xl p-6">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <x-lucide-alert-circle class="w-5 h-5 text-red-600" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-red-900 mb-2">Terdapat kesalahan pada form:</h3>
                        <ul class="space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <!-- Form Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <x-lucide-package class="w-6 h-6 text-white" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Informasi Produk</h2>
                            <p class="text-blue-100">Lengkapi data produk di bawah ini</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('products.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Nama Produk -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <x-lucide-tag class="w-4 h-4 inline mr-2" />
                                    Nama Produk
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200 @error('name') border-red-300 @enderror"
                                    placeholder="Masukkan nama produk"
                                    required
                                >
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-lucide-alert-circle class="w-4 h-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <x-lucide-grid-3x3 class="w-4 h-4 inline mr-2" />
                                    Kategori
                                </label>
                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200 @error('category_id') border-red-300 @enderror"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-lucide-alert-circle class="w-4 h-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Barcode -->
                            <div>
                                <label for="barcode" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <x-lucide-scan class="w-4 h-4 inline mr-2" />
                                    Barcode (Opsional)
                                </label>
                                <input
                                    type="text"
                                    id="barcode"
                                    name="barcode"
                                    value="{{ old('barcode') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                                    placeholder="Scan atau ketik barcode"
                                >
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Harga Beli -->
                            <div>
                                <label for="purchase_price" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <x-lucide-shopping-cart class="w-4 h-4 inline mr-2" />
                                    Harga Beli
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input
                                        type="number"
                                        id="purchase_price"
                                        name="purchase_price"
                                        value="{{ old('purchase_price') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200 @error('purchase_price') border-red-300 @enderror"
                                        placeholder="0"
                                        required
                                    >
                                </div>
                                @error('purchase_price')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-lucide-alert-circle class="w-4 h-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Harga Jual -->
                            <div>
                                <label for="selling_price" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <x-lucide-dollar-sign class="w-4 h-4 inline mr-2" />
                                    Harga Jual
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input
                                        type="number"
                                        id="selling_price"
                                        name="selling_price"
                                        value="{{ old('selling_price') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200 @error('selling_price') border-red-300 @enderror"
                                        placeholder="0"
                                        required
                                    >
                                </div>
                                @error('selling_price')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-lucide-alert-circle class="w-4 h-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Stok Awal -->
                            <div>
                                <label for="stock" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <x-lucide-package-2 class="w-4 h-4 inline mr-2" />
                                    Stok Awal
                                </label>
                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    value="{{ old('stock', 0) }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200 @error('stock') border-red-300 @enderror"
                                    placeholder="0"
                                    min="0"
                                    required
                                >
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <x-lucide-alert-circle class="w-4 h-4 mr-1" />
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                            <x-lucide-file-text class="w-4 h-4 inline mr-2" />
                            Deskripsi (Opsional)
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                            placeholder="Deskripsi produk"
                        >{{ old('description') }}</textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-200 mt-8">
                        <a href="{{ route('products.index') }}"
                            class="flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200">
                            <x-lucide-x class="w-5 h-5 mr-2" />
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <x-lucide-save class="w-5 h-5 mr-2" />
                            Simpan Produk
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
                        <h3 class="font-semibold text-blue-900 mb-2">Tips Menambah Produk</h3>
                        <ul class="space-y-1 text-sm text-blue-700">
                            <li>• Pastikan nama produk jelas dan mudah dicari</li>
                            <li>• Pilih kategori yang sesuai untuk organisasi yang baik</li>
                            <li>• Harga jual disarankan lebih tinggi dari harga beli</li>
                            <li>• Barcode memudahkan proses scanning di kasir</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto calculate profit margin
        document.getElementById('purchase_price').addEventListener('input', calculateMargin);
        document.getElementById('selling_price').addEventListener('input', calculateMargin);

        function calculateMargin() {
            const purchasePrice = parseFloat(document.getElementById('purchase_price').value) || 0;
            const sellingPrice = parseFloat(document.getElementById('selling_price').value) || 0;

            if (purchasePrice > 0 && sellingPrice > 0) {
                const margin = ((sellingPrice - purchasePrice) / purchasePrice * 100).toFixed(1);
                // You can add margin display here if needed
            }
        }
    </script>
    @endpush
</x-app-layout>
