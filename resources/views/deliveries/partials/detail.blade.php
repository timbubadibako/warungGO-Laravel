<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-xl p-6 border">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-xl font-bold text-gray-900">{{ $order->invoice_number }}</h4>
                <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-800',
                        'preparing' => 'bg-blue-100 text-blue-800',
                        'out_for_delivery' => 'bg-purple-100 text-purple-800',
                        'delivered' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800'
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'preparing' => 'Sedang Diproses',
                        'out_for_delivery' => 'Sedang Dikirim',
                        'delivered' => 'Terkirim',
                        'cancelled' => 'Dibatalkan'
                    ];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->delivery_status] }}">
                    {{ $statusLabels[$order->delivery_status] }}
                </span>
                <p class="text-sm text-gray-600 mt-1">{{ $order->payment_method === 'cash' ? 'Tunai' : ucfirst($order->payment_method) }}</p>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-map-pin class="w-5 h-5 mr-2 text-blue-600" />
            Informasi Pengiriman
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman:</p>
                <div class="bg-white rounded-lg p-4 border">
                    <p class="text-gray-900">{{ $order->customer_address ?: 'Alamat tidak tersedia' }}</p>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Catatan Pelanggan:</p>
                <div class="bg-white rounded-lg p-4 border">
                    <p class="text-gray-900">{{ $order->customer_notes ?: 'Tidak ada catatan khusus' }}</p>
                </div>
            </div>
        </div>
        @if($order->user)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">Dilayani oleh: <span class="font-medium text-gray-900">{{ $order->user->name }}</span></p>
            </div>
        @endif
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-xl border p-6">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-shopping-bag class="w-5 h-5 mr-2 text-green-600" />
            Detail Pesanan
        </h5>
        <div class="space-y-3">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                    <div class="flex-1">
                        <h6 class="font-medium text-gray-900">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</h6>
                        <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 border">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-calculator class="w-5 h-5 mr-2 text-purple-600" />
            Ringkasan Pembayaran
        </h5>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Subtotal:</span>
                <span class="font-medium">Rp {{ number_format($order->sub_total, 0, ',', '.') }}</span>
            </div>
            @if($order->tax > 0)
                <div class="flex justify-between">
                    <span class="text-gray-600">Pajak:</span>
                    <span class="font-medium">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($order->delivery_fee > 0)
                <div class="flex justify-between">
                    <span class="text-gray-600">Ongkos Kirim:</span>
                    <span class="font-medium">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
            @endif
            <hr class="border-gray-300">
            <div class="flex justify-between text-lg font-bold">
                <span class="text-gray-900">Total:</span>
                <span class="text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Status Pembayaran:</span>
                <span class="font-medium {{ $order->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $order->status === 'paid' ? 'Lunas' : ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Action Timeline (Dummy) -->
    <div class="bg-white rounded-xl border p-6">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-clock class="w-5 h-5 mr-2 text-orange-600" />
            Timeline Pengiriman
        </h5>
        <div class="space-y-4">
            <div class="flex items-start space-x-3">
                <div class="w-3 h-3 bg-green-500 rounded-full mt-2"></div>
                <div>
                    <p class="font-medium text-gray-900">Pesanan Dibuat</p>
                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @if($order->delivery_status !== 'pending')
                <div class="flex items-start space-x-3">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                    <div>
                        <p class="font-medium text-gray-900">Pesanan Diproses</p>
                        <p class="text-sm text-gray-600">Estimasi: {{ $order->created_at->addMinutes(15)->format('H:i') }}</p>
                    </div>
                </div>
            @endif
            @if(in_array($order->delivery_status, ['out_for_delivery', 'delivered']))
                <div class="flex items-start space-x-3">
                    <div class="w-3 h-3 bg-purple-500 rounded-full mt-2"></div>
                    <div>
                        <p class="font-medium text-gray-900">Sedang Dikirim</p>
                        <p class="text-sm text-gray-600">Estimasi: {{ $order->created_at->addMinutes(45)->format('H:i') }}</p>
                    </div>
                </div>
            @endif
            @if($order->delivery_status === 'delivered')
                <div class="flex items-start space-x-3">
                    <div class="w-3 h-3 bg-green-600 rounded-full mt-2"></div>
                    <div>
                        <p class="font-medium text-gray-900">Pesanan Terkirim</p>
                        <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    @if($order->delivery_status !== 'delivered' && $order->delivery_status !== 'cancelled')
        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
            <h5 class="font-semibold text-blue-900 mb-3">Aksi Cepat</h5>
            <div class="flex space-x-3">
                @if($order->delivery_status === 'pending')
                    <button onclick="quickUpdateStatus({{ $order->id }}, 'preparing')"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        Mulai Proses
                    </button>
                @elseif($order->delivery_status === 'preparing')
                    <button onclick="quickUpdateStatus({{ $order->id }}, 'out_for_delivery')"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                        Kirim Sekarang
                    </button>
                @elseif($order->delivery_status === 'out_for_delivery')
                    <button onclick="quickUpdateStatus({{ $order->id }}, 'delivered')"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                        Tandai Terkirim
                    </button>
                @endif
                <button onclick="quickUpdateStatus({{ $order->id }}, 'cancelled')"
                        class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                    Batalkan
                </button>
            </div>
        </div>
    @endif
</div>

<script>
function quickUpdateStatus(orderId, status) {
    if (status === 'cancelled' && !confirm('Yakin ingin membatalkan pesanan ini?')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/deliveries/${orderId}/status`;

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'delivery_status';
    statusInput.value = status;

    form.appendChild(csrfToken);
    form.appendChild(statusInput);
    document.body.appendChild(form);

    form.submit();
}
</script>
