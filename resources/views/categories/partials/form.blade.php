<!-- Modal Header -->
<div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6 flex items-center justify-between">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
            <x-lucide-grid-3x3 class="w-6 h-6 text-white" x-show="!editMode" />
            <x-lucide-edit class="w-6 h-6 text-white" x-show="editMode" />
        </div>
        <div>
            <h2 class="text-xl font-bold text-white" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori Baru'"></h2>
            <p class="text-blue-100" x-text="editMode ? 'Perbarui informasi kategori' : 'Lengkapi data kategori di bawah ini'"></p>
        </div>
    </div>
    <button @click="closeModal()" class="text-white/80 hover:text-white transition-colors">
        <x-lucide-x class="w-6 h-6" />
    </button>
</div>

<!-- Modal Form -->
<form :action="editMode ? `/categories/${currentCategory.id}` : '{{ route('categories.store') }}'" method="POST" class="p-8 space-y-6">
    @csrf
    <div x-show="editMode">
        @method('PUT')
    </div>

    <!-- Nama Kategori -->
    <x-plain-field
        name="name"
        label="Nama Kategori"
        placeholder="Masukkan nama kategori"
        required
        x-model="formData.name"
    />

    <!-- Deskripsi -->
    <x-plain-field
        name="description"
        type="textarea"
        label="Deskripsi (Opsional)"
        placeholder="Deskripsi singkat tentang kategori ini"
        rows="4"
        x-model="formData.description"
    />

    <!-- Status -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">
            Status
        </label>
        <x-checkbox
            name="is_active"
            label="Kategori Aktif"
            x-model="formData.is_active"
        />
        <p class="mt-2 text-sm text-gray-500">Kategori aktif akan ditampilkan dalam daftar produk</p>
    </div>

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
            <span x-text="editMode ? 'Perbarui Kategori' : 'Simpan Kategori'"></span>
        </x-primary-button>
    </div>
</form>
