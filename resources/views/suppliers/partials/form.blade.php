<!-- Modal Header -->
<div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6 flex items-center justify-between">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
            <x-lucide-users class="w-6 h-6 text-white" x-show="!editMode" />
            <x-lucide-edit class="w-6 h-6 text-white" x-show="editMode" />
        </div>
        <div>
            <h2 class="text-xl font-bold text-white" x-text="editMode ? 'Edit Supplier' : 'Tambah Supplier Baru'"></h2>
            <p class="text-blue-100" x-text="editMode ? 'Perbarui informasi supplier' : 'Lengkapi data supplier di bawah ini'"></p>
        </div>
    </div>
    <button @click="closeModal()" class="text-white/80 hover:text-white transition-colors">
        <x-lucide-x class="w-6 h-6" />
    </button>
</div>

<!-- Modal Form -->
<form :action="editMode ? `/suppliers/${currentSupplier.id}` : '{{ route('suppliers.store') }}'" method="POST" class="p-8 space-y-6">
    @csrf
    <template x-if="editMode">
        <input type="hidden" name="_method" value="PUT">
    </template>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Nama Supplier -->
            <x-plain-field
                name="name"
                label="Nama Supplier"
                placeholder="Masukkan nama supplier"
                required
                x-model="formData.name"
            />

            <!-- No. Telepon -->


        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <x-plain-field
                name="phone_number"
                label="No. Telepon"
                placeholder="Masukkan nomor telepon"
                x-model="formData.phone_number"
            />
        </div>
    </div>

    <!-- Keterangan -->
    <x-plain-field
        name="address"
        type="textarea"
        label="Alamat"
        placeholder="Masukkan alamat lengkap supplier"
        rows="4"
        x-model="formData.address"
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
                <span x-text="editMode ? 'Perbarui Supplier' : 'Simpan Supplier'"></span>
            </x-primary-button>
        </div>
</form>
