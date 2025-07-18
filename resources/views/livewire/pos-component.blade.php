<div class="h-screen font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">
    <div class="flex font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">

        <!-- Kolom Utama: Katalog & Produk (2/3) -->
        <div class="w-2/3 flex flex-col">
            <!-- Header Konten -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 px-6 h-28 flex-shrink-0 flex items-center shadow-sm">
                <div class="flex justify-between items-center w-full">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">Katalog Produk</h1>
                        <p class="text-gray-600">Pilih produk untuk menambahkan ke keranjang</p>
                    </div>
                    <div class="w-1/2 max-w-md">
                        <div class="relative">
                            <x-lucide-scan class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                            <input
                                type="text"
                                wire:model.live="scannedBarcode"
                                wire:keydown.enter="scanAndAddItem"
                                placeholder="Scan barcode atau cari produk..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                                autofocus
                            >
                        </div>
                        @if (session()->has('error'))
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <x-lucide-alert-circle class="w-3 h-3 mr-1" />
                                {{ session('error') }}
                            </p>
                        @endif
                    </div>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center px-4 py-3 bg-white/70 backdrop-blur-sm border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-white hover:shadow-md transition-all duration-200">
                            <x-lucide-arrow-up-wide-narrow class="w-4 h-4 mr-2 text-gray-500" />
                            Urutkan
                            <x-lucide-chevron-down class="w-4 h-4 ml-2 text-gray-400" />
                        </button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-52 bg-white/90 backdrop-blur-sm rounded-xl shadow-lg border border-gray-200/50 z-10 overflow-hidden"
                        >
                            <a href="#" wire:click.prevent="sortBy('price_asc')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <x-lucide-trending-up class="w-4 h-4 mr-3 text-green-500" />
                                Harga Termurah
                            </a>
                            <a href="#" wire:click.prevent="sortBy('price_desc')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <x-lucide-trending-down class="w-4 h-4 mr-3 text-red-500" />
                                Harga Termahal
                            </a>
                            <a href="#" wire:click.prevent="sortBy('name_asc')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <x-lucide-arrow-up-a-z class="w-4 h-4 mr-3 text-blue-500" />
                                Nama (A-Z)
                            </a>
                            <a href="#" wire:click.prevent="sortBy('name_desc')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <x-lucide-arrow-down-z-a class="w-4 h-4 mr-3 text-purple-500" />
                                Nama (Z-A)
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Area Konten Produk (Bisa di-scroll) -->
            <main class="flex-1 px-6 py-6 overflow-y-auto custom-scrollbar">
                <!-- Daftar Kategori dalam bentuk Card -->
                <div class="flex items-center space-x-3 mb-8 overflow-x-auto pb-4 scrollbar-hide">
                <button
                    wire:click.prevent="$set('selectedCategory', 'all')"
                    class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 {{ $selectedCategory == 'all' ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105' : 'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50' }}"
                >
                    <div class="flex items-center space-x-2">
                        <x-lucide-grid-3x3 class="w-4 h-4" />
                        <span>Semua Kategori</span>
                    </div>
                </button>
                @foreach($categories as $category)
                    <button
                        wire:click.prevent="$set('selectedCategory', {{ $category->id }})"
                        class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200 {{ $selectedCategory == $category->id ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105' : 'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50' }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div wire:key="product-{{ $product->id }}" wire:click="addItem({{ $product->id }})" class="group bg-white/70 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-200/50 p-5 flex flex-col items-center text-center cursor-pointer hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-2 hover:bg-white transition-all duration-300 overflow-hidden relative">
                        <!-- Gradient overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-green-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>

                        <div class="relative z-10 w-full flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mb-4 flex items-center justify-center overflow-hidden shadow-sm group-hover:shadow-md transition-shadow duration-300">
                                <img src="https://placehold.co/150x150/e2e8f0/4a5568?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                            <h4 class="font-bold text-sm text-gray-800 mb-1 group-hover:text-blue-600 transition-colors duration-200">{{ $product->name }}</h4>
                            <div class="flex items-center space-x-1 mb-2">
                                <x-lucide-package class="w-3 h-3 text-gray-400" />
                                <p class="text-gray-500 text-xs">Stok: {{ $product->stock }}</p>
                            </div>
                            <p class="font-extrabold text-lg bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>

                            <!-- Add to cart icon -->
                            <div class="absolute top-3 right-3 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300">
                                <x-lucide-plus class="w-4 h-4 text-white" />
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <x-lucide-package-x class="w-12 h-12 text-gray-400" />
                        </div>
                        <p class="text-gray-500 text-lg font-medium">Tidak ada produk yang ditemukan</p>
                        <p class="text-gray-400 text-sm">Coba ubah kategori atau kata kunci pencarian</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Kolom Kanan: Keranjang Belanja (1/3) -->
    <aside class="w-1/3 flex flex-col bg-white/80 backdrop-blur-sm border-l border-gray-200/50 shadow-xl h-screen">
        <header class="bg-gradient-to-r from-blue-600 to-green-600 px-6 py-5 flex-shrink-0 flex items-center justify-between text-white h-28">
            <div>
                <h2 class="font-bold text-xl flex items-center">
                    <x-lucide-shopping-cart class="w-6 h-6 mr-2" />
                    Keranjang Belanja
                </h2>
                <p class="text-blue-100 text-sm mt-1">Total item: <span class="font-semibold">{{ count($cart) }}</span></p>
            </div>
            @if(count($cart) > 0)
                <button wire:click="clearCart" class="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200" title="Kosongkan keranjang">
                    <x-lucide-trash-2 class="w-5 h-5" />
                </button>
            @endif
        </header>

        <!-- Daftar Item Keranjang -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-4">
            @forelse($cart as $productId => $item)
                <div wire:key="cart-{{ $productId }}" class="flex items-center justify-between mb-4 p-4 rounded-xl bg-white/70 backdrop-blur-sm border border-gray-200/50 hover:bg-white hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-center flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center mr-3 overflow-hidden shadow-sm">
                            <img src="https://placehold.co/40x40/e2e8f0/4a5568?text={{ substr($item['name'], 0, 1) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-blue-600 transition-colors duration-200">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500 flex items-center mt-1">
                                <x-lucide-tag class="w-3 h-3 mr-1" />
                                Rp {{ number_format($item['price']) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 ml-3">
                        <button wire:click="updateCartItem({{ $productId }}, 'minus')" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors duration-200 hover:shadow-sm">
                            <x-lucide-minus class="w-4 h-4" />
                        </button>
                        <span class="w-10 text-center font-bold text-gray-700 bg-gray-50 rounded-lg py-1">{{ $item['quantity'] }}</span>
                        <button wire:click="updateCartItem({{ $productId }}, 'plus')" class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg flex items-center justify-center transition-colors duration-200 hover:shadow-sm">
                            <x-lucide-plus class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <x-lucide-shopping-cart class="w-10 h-10 text-gray-400" />
                    </div>
                    <p class="text-gray-500 font-medium">Keranjang masih kosong</p>
                    <p class="text-gray-400 text-sm mt-1">Pilih produk untuk memulai transaksi</p>
                </div>
            @endforelse
        </div>

        <!-- Total & Pembayaran -->
        <div class="border-t border-gray-200/50 bg-white/90 backdrop-blur-sm p-6 space-y-4 flex-shrink-0">
            <div class="space-y-3">
                <div class="flex justify-between text-sm text-gray-600">
                    <span class="flex items-center">
                        <x-lucide-calculator class="w-4 h-4 mr-1" />
                        Subtotal
                    </span>
                    <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span class="flex items-center">
                        <x-lucide-percent class="w-4 h-4 mr-1" />
                        Pajak (11%)
                    </span>
                    <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between font-bold text-lg text-gray-800">
                        <span class="flex items-center">
                            <x-lucide-receipt class="w-5 h-5 mr-1" />
                            Total
                        </span>
                        <span class="text-xl bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select wire:model.live="paymentMethod" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 bg-white/70 backdrop-blur-sm transition-all duration-200">
                    <option value="cash">💵 Tunai</option>
                    <option value="qris">📱 QRIS</option>
                    <option value="card">💳 Kartu</option>
                    <option value="debt">📋 Hutang</option>
                </select>
            </div>

            <button
                wire:click="submitOrder"
                wire:loading.attr="disabled"
                class="w-full bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl py-4 font-bold text-lg hover:from-blue-700 hover:to-green-700 disabled:from-gray-400 disabled:to-gray-400 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:transform-none flex items-center justify-center space-x-2"
            >
                <span wire:loading.remove wire:target="submitOrder" class="flex items-center space-x-2">
                    <x-lucide-credit-card class="w-5 h-5" />
                    <span>BAYAR SEKARANG</span>
                </span>
                <span wire:loading wire:target="submitOrder" class="flex items-center space-x-2">
                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    <span>Memproses...</span>
                </span>
            </button>
        </div>
    </aside>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #3b82f6, #10b981);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #2563eb, #059669);
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>
</div>
