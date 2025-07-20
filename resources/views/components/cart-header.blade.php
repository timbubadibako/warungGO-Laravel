@props(['total'])

<header class="bg-gradient-to-r from-blue-600 to-green-600 px-6 py-5 flex-shrink-0 flex items-center justify-between text-white h-28">
    <div>
        <h2 class="font-bold text-xl flex items-center">
            <x-lucide-shopping-cart class="w-6 h-6 mr-2" />
            Keranjang Belanja
        </h2>
        <p class="text-blue-100 text-sm mt-1">
            Total item: <span class="font-semibold" x-text="Object.keys(cart).length"></span>
        </p>
    </div>
    <template x-if="Object.keys(cart).length > 0">
        <button @click="clearCart()" class="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200" title="Kosongkan keranjang">
            <x-lucide-trash-2 class="w-5 h-5" />
        </button>
    </template>
</header>
