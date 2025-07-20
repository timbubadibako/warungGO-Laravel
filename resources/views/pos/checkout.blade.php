<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 py-8">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">
                        @if(request('paymentMethod') == 'cash')
                            💰 Pembayaran Tunai
                        @elseif(request('paymentMethod') == 'qris')
                            📱 Pembayaran QRIS (Simulasi)
                        @elseif(request('paymentMethod') == 'debit')
                            💳 Pembayaran Kartu Debit (Simulasi)
                        @else
                            Proses Pembayaran
                        @endif
                    </h1>
                </div>

                <form method="POST" action="{{ route('pos.checkout') }}" class="p-6">
                    @csrf
                    <input type="hidden" name="paymentMethod" value="{{ request('paymentMethod', 'cash') }}">
                    @if(request('cashPaid'))
                        <input type="hidden" name="cashPaid" value="{{ request('cashPaid') }}">
                        <input type="hidden" name="change" value="{{ request('change') }}">
                    @endif
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Cart Summary -->
                        <div>
                            <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
                            <div class="space-y-3 mb-4">
                                @foreach($cart as $item)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium">{{ $item['name'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                </div>
                                @endforeach
                            </div>

                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Pajak (11%):</span>
                                    <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg border-t pt-2">
                                    <span>Total:</span>
                                    <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <div>
                            @if(request('paymentMethod') == 'cash')
                                <!-- Cash Payment Details -->
                                <h2 class="text-lg font-semibold mb-4">Detail Pembayaran Tunai</h2>
                                
                                @if(request('cashPaid'))
                                    <div class="space-y-4">
                                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                            <p class="text-sm text-green-600">Uang Diterima:</p>
                                            <p class="text-xl font-bold text-green-700">Rp {{ number_format(request('cashPaid'), 0, ',', '.') }}</p>
                                        </div>
                                        
                                        @if(request('change') > 0)
                                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                                <p class="text-sm text-blue-600">Kembalian:</p>
                                                <p class="text-xl font-bold text-blue-700">Rp {{ number_format(request('change'), 0, ',', '.') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                            @elseif(request('paymentMethod') == 'qris')
                                <!-- QRIS Payment Simulation -->
                                <h2 class="text-lg font-semibold mb-4">Pembayaran QRIS</h2>
                                <div class="bg-blue-50 p-6 rounded-lg text-center">
                                    <div class="text-6xl mb-4">📱</div>
                                    <p class="text-lg font-semibold mb-2">Mode Simulasi</p>
                                    <p class="text-sm text-gray-600 mb-4">Dalam mode produksi, QR Code akan ditampilkan di sini</p>
                                    <div class="bg-white p-4 rounded border-2 border-dashed border-blue-300">
                                        <p class="text-sm">QR Code untuk pembayaran</p>
                                        <p class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                            @elseif(request('paymentMethod') == 'debit')
                                <!-- Debit Payment Simulation -->
                                <h2 class="text-lg font-semibold mb-4">Pembayaran Kartu Debit</h2>
                                <div class="bg-purple-50 p-6 rounded-lg text-center">
                                    <div class="text-6xl mb-4">💳</div>
                                    <p class="text-lg font-semibold mb-2">Mode Simulasi</p>
                                    <p class="text-sm text-gray-600 mb-4">Dalam mode produksi, akan terhubung dengan payment gateway</p>
                                    <div class="bg-white p-4 rounded border-2 border-dashed border-purple-300">
                                        <p class="text-sm">Terminal EDC</p>
                                        <p class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Customer Info -->
                            <div class="mt-6">
                                <h3 class="text-md font-semibold mb-3">Informasi Pelanggan (Opsional)</h3>
                                <div class="space-y-3">
                                    <input type="text" name="customerName" placeholder="Nama Pelanggan" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <input type="text" name="customerPhone" placeholder="No. Telepon" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="flex space-x-4 mt-6">
                                <a href="{{ route('pos.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-3 px-4 rounded-lg text-center font-medium hover:bg-gray-300 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-green-600 text-white py-3 px-4 rounded-lg font-medium hover:shadow-lg transition-all duration-200">
                                    @if(request('paymentMethod') == 'cash')
                                        Selesaikan Transaksi
                                    @else
                                        Konfirmasi Pembayaran
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
