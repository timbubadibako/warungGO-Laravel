<div class="h-screen font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50"
    x-data="posCart({
        initialCart: @js($cart),
        syncToServer: cart => $wire.set('cart', cart),
    })"
    x-init="init()"
    x-cloak
>
    <div class="flex font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 h-full">

        <!-- Kolom Utama: Katalog & Produk (2/3) -->
        <div class="w-2/3 flex flex-col h-full">
            <!-- Header Konten -->
            <x-page-header
                :title="'Katalog Produk'"
                :subtitle="'Pilih produk untuk menambahkan ke keranjang'">
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

            <main class="flex-1 flex flex-col min-h-0">
                <!-- Kategori -->
               <div class="flex items-center space-x-3 pl-5 my-4 overflow-x-auto scrollbar-hide">
                    <button
                        @click="$wire.selectCategory('all')"
                        class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200
                        {{ $selectedCategory == 'all' ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105'
                        : 'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50' }}"
                    >
                        Semua Kategori
                    </button>
                    @foreach($categories as $category)
                        <button
                            @click="$wire.selectCategory({{ $category->id }})"
                            class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200
                            {{ $selectedCategory == $category->id ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105'
                            : 'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50' }}"
                        >
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Grid Produk -->
                <div class="flex-1 overflow-y-auto custom-scrollbar ml-4 pr-1" wire:loading.class="opacity-50">
                    <div wire:loading wire:target="selectCategory" class="text-center py-8">
                        <div class="inline-flex items-center space-x-2">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                            <span class="text-gray-600">Memuat produk...</span>
                        </div>
                    </div>
                    <div wire:loading.remove wire:target="selectCategory">
                        <x-product-grid :products="$products" />
                </div>
            </main>
        </div>

        <!-- Sidebar Cart (1/3) TANPA PARTIAL, NATIVE ALPINE -->
        <aside class="w-1/3 flex flex-col bg-white/80 backdrop-blur-sm border-l border-gray-200/50 shadow-xl h-screen">
            <x-cart-header :total="count($cart)" />
            <x-cart-list />
            <x-cart-summary />
        </aside>
    </div>
</div>
@push('scripts')

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
<script>
function posCart({ initialCart, syncToServer }) {
    return {
        cart: {},
        paymentMethod: 'cash',
        syncTimeout: null,
        selectedCategory: 'all',
        init() {
            this.cart = initialCart || {};

            // Listen untuk event perubahan kategori
            this.$wire.on('category-changed', (event) => {
                console.log('Category changed to:', event.category);
                this.selectedCategory = event.category;
            });
        },
        addItem(id, name, price, purchase_price, stock) {
            if (!this.cart[id]) {
                this.cart[id] = { product_id: id, name, price, purchase_price, quantity: 1 };
            } else if (this.cart[id].quantity < stock) {
                this.cart[id].quantity++;
            }
            this.autoSync();
        },
        updateCartItem(id, action) {
            if (!this.cart[id]) return;
            if (action === "plus") {
                this.cart[id].quantity++;
            } else if (action === "minus") {
                if (this.cart[id].quantity > 1) {
                    this.cart[id].quantity--;
                } else {
                    delete this.cart[id];
                }
            }
            this.autoSync();
        },
        clearCart() {
            this.cart = {};
            this.autoSync();
        },
        subtotal() {
            return Object.values(this.cart).reduce((sum, item) => sum + item.price * item.quantity, 0);
        },
        tax() {
            return Math.round(this.subtotal() * 0.11);
        },
        total() {
            return this.subtotal() + this.tax();
        },
        autoSync() {
            clearTimeout(this.syncTimeout);
            this.syncTimeout = setTimeout(() => {
                this.syncCartToLivewire();
            }, 150); // DEBOUNCE 150ms AGAR SANGAT CEPAT
        },
        syncCartToLivewire() {
            syncToServer(this.cart);
        }
    }
}
</script>
@endpush
