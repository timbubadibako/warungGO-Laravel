<div class="flex h-screen font-sans">

    <!-- Kolom Utama: Katalog & Produk (2/3) -->
    <div class="w-2/3 flex flex-col p-4">

        <!-- Header Konten -->
        <header class="bg-white h-24 border-b px-6 flex-shrink-0 flex items-center">
            <div class="flex justify-between items-center w-full">
                <h1 class="text-2xl font-bold text-gray-800">Katalog Produk</h1>
                <div class="w-1/2 max-w-md">
                    <input
                        type="text"
                        wire:model.live="scannedBarcode"
                        wire:keydown.enter="scanAndAddItem"
                        placeholder="Scan barcode di sini..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        autofocus
                    >
                    @if (session()->has('error'))
                        <p class="text-red-500 text-xs mt-1">{{ session('error') }}</p>
                    @endif

                </div>
                <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <span class="mr-2">
                                <x-lucide-arrow-up-wide-narrow class="w-6 h-6 text-gray-400" />
                            </span>
                            Urutkan


                        </button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
                        >
                            <a href="#" wire:click.prevent="sortBy('price_asc')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Harga Termurah</a>
                            <a href="#" wire:click.prevent="sortBy('price_desc')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Harga Termahal</a>
                            <a href="#" wire:click.prevent="sortBy('name_asc')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Nama (A-Z)</a>
                            <a href="#" wire:click.prevent="sortBy('name_desc')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Nama (Z-A)</a>
                        </div>
                </div>
            </div>
        </header>

        <!-- Area Konten Produk (Bisa di-scroll) -->
        <main class="flex-1 p-6 overflow-y-auto">
            <!-- Daftar Kategori dalam bentuk Card -->
            <div class="flex items-center space-x-4 mb-8 overflow-x-auto pb-4">
                <button
                    wire:click.prevent="$set('selectedCategory', 'all')"
                    class="flex-shrink-0 px-5 py-2 rounded-lg font-semibold text-sm transition-colors duration-200 {{ $selectedCategory == 'all' ? 'bg-blue-500 text-white shadow-md' : 'bg-white text-gray-700 shadow-sm hover:bg-gray-50' }}"
                >
                    Semua Kategori
                </button>
                @foreach($categories as $category)
                    <button
                        wire:click.prevent="$set('selectedCategory', {{ $category->id }})"
                        class="flex-shrink-0 px-5 py-2 rounded-lg font-semibold text-sm transition-colors duration-200 {{ $selectedCategory == $category->id ? 'bg-blue-500 text-white shadow-md' : 'bg-white text-gray-700 shadow-sm hover:bg-gray-50' }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div wire:key="product-{{ $product->id }}" wire:click="addItem({{ $product->id }})" class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <img src="https://placehold.co/150x150/e2e8f0/4a5568?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" class="w-28 h-28 object-cover rounded-lg mb-4">
                        <h4 class="font-bold text-sm text-gray-800">{{ $product->name }}</h4>
                        <p class="text-gray-500 text-xs mb-2">Stok: {{ $product->stock }}</p>
                        <p class="font-extrabold text-blue-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 mt-10">Tidak ada produk yang ditemukan.</p>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Kolom Kanan: Keranjang Belanja (1/3) -->
    <aside class="w-1/3 flex flex-col p-4 border-l">
        <header class="bg-white h-24 border-b px-6 flex-shrink-0 flex items-center justify-between">
            <h2 class="font-bold text-xl">Keranjang Belanja</h2>
            <p class="text-gray-500 text-sm">Total item: <span class="text-blue-500">{{ count($cart) }}</span></p>
        </header>

        <!-- Daftar Item Keranjang -->
        <div class="flex-1 overflow-y-auto -mr-6 pr-6">
            @forelse($cart as $productId => $item)
                <div wire:key="cart-{{ $productId }}" class="flex items-center justify-between mb-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="flex items-center pt-4">
                        <img src="https://placehold.co/40x40/e2e8f0/4a5568?text={{ substr($item['name'], 0, 1) }}" alt="{{ $item['name'] }}" class="w-10 h-10 object-cover rounded-md mr-4">
                        <div>
                            <p class="font-semibold text-sm text-gray-900">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">Rp {{ number_format($item['price']) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button wire:click="updateCartItem({{ $productId }}, 'minus')" class="w-7 h-7 border rounded-md hover:bg-gray-200 transition-colors">-</button>
                        <span class="w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                        <button wire:click="updateCartItem({{ $productId }}, 'plus')" class="w-7 h-7 border rounded-md hover:bg-gray-200 transition-colors">+</button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-16">
                    <p>Keranjang masih kosong</p>
                </div>
            @endforelse
        </div>

        <!-- Total & Pembayaran -->
        <div class="border-t-2 border-dashed pt-6 mt-4 space-y-4">
            <div class="flex justify-between text-md text-gray-600">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-md text-gray-600">
                <span>Pajak (11%)</span>
                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold text-xl text-gray-800 mt-2">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="mt-4">
                <select wire:model.live="paymentMethod" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="cash">Tunai</option>
                    <option value="qris">QRIS</option>
                    <option value="card">Kartu</option>
                    <option value="debt">Hutang</option>
                </select>
            </div>
            <button
                wire:click="submitOrder"
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white rounded-lg py-4 font-bold text-lg hover:bg-blue-700 disabled:bg-blue-400 transition-all duration-200"
            >
                <span wire:loading.remove wire:target="submitOrder">BAYAR</span>
                <span wire:loading wire:target="submitOrder">Memproses...</span>
            </button>
        </div>
    </aside>
</div>
