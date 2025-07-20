<div class="flex-1 overflow-y-auto custom-scrollbar p-4">
    <template x-for="[productId, item] in Object.entries(cart)" :key="productId"
        x-data="posCart({
        initialCart: @js($cart),
        syncToServer: cart => $wire.set('cart', cart),
        })"
        x-init="init()"
        x-cloak>

        <div class="flex items-center justify-between mb-4 p-4 rounded-xl bg-white/70 backdrop-blur-sm border border-gray-200/50 hover:bg-white hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center flex-1">
                <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center mr-3 overflow-hidden shadow-sm">
                    <img :src="`https://placehold.co/40x40/e2e8f0/4a5568?text=${item.name[0]}`" :alt="item.name" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-blue-600 transition-colors duration-200" x-text="item.name"></p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        <x-lucide-tag class="w-3 h-3 mr-1" />
                        Rp <span x-text="item.price.toLocaleString('id-ID')"></span>
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2 ml-3">
                <button @click="updateCartItem(productId, 'minus')" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors duration-200 hover:shadow-sm">
                    <x-lucide-minus class="w-4 h-4" />
                </button>
                <span class="w-10 text-center font-bold text-gray-700 bg-gray-50 rounded-lg py-1" x-text="item.quantity"></span>
                <button @click="updateCartItem(productId, 'plus')" class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg flex items-center justify-center transition-colors duration-200 hover:shadow-sm">
                    <x-lucide-plus class="w-4 h-4" />
                </button>
            </div>
        </div>
    </template>

    <div x-show="Object.keys(cart).length === 0" class="text-center py-16">
        <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <x-lucide-shopping-cart class="w-10 h-10 text-gray-400" />
        </div>
        <p class="text-gray-500 font-medium">Keranjang masih kosong</p>
        <p class="text-gray-400 text-sm mt-1">Pilih produk untuk memulai transaksi</p>
    </div>
</div>
