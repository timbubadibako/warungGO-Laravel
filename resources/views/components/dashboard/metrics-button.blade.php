<div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
    <button
        @click="chart = 'revenue'; $nextTick(() => window.renderChart('revenue'))"
        :class="chart === 'revenue' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
        class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105"
    >
        Pendapatan
    </button>
    <button
        @click="chart = 'stock'; $nextTick(() => window.renderChart('stock'))"
        :class="chart === 'stock' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg shadow-green-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
        class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105"
    >
        Stok
    </button>
    <button
        @click="chart = 'top'; $nextTick(() => window.renderChart('top'))"
        :class="chart === 'top' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg shadow-purple-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
        class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105"
    >
        Terlaris
    </button>
    <button
        @click="chart = 'transaksi'; $nextTick(() => window.renderChart('transaksi'))"
        :class="chart === 'transaksi' ? 'bg-gradient-to-r from-orange-600 to-orange-700 text-white shadow-lg shadow-orange-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
        class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105"
    >
        Transaksi
    </button>
</div>

