<div class="border-t border-gray-200/50 bg-white/90 backdrop-blur-sm p-6 space-y-4 flex-shrink-0">
    <div class="space-y-3">
        <div class="flex justify-between text-sm text-gray-600">
            <span class="flex items-center">
                <x-lucide-calculator class="w-4 h-4 mr-1" />
                Subtotal
            </span>
            <span class="font-medium">Rp <span x-text="subtotal().toLocaleString('id-ID')"></span></span>
        </div>
        <div class="flex justify-between text-sm text-gray-600">
            <span class="flex items-center">
                <x-lucide-percent class="w-4 h-4 mr-1" />
                Pajak (11%)
            </span>
            <span class="font-medium">Rp <span x-text="tax().toLocaleString('id-ID')"></span></span>
        </div>
        <div class="border-t border-gray-200 pt-3">
            <div class="flex justify-between font-bold text-lg text-gray-800">
                <span class="flex items-center">
                    <x-lucide-receipt class="w-5 h-5 mr-1" />
                    Total
                </span>
                <span class="text-xl bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">Rp <span x-text="total().toLocaleString('id-ID')"></span></span>
            </div>
        </div>
    </div>
    <div class="space-y-3">
        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
        <select x-model="paymentMethod" class="w-full border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 bg-white/70 backdrop-blur-sm transition-all duration-200">
            <option value="cash">Tunai</option>
            <option value="qris">QRIS</option>
            <option value="card">Kartu</option>
            <option value="debt">Hutang</option>
        </select>
    </div>
    <button
        @click="syncCartToLivewire(); $wire.submitOrder()"
        class="w-full bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl py-4 font-bold text-lg hover:from-blue-700 hover:to-green-700 disabled:from-gray-400 disabled:to-gray-400 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:transform-none flex items-center justify-center space-x-2"
    >
        <x-lucide-credit-card class="w-5 h-5" />
        <span>BAYAR SEKARANG</span>
    </button>
</div>
