<div class="h-screen font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">
    <div class="flex font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 h-full">
        <!-- Kolom Utama: Katalog & Produk (2/3) -->
        <div class="w-2/3 flex flex-col h-full">
            <!-- Header Konten -->
            <x-page-header
                :title="'Katalog Produk'"
                :subtitle="'Pilih produk untuk menambahkan ke keranjang'"
            >
                <x-slot name="search">
                    <x-icon-field
                        name="scannedBarcode"
                        type="text"
                        placeholder="Scan barcode atau cari produk..."
                        wire:model.live="scannedBarcode"
                        wire:keydown.enter="scanAndAddItem"
                        autofocus
                    >
                        <x-slot name="icon">
                            <x-lucide-scan class="w-5 h-5 text-gray-400 transition-all duration-300" />
                        </x-slot>
                    </x-icon-field>
                    @if (session()->has('error'))
                        <x-input-error :messages="session('error')" class="mt-2" />
                    @endif
                </x-slot>
            </x-page-header>
            <!-- Area Konten Produk (Bisa di-scroll) -->
            <main class="flex-1 flex flex-col min-h-0">
                <!-- Daftar Kategori dalam bentuk Card -->
                <x-category-list :categories="$categories" :selected-category="$selectedCategory" />

                <!-- Grid Produk -->
                <div class="flex-1 overflow-y-auto custom-scrollbar ml-4 pr-1">
                    <x-product-grid :products="$products" />
                </div>
            </main>
        </div>
        <!-- ... Kolom kanan keranjang tetap seperti sebelumnya ... -->
    </div>
</div>
