<!-- Modal Header -->
<div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6 flex items-center justify-between">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
            <x-lucide-shopping-bag class="w-6 h-6 text-white" x-show="!editMode" />
            <x-lucide-edit class="w-6 h-6 text-white" x-show="editMode" />
        </div>
        <div>
            <h2 class="text-xl font-bold text-white" x-text="editMode ? 'Edit Pembelian' : 'Catat Pembelian Baru'"></h2>
            <p class="text-blue-100" x-text="editMode ? 'Perbarui informasi pembelian' : 'Lengkapi data pembelian di bawah ini'"></p>
        </div>
    </div>
    <button @click="closeModal()" class="text-white/80 hover:text-white transition-colors">
        <x-lucide-x class="w-6 h-6" />
    </button>
</div>

<!-- Modal Form -->
<form :action="editMode ? `/purchases/${currentPurchase.id}` : '{{ route('purchases.store') }}'" method="POST" class="p-8 space-y-6">
    @csrf
    <template x-if="editMode">
        <input type="hidden" name="_method" value="PUT">
    </template>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Supplier -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Supplier *</label>
                <select
                    name="supplier_id"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-gray-50 focus:bg-white"
                    x-model="formData.supplier_id"
                >
                    <option value="">Pilih Supplier</option>
                    @foreach($suppliers ?? [] as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Pembelian -->
            <x-plain-field
                name="purchase_date"
                type="date"
                label="Tanggal Pembelian"
                required
                x-model="formData.purchase_date"
            />
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                <select
                    name="status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-gray-50 focus:bg-white"
                    x-model="formData.status"
                >
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <!-- Total Amount (readonly, calculated) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Total Amount</label>
                <input
                    type="number"
                    step="0.01"
                    name="total_amount"
                    readonly
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 focus:outline-none"
                    x-model="formData.total_amount"
                    placeholder="Otomatis terhitung"
                />
            </div>
        </div>
    </div>

    <!-- Purchase Items Section -->
    <div class="border-t pt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Items Pembelian</h3>
            <button
                type="button"
                @click="addPurchaseItem()"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center space-x-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Tambah Item</span>
            </button>
        </div>

        <!-- Items List -->
        <div class="space-y-4">
            <template x-for="(item, index) in formData.items" :key="index">
                <div class="grid grid-cols-12 gap-4 items-end p-4 bg-gray-50 rounded-lg border">
                    <!-- Product -->
                    <div class="col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                        <select
                            :name="`items[${index}][product_id]`"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            x-model="item.product_id"
                            @change="onProductChange(index)"
                        >
                            <option value="">Pilih Produk</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input
                            type="number"
                            :name="`items[${index}][quantity]`"
                            required
                            min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            x-model="item.quantity"
                            @input="updateItemCalculation(index)"
                            placeholder="0"
                        />
                    </div>

                    <!-- Cost Price (Auto-filled, readonly) -->
                    <div class="col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Beli <span class="text-xs text-gray-500">(Otomatis)</span></label>
                        <input
                            type="number"
                            step="0.01"
                            :name="`items[${index}][cost_price]`"
                            required
                            min="0"
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none"
                            x-model="item.cost_price"
                            placeholder="Pilih produk dulu"
                        />
                    </div>

                    <!-- Subtotal -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtotal</label>
                        <input
                            type="text"
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100"
                            :value="formatCurrency(item.subtotal || 0)"
                        />
                    </div>

                    <!-- Delete Button -->
                    <div class="col-span-1">
                        <button
                            type="button"
                            @click="removePurchaseItem(index)"
                            class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200"
                            :disabled="formData.items.length === 1"
                        >
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Add default item if none exist -->
        <template x-if="formData.items.length === 0">
            <div class="text-center py-8 text-gray-500">
                <p>Belum ada item. Klik "Tambah Item" untuk menambah produk.</p>
            </div>
        </template>
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
            <span x-text="editMode ? 'Perbarui Pembelian' : 'Simpan Pembelian'"></span>
        </x-primary-button>
    </div>
</form>
