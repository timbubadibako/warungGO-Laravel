@props(['products', 'categories', 'selectedCategory'])

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-4">
    <template x-for="product in filteredProducts" :key="product.id">
        <div
            class="group bg-white/70 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-200/50 p-5 flex flex-col items-center text-center cursor-pointer hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-2 hover:bg-white transition-all duration-300 overflow-hidden relative"
            @click="addItem(product.id, product.name, product.selling_price, product.purchase_price, product.stock)"
        >
            <!-- Gradient overlay on hover -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-green-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>

            <div class="relative z-10 w-full flex flex-col items-center">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mb-4 flex items-center justify-center overflow-hidden shadow-sm group-hover:shadow-md transition-shadow duration-300">
                    <img :src="product.image || `https://placehold.co/150x150/e2e8f0/4a5568?text=${encodeURIComponent(product.name)}`" :alt="product.name" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-sm text-gray-800 mb-1 group-hover:text-blue-600 transition-colors duration-200" x-text="product.name"></h4>
                <div class="flex items-center space-x-1 mb-2">
                    <x-lucide-package class="w-3 h-3 text-gray-400" />
                    <p class="text-gray-500 text-xs">Stok: <span x-text="product.stock"></span></p>
                </div>
                <p class="font-extrabold text-lg bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">Rp <span x-text="Number(product.selling_price).toLocaleString('id-ID')"></span></p>

                <!-- Add to cart icon -->
                <div class="absolute top-3 right-3 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300">
                    <x-lucide-plus class="w-4 h-4 text-white" />
                </div>
            </div>
        </div>
    </template>
</div>
