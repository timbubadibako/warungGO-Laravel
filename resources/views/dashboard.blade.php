<x-app-layout>
    <div class="h-screen flex flex-col bg-gray-100">

        <!-- Header -->
        <header class="bg-white h-24 border-b px-6 flex-shrink-0 flex items-center">
            <div class="flex justify-between items-center w-full">
                <h1 class="text-2xl font-bold text-gray-800">Overview</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                        </span>
                        <input type="text" placeholder="Search..." class="w-full py-2 pl-10 pr-4 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button class="p-2 rounded-full hover:bg-gray-100">
                        <i data-lucide="bell" class="w-6 h-6 text-gray-600"></i>
                    </button>
                    <div class="flex items-center space-x-2">
                        <img class="w-10 h-10 rounded-full" src="https://placehold.co/40x40/7c3aed/ffffff?text={{ substr(Auth::user()->name, 0, 1) }}" alt="User avatar">
                        <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Konten Utama (Grid) yang mengisi sisa ruang -->
        <div class="flex-1 flex space-x-6 p-6 overflow-hidden">

            <!-- Kolom Kiri (Lebih Besar) -->
            <div x-data="{ chart: 'revenue' }" class="w-4/6 flex flex-col space-y-6 overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-800">Ringkasan Keuangan</h1>
                    <div class="flex gap-2">
                        <button @click="chart = 'revenue'" :class="chart === 'revenue' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'" class="px-4 py-2 rounded">Pendapatan</button>
                        <button @click="chart = 'stock'" :class="chart === 'stock' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'" class="px-4 py-2 rounded">Stok</button>
                        <button @click="chart = 'top'" :class="chart === 'top' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'" class="px-4 py-2 rounded">Terlaris</button>
                        <button @click="chart = 'transaksi'" :class="chart === 'transaksi' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'" class="px-4 py-2 rounded">Transaksi</button>
                    </div>
                </div>
                {{-- <h1 class="text-3xl font-bold text-gray-800">Ringkasan Keuangan</h1> --}}

                {{-- Kartu Grafik Utama (Portfolio) --}}
                <div class="flex-grow relative">
                    <div x-show="chart === 'revenue'" class="flex-grow bg-white rounded-xl p-6 shadow h-full">
                        <canvas id="chartRevenueProfit" class="h-full w-full bg-[#f8fafc]"></canvas>
                    </div>

                    <div x-show="chart === 'stock'" class="flex-grow bg-white rounded-xl p-6 shadow h-full">
                        <canvas id="chartStockFlow" class="h-full w-full bg-[#f8fafc]"></canvas>
                    </div>
                    <div x-show="chart === 'top'" class="flex-grow bg-white rounded-xl p-6 shadow h-full">
                        <canvas id="chartTopProducts" class="h-full w-full bg-[#f8fafc]"></canvas>
                    </div>
                    <div x-show="chart === 'transaksi'" class="flex-grow bg-white rounded-xl p-6 shadow h-full">
                        <canvas id="chartDailyTransactions" class="h-full w-full bg-[#f8fafc]"></canvas>
                    </div>
                </div>




                {{-- Kartu Tabel (Market) --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg text-gray-800">Produk Terlaris</h3>
                        <button class="text-sm font-medium text-gray-600 px-3 py-1">Lihat Semua</button>
                    </div>
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-gray-400 font-semibold">
                                <th class="py-2">Nama</th>
                                <th class="py-2">Harga</th>
                                <th class="py-2 text-center">Terjual (7 Hari)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                                <tr class="border-t border-gray-100">
                                    <td class="py-3">{{ $item->product->name }}</td>
                                    <td class="py-3">Rp {{ number_format($item->product->selling_price) }}</td>
                                    <td class="py-3 text-center text-green-500 font-semibold">{{ $item->total_quantity }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Belum ada data penjualan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan (Lebih Kecil) -->
            <div class="w-2/6 flex flex-col space-y-6 overflow-y-auto">
                <h1 class="text-3xl font-bold text-gray-800">Metrik Utama</h1>

                {{-- Kartu Aset/Metrik --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-start">
                        <p class="font-semibold text-gray-700">Pendapatan (Hari Ini)</p>
                        <i data-lucide="wallet" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($todaysRevenue) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-start">
                        <p class="font-semibold text-gray-700">Keuntungan (Hari Ini)</p>
                        <i data-lucide="trending-up" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($todaysProfit) }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-start">
                        <p class="font-semibold text-gray-700">Transaksi (Hari Ini)</p>
                        <i data-lucide="shopping-basket" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <p class="text-2xl font-bold mt-2">{{ $todaysTransactions }}</p>
                </div>

                {{-- Kartu Promosi (Earn) --}}
                <div class="bg-gray-800 rounded-xl shadow-lg p-6 text-white flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-lg">Tambah Produk Baru</h3>
                        <p class="text-sm text-gray-300 mt-2">Perbarui katalog Anda dengan menambahkan produk baru ke dalam sistem.</p>
                    </div>
                    <a href="{{ route('products.create') }}" class="w-full mt-4 bg-white text-gray-800 font-bold py-2 rounded-lg hover:bg-gray-200 text-center">
                        Tambah Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // === Chart 1: Pendapatan vs Keuntungan (Line) ===
    const revenueProfit = @json($revenueProfitChart);
    const ctx1 = document.getElementById("chartRevenueProfit");
    if (ctx1) {
        new Chart(ctx1.getContext('2d'), {
            type: 'line',
            data: {
                labels: revenueProfit.labels,
                datasets: [
                    {
                        label: "Pendapatan",
                        data: revenueProfit.revenue,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: "Keuntungan",
                        data: revenueProfit.profit,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // === Chart 2: Barang Masuk vs Keluar (Bar) ===
    const stockFlow = @json($stockFlowChart);
    const ctx2 = document.getElementById("chartStockFlow");
    if (ctx2) {
        new Chart(ctx2.getContext('2d'), {
            type: 'bar',
            data: {
                labels: stockFlow.labels,
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: stockFlow.in,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Barang Keluar',
                        data: stockFlow.out,
                        backgroundColor: 'rgba(239, 68, 68, 0.7)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // === Chart 3: Produk Terlaris (Pie) ===
    const topProducts = @json($topProductsChart);
    const ctx3 = document.getElementById("chartTopProducts");
    if (ctx3) {
        new Chart(ctx3.getContext('2d'), {
            type: 'pie',
            data: {
                labels: topProducts.labels,
                datasets: [{
                    label: 'Produk Terlaris',
                    data: topProducts.data,
                    backgroundColor: [
                        '#60a5fa', '#f87171', '#34d399', '#fbbf24', '#a78bfa'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // === Chart 4: Jumlah Transaksi Harian (Line) ===
    const trx = @json($dailyTransactionsChart);
    const ctx4 = document.getElementById("chartDailyTransactions");
    if (ctx4) {
        new Chart(ctx4.getContext('2d'), {
            type: 'line',
            data: {
                labels: trx.labels,
                datasets: [{
                    label: 'Transaksi',
                    data: trx.data,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
@endpush

</x-app-layout>
