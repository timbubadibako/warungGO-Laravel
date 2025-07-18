<div class="space-y-6">
    <!-- Debt Header -->
    <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-6 border border-red-200">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-xl font-bold text-gray-900">{{ $debt->order->invoice_number ?? 'N/A' }}</h4>
                <p class="text-gray-600">{{ $debt->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    Belum Lunas
                </span>
                <p class="text-sm text-gray-600 mt-1">{{ $debt->order->payment_method === 'debt' ? 'Hutang' : ucfirst($debt->order->payment_method) }}</p>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-user class="w-5 h-5 mr-2 text-blue-600" />
            Informasi Pelanggan
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Nama Pelanggan:</p>
                <div class="bg-white rounded-lg p-4 border">
                    <p class="text-gray-900">{{ $debt->customer_name ?: 'Pelanggan umum' }}</p>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Alamat/Catatan:</p>
                <div class="bg-white rounded-lg p-4 border">
                    <p class="text-gray-900">{{ $debt->order->customer_address ?: $debt->order->customer_notes ?: 'Tidak ada informasi' }}</p>
                </div>
            </div>
        </div>
        @if($debt->order->user)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">Dilayani oleh: <span class="font-medium text-gray-900">{{ $debt->order->user->name }}</span></p>
            </div>
        @endif
    </div>

    <!-- Order Items -->
    @if($debt->order && $debt->order->items->count() > 0)
        <div class="bg-white rounded-xl border p-6">
            <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
                <x-lucide-shopping-bag class="w-5 h-5 mr-2 text-green-600" />
                Detail Pembelian
            </h5>
            <div class="space-y-3">
                @foreach($debt->order->items as $item)
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
    @endif

    <!-- Debt Summary -->
    <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-6 border border-red-200">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-calculator class="w-5 h-5 mr-2 text-purple-600" />
            Ringkasan Hutang
        </h5>
        <div class="space-y-3">
            @if($debt->order)
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal Pembelian:</span>
                    <span class="font-medium">Rp {{ number_format($debt->order->sub_total, 0, ',', '.') }}</span>
                </div>
                @if($debt->order->tax > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pajak:</span>
                        <span class="font-medium">Rp {{ number_format($debt->order->tax, 0, ',', '.') }}</span>
                    </div>
                @endif
                @if($debt->order->delivery_fee > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim:</span>
                        <span class="font-medium">Rp {{ number_format($debt->order->delivery_fee, 0, ',', '.') }}</span>
                    </div>
                @endif
                <hr class="border-gray-300">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Pembelian:</span>
                    <span class="font-medium">Rp {{ number_format($debt->order->total_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            <hr class="border-red-300">
            <div class="flex justify-between text-lg font-bold">
                <span class="text-red-800">Total Hutang:</span>
                <span class="text-red-800">Rp {{ number_format($debt->amount, 0, ',', '.') }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-red-200">
                <div>
                    <p class="text-sm text-gray-600">Tanggal Hutang:</p>
                    <p class="font-medium text-gray-900">{{ $debt->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jatuh Tempo:</p>
                    <p class="font-medium {{ $debt->created_at->addDays(30)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $debt->created_at->addDays(30)->format('d M Y') }}
                        @if($debt->created_at->addDays(30)->isPast())
                            <span class="text-xs">(Terlambat)</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Timeline (Dummy) -->
    <div class="bg-white rounded-xl border p-6">
        <h5 class="font-semibold text-gray-900 mb-4 flex items-center">
            <x-lucide-clock class="w-5 h-5 mr-2 text-orange-600" />
            Timeline Hutang
        </h5>
        <div class="space-y-4">
            <div class="flex items-start space-x-3">
                <div class="w-3 h-3 bg-red-500 rounded-full mt-2"></div>
                <div>
                    <p class="font-medium text-gray-900">Hutang Dibuat</p>
                    <p class="text-sm text-gray-600">{{ $debt->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @if($debt->created_at->addDays(7)->isPast())
                <div class="flex items-start space-x-3">
                    <div class="w-3 h-3 bg-orange-500 rounded-full mt-2"></div>
                    <div>
                        <p class="font-medium text-gray-900">Reminder 1 Minggu</p>
                        <p class="text-sm text-gray-600">{{ $debt->created_at->addDays(7)->format('d M Y') }}</p>
                    </div>
                </div>
            @endif
            @if($debt->created_at->addDays(30)->isPast())
                <div class="flex items-start space-x-3">
                    <div class="w-3 h-3 bg-red-600 rounded-full mt-2"></div>
                    <div>
                        <p class="font-medium text-red-600">Jatuh Tempo Terlewat</p>
                        <p class="text-sm text-red-600">{{ $debt->created_at->addDays(30)->format('d M Y') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-green-50 rounded-xl p-6 border border-green-200">
        <h5 class="font-semibold text-green-900 mb-3">Aksi Cepat</h5>
        <div class="flex space-x-3">
            <button onclick="quickPayDebt({{ $debt->id }}, '{{ $debt->customer_name }}', {{ $debt->amount }})"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors">
                <x-lucide-check-circle class="w-4 h-4 inline mr-2" />
                Tandai Lunas Sekarang
            </button>
            <button onclick="printDebtDetails()"
                    class="bg-blue-100 text-blue-700 px-6 py-3 rounded-lg font-medium hover:bg-blue-200 transition-colors">
                <x-lucide-printer class="w-4 h-4 inline mr-2" />
                Cetak Detail
            </button>
        </div>
    </div>
</div>

<script>
function quickPayDebt(debtId, customerName, amount) {
    if (confirm(`Yakin ingin menandai hutang atas nama "${customerName}" sebesar Rp ${new Intl.NumberFormat('id-ID').format(amount)} sebagai lunas?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/debts/${debtId}/pay`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);

        form.submit();
    }
}

function printDebtDetails() {
    window.print();
}
</script>
