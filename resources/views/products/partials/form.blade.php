<!-- Modal Header -->
<div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6 flex items-center justify-between">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
            <x-lucide-package class="w-6 h-6 text-white" x-show="!editMode" />
            <x-lucide-edit class="w-6 h-6 text-white" x-show="editMode" />
        </div>
        <div>
            <h2 class="text-xl font-bold text-white" x-text="editMode ? 'Edit Produk' : 'Tambah Produk Baru'"></h2>
            <p class="text-blue-100" x-text="editMode ? 'Perbarui informasi produk' : 'Lengkapi data produk di bawah ini'"></p>
        </div>
    </div>
    <button @click="closeModal()" class="text-white/80 hover:text-white transition-colors">
        <x-lucide-x class="w-6 h-6" />
    </button>
</div>

<!-- Modal Form -->
<form :action="editMode ? `/products/${currentProduct.id}` : '{{ route('products.store') }}'" method="POST" class="p-8 space-y-6">
    @csrf
    <div x-show="editMode">
        @method('PUT')
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Nama Produk -->
            <x-plain-field
                name="name"
                label="Nama Produk"
                placeholder="Masukkan nama produk"
                required
                x-model="formData.name"
            />

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Kategori</label>
                <select
                    name="category_id"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-gray-50 focus:bg-white"
                    x-model="formData.category_id"
                >
                    <option value="">Pilih Kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Barcode -->
            <x-plain-field
                name="barcode"
                label="Barcode (Opsional)"
                placeholder="Masukkan barcode produk"
                x-model="formData.barcode"
            />
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Harga Beli -->
            <x-plain-field
                name="purchase_price"
                type="number"
                label="Harga Beli"
                placeholder="0"
                required
                x-model="formData.purchase_price"
            />

            <!-- Harga Jual -->
            <x-plain-field
                name="selling_price"
                type="number"
                label="Harga Jual"
                placeholder="0"
                required
                x-model="formData.selling_price"
            />

            <!-- Stok -->
            <x-plain-field
                name="stock"
                type="number"
                label="Stok Awal"
                placeholder="0"
                required
                x-model="formData.stock"
            />
        </div>
    </div>

    <!-- Deskripsi -->
    <x-plain-field
        name="description"
        type="textarea"
        label="Deskripsi (Opsional)"
        placeholder="Deskripsi produk"
        rows="3"
        x-model="formData.description"
    />

    <!-- Buttons -->
    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
        <x-cancel-button type="button" @click="closeModal()">
            <x-slot name="icon">
                <x-lucide-x class="w-5 h-5 mr-2" />
            </x-slot>
            Batal
        </x-cancel-button>

        <x-primary-button type="submit">
            <x-slot name="icon">
                <x-lucide-save class="w-5 h-5 mr-2" />
            </x-slot>
            <span x-text="editMode ? 'Perbarui Produk' : 'Simpan Produk'"></span>
        </x-primary-button>
    </div>
</form>
