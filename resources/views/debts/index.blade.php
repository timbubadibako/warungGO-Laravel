<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Daftar Hutang Pelanggan
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola daftar hutang pelanggan untuk memantau pembayaran</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <x-stat-card
                    iconBg="bg-gradient-to-r from-red-400 to-red-500"
                    title="Total Hutang"
                    :value="$unpaidDebts->count()"
                >
                    <x-slot name="icon">
                        <x-lucide-alert-circle class="w-6 h-6 text-white" />
                    </x-slot>
                </x-stat-card>
                <x-stat-card
                    iconBg="bg-gradient-to-r from-orange-400 to-orange-500"
                    title="Jumlah Hutang"
                    :value="'Rp ' . number_format($unpaidDebts->sum('amount'), 0, ',', '.')"
                >
                    <x-slot name="icon">
                        <x-lucide-banknote class="w-6 h-6 text-white" />
                    </x-slot>
                </x-stat-card>
                <x-stat-card
                    iconBg="bg-gradient-to-r from-amber-400 to-amber-500"
                    title="Rata-rata per Hutang"
                    :value="'Rp ' . ($unpaidDebts->count() > 0 ? number_format($unpaidDebts->avg('amount'), 0, ',', '.') : '0')"
                >
                    <x-slot name="icon">
                        <x-lucide-clock class="w-6 h-6 text-white" />
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <x-lucide-check-circle class="w-5 h-5 text-green-600 mr-3" />
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Debts List -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm">
                <div class="p-6 border-b border-gray-200/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                                <x-lucide-list class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Daftar Hutang Belum Lunas</h3>
                                <p class="text-sm text-gray-600">Kelola pembayaran hutang pelanggan</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Total: {{ $unpaidDebts->count() }} hutang</p>
                            <p class="text-lg font-bold text-red-600">Rp {{ number_format($unpaidDebts->sum('amount'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if($unpaidDebts->count() > 0)
                        <div class="space-y-4">
                            @foreach($unpaidDebts as $debt)
                                <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl border border-red-200/50 hover:shadow-md transition-all p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                                                    <x-lucide-receipt class="w-5 h-5 text-white" />
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-800">{{ $debt->order->invoice_number ?? 'N/A' }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $debt->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div class="ml-auto">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Belum Lunas
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700 mb-1">Nama Pelanggan:</p>
                                                    <p class="text-gray-900 bg-white/70 rounded-lg p-3 border">
                                                        {{ $debt->customer_name ?: 'Pelanggan umum' }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700 mb-1">Alamat/Catatan:</p>
                                                    <p class="text-gray-900 bg-white/70 rounded-lg p-3 border">
                                                        {{ $debt->order->customer_address ?: $debt->order->customer_notes ?: 'Tidak ada catatan' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-6">
                                                    <div>
                                                        <p class="text-sm text-gray-600">Jumlah Hutang</p>
                                                        <p class="text-2xl font-bold text-red-600">Rp {{ number_format($debt->amount, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-600">Jatuh Tempo</p>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $debt->created_at->addDays(30)->format('d M Y') }}
                                                            @if($debt->created_at->addDays(30)->isPast())
                                                                <span class="text-red-600 font-bold">(Terlambat)</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-600">Umur Hutang</p>
                                                        <p class="text-sm font-medium text-gray-900">{{ $debt->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="viewDebtDetails({{ $debt->id }})"
                                                            class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                        <x-lucide-eye class="w-4 h-4 inline mr-1" />
                                                        Detail
                                                    </button>
                                                    <button onclick="confirmPayment({{ $debt->id }}, '{{ $debt->customer_name }}', {{ $debt->amount }})"
                                                            class="bg-green-100 text-green-700 hover:bg-green-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                        <x-lucide-check-circle class="w-4 h-4 inline mr-1" />
                                                        Tandai Lunas
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-lucide-check-circle class="w-12 h-12 text-green-500" />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Hutang!</h3>
                            <p class="text-gray-600">Semua hutang pelanggan sudah lunas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Confirmation Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Pembayaran</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
            <div class="mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                    <div class="flex items-start">
                        <x-lucide-alert-triangle class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" />
                        <div>
                            <p class="text-yellow-800 font-medium mb-1">Konfirmasi Pembayaran Hutang</p>
                            <p class="text-yellow-700 text-sm">Pastikan pelanggan sudah benar-benar melunasi hutang sebelum menandai sebagai lunas.</p>
                        </div>
                    </div>
                </div>
                <div id="paymentInfo" class="space-y-2">
                    <!-- Payment info will be filled by JavaScript -->
                </div>
            </div>
            <form id="paymentForm" method="post" class="space-y-4">
                @csrf
                @method('patch')
                <div class="flex space-x-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium py-3 px-6 rounded-xl hover:from-green-700 hover:to-green-800 transition-all">
                        Ya, Tandai Lunas
                    </button>
                    <button type="button" onclick="closePaymentModal()" class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Debt Details Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Detail Hutang</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
            <div id="detailContent">
                <!-- Detail content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function confirmPayment(debtId, customerName, amount) {
            document.getElementById('paymentInfo').innerHTML = `
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Pelanggan:</p>
                            <p class="font-medium text-gray-900">${customerName || 'Pelanggan umum'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jumlah Hutang:</p>
                            <p class="font-bold text-red-600">Rp ${new Intl.NumberFormat('id-ID').format(amount)}</p>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('paymentForm').action = `/debts/${debtId}/pay`;
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paymentModal').classList.add('flex');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('paymentModal').classList.remove('flex');
        }

        function viewDebtDetails(debtId) {
            // You can implement AJAX call here to fetch debt details
            fetch(`/debts/${debtId}/details`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailContent').innerHTML = data.html;
                    document.getElementById('detailModal').classList.remove('hidden');
                    document.getElementById('detailModal').classList.add('flex');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail hutang');
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }

        // Close modals when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    </script>
</x-app-layout>

