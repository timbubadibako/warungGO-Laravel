<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">
        <!-- Main Dashboard Content -->
        <div class="p-6 space-y-6">

            <!-- Welcome Section -->
            <x-welcome-section />


            {{-- stats cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-stat-card
                    iconBg="bg-gradient-to-br from-green-400 to-green-600"
                    title="Penjualan Hari Ini"
                    :value="'Rp ' . number_format($todaysRevenue ?? 0)"
                    :desc="($todaysTransactions ?? 0) . ' transaksi'"
                    :badge="$salesGrowth ?? '0%'"
                    badgeBg="bg-green-50"
                    badgeText="text-green-600"
                    effectBg="bg-gradient-to-r from-green-500/5 to-green-600/5"
                    hoverMain="text-green-600"
                    transitionDelay="0ms"
                >
                    <x-slot name="icon">
                        <x-lucide-trending-up class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                    </x-slot>
                </x-stat-card>

                <x-stat-card
                    iconBg="bg-gradient-to-br from-blue-400 to-blue-600"
                    title="Total Produk"
                    :value="$totalProducts ?? 0"
                    :desc="($lowStockProducts->count() ?? 0) . ' stok rendah'"
                    :badge="$productGrowth ?? '+0'"
                    badgeBg="bg-blue-50"
                    badgeText="text-blue-600"
                    effectBg="bg-gradient-to-r from-blue-500/5 to-blue-600/5"
                    hoverMain="text-blue-600"
                    transitionDelay="100ms"
                >
                    <x-slot name="icon">
                        <x-lucide-package class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                    </x-slot>
                </x-stat-card>

                <x-stat-card
                    iconBg="bg-gradient-to-br from-purple-400 to-purple-600"
                    title="Supplier Aktif"
                    :value="$totalSuppliers ?? 0"
                    :desc="($recentPurchases ?? 0) . ' pembelian baru'"
                    :badge="$supplierGrowth ?? '+0'"
                    badgeBg="bg-purple-50"
                    badgeText="text-purple-600"
                    effectBg="bg-gradient-to-r from-purple-500/5 to-purple-600/5"
                    hoverMain="text-purple-600"
                    transitionDelay="200ms"
                >
                    <x-slot name="icon">
                        <x-lucide-users class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                    </x-slot>
                </x-stat-card>

                <x-stat-card
                    iconBg="bg-gradient-to-br from-orange-400 to-orange-600"
                    title="Pertumbuhan Bulan Ini"
                    :value="'+' . ($monthlyGrowth ?? '0') . '%'"
                    :desc="'vs bulan lalu'"
                    :badge="$monthlyGrowth ?? '0%'"
                    badgeBg="bg-orange-50"
                    badgeText="text-orange-600"
                    effectBg="bg-gradient-to-r from-orange-500/5 to-orange-600/5"
                    hoverMain="text-orange-600"
                    transitionDelay="300ms"
                >
                    <x-slot name="icon">
                        <x-lucide-bar-chart-3 class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-12 gap-6"
                x-data="{ mainCardsLoaded: false, chart: 'revenue' }"
                x-init="setTimeout(() => mainCardsLoaded = true, 600)">

                <!-- Left Column: Charts and Analytics -->
                <div class="col-span-12 lg:col-span-8 space-y-6">
                    <!-- Sales Chart Dashboard Card (Aktif & Responsive) -->
                    <div
                        class="relative bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500"
                        :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 0ms;"
                    >
                        <!-- Header Metrics -->
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-blue-50/50 group-hover:to-green-50/50 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <x-dashboard.metrics-header
                                    title="Pendapatan"
                                    description="Total pendapatan bulan ini"
                                />
                                <x-dashboard.metrics-button />
                            </div>
                        </div>

                        <!-- Chart Container -->
                        <div class="p-6 group-hover:bg-gradient-to-br group-hover:from-white group-hover:to-blue-50/30 transition-all duration-300">
                            <div class="h-80 bg-gradient-to-br from-gray-50 to-blue-50/30 rounded-xl p-4 border border-gray-100">
                                <div x-show="chart === 'revenue'" class="h-full w-full">
                                    <canvas id="chartRevenueProfit" class="h-full w-full"></canvas>
                                </div>
                                <div x-show="chart === 'stock'" class="h-full w-full">
                                    <canvas id="chartStockFlow" class="h-full w-full"></canvas>
                                </div>
                                <div x-show="chart === 'top'" class="h-full w-full">
                                    <canvas id="chartTopProducts" class="h-full w-full"></canvas>
                                </div>
                                <div x-show="chart === 'transaksi'" class="h-full w-full">
                                    <canvas id="chartDailyTransactions" class="h-full w-full"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Performance -->
                    <div class="relative bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500"
                        :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 0ms;"
                    >
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-blue-50/50 group-hover:to-green-50/50 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <x-dashboard.metrics-header
                                    title="Performa Kategori"
                                    description="Kategori produk terlaris"
                                />
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($categoryPerformance as $category)
                                    <div class="flex items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-100 transition-all duration-150">
                                        <div class="w-12 h-12 {{ $category['color'] }} rounded-xl flex items-center justify-center mr-4 transition-transform duration-150 hover:scale-105">
                                            <x-lucide-bar-chart-3 class="w-6 h-6 text-white" />
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $category['name'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $category['sales'] }} penjualan - Rp {{ number_format($category['revenue']) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Actions and Status -->
                <div class="col-span-12 lg:col-span-4 space-y-6">

                    <!-- Quick Actions -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden transition-all duration-200"
                        :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 100ms;">
                        <div class="p-6 border-b border-gray-200/50">
                            <h2 class="text-xl font-bold text-gray-800">Aksi Cepat</h2>
                            <p class="text-gray-500 text-sm">Fitur yang sering digunakan</p>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('pos.index') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-xl hover:bg-blue-100 transition-all duration-150">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-green-500 rounded-xl flex items-center justify-center mr-4 transition-transform duration-150 hover:scale-105">
                                    <x-lucide-calculator class="w-6 h-6 text-white" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Point of Sale</p>
                                    <p class="text-sm text-gray-500">Mulai transaksi penjualan</p>
                                </div>
                            </a>

                            <a href="{{ route('products.create') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-all duration-150">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 transition-transform duration-150 hover:scale-105">
                                    <x-lucide-plus class="w-6 h-6 text-white" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Tambah Produk</p>
                                    <p class="text-sm text-gray-500">Tambah produk baru</p>
                                </div>
                            </a>

                            <a href="{{ route('purchases.create') }}" class="flex items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-all duration-150">
                                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-4 transition-transform duration-150 hover:scale-105">
                                    <x-lucide-shopping-bag class="w-6 h-6 text-white" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Catat Pembelian</p>
                                    <p class="text-sm text-gray-500">Tambah pembelian stok</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Low Stock Alert -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden transition-all duration-200"
                        :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 300ms;">
                        <div class="p-6 border-b border-gray-200/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">Stok Rendah</h2>
                                    <p class="text-gray-500 text-sm">Produk yang perlu di-restock</p>
                                </div>
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-semibold">{{ $allLowStockProductsCount ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @forelse($lowStockProducts as $product)
                                    <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-lg hover:bg-red-100 transition-all duration-150">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 transition-transform duration-150 hover:scale-105">
                                                <x-lucide-alert-triangle class="w-5 h-5 text-red-600" />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $product->stock }} stok tersisa</p>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-all duration-150 hover:bg-blue-50 px-3 py-1 rounded-lg">
                                            Restock
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-400 py-6">
                                        <x-lucide-check-circle class="w-12 h-12 mx-auto mb-2 text-green-400" />
                                        Semua stok aman
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden transition-all duration-200"
                        :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 500ms;">
                        <div class="p-6 border-b border-gray-200/50">
                            <h2 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h2>
                            <p class="text-gray-500 text-sm">Log aktivitas sistem</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-3 hover:bg-gray-100 p-2 rounded-lg transition-all duration-150">
                                        <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-lg flex items-center justify-center flex-shrink-0 transition-transform duration-150 hover:scale-105">
                                            <x-lucide-{{ $activity['icon'] }} class="w-4 h-4 text-{{ $activity['color'] }}-600" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-800 text-sm">{{ $activity['action'] }}</p>
                                            <p class="text-gray-500 text-xs">{{ $activity['desc'] }}</p>
                                            <p class="text-gray-400 text-xs mt-1">{{ $activity['time'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        /* ... (CSS animasi seperti sebelumnya) ... */
    </style>
    <script>
    // Chart.js dynamic render for Alpine and tab switching
    window.chartInstances = {};

    window.renderChart = function(type) {
        // Destroy all chart instances first for memory safety
        Object.keys(window.chartInstances).forEach(key => {
            window.chartInstances[key]?.destroy();
            window.chartInstances[key] = null;
        });

        // Data from backend
        const revenueProfit = @json($revenueProfitChart);
        const stockFlow = @json($stockFlowChart);
        const topProducts = @json($topProductsChart);
        const trx = @json($dailyTransactionsChart);

        if (type === 'revenue') {
            const ctx = document.getElementById("chartRevenueProfit");
            if (ctx) {
                window.chartInstances['revenue'] = new Chart(ctx.getContext('2d'), {
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
        } else if (type === 'stock') {
            const ctx = document.getElementById("chartStockFlow");
            if (ctx) {
                window.chartInstances['stock'] = new Chart(ctx.getContext('2d'), {
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
        } else if (type === 'top') {
            const ctx = document.getElementById("chartTopProducts");
            if (ctx) {
                window.chartInstances['top'] = new Chart(ctx.getContext('2d'), {
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
        } else if (type === 'transaksi') {
            const ctx = document.getElementById("chartDailyTransactions");
            if (ctx) {
                window.chartInstances['transaksi'] = new Chart(ctx.getContext('2d'), {
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
        }
    };

    // On DOMContentLoaded, render the first chart
    document.addEventListener("DOMContentLoaded", function () {
        window.renderChart('revenue');
    });
    </script>
    @endpush
</x-app-layout>
