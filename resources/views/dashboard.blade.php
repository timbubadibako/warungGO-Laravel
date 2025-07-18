<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">
        <x-slot name="headerCenter">
            <!-- Quick Stats Header -->
            <div class="flex items-center space-x-6 bg-white/50 rounded-xl px-4 py-2">
                <div class="text-center">
                    <div class="text-xs text-gray-500">Hari Ini</div>
                    <div class="text-sm font-bold text-green-600">{{ $todaysTransactions ?? 0 }} Transaksi</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500">Revenue</div>
                    <div class="text-sm font-bold text-blue-600">Rp {{ number_format($todaysRevenue ?? 0) }}</div>
                </div>
            </div>
        </x-slot>

        <!-- Main Dashboard Content -->
        <div class="p-6 space-y-6">

            <!-- Welcome Section -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-green-600 rounded-3xl p-8 text-white">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold mb-2">Selamat Datang di Warung GO! 👋</h1>
                            <p class="text-blue-100 text-lg">{{ now()->format('l, d F Y') }} - Kelola warung Anda dengan mudah</p>
                        </div>
                        <div class="hidden lg:block">
                            <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center">
                                <x-lucide-store class="w-16 h-16 text-white" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
                <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-white/5 rounded-full"></div>
            </div>

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Today's Sales -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <x-lucide-trending-up class="w-6 h-6 text-white" />
                        </div>
                        <span class="text-sm text-green-600 font-semibold bg-green-50 px-2 py-1 rounded-full">{{ $salesGrowth ?? '0%' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Penjualan Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($todaysRevenue ?? 0) }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $todaysTransactions ?? 0 }} transaksi</p>
                </div>

                <!-- Total Products -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <x-lucide-package class="w-6 h-6 text-white" />
                        </div>
                        <span class="text-sm text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded-full">{{ $productGrowth ?? '+0' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Total Produk</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalProducts ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $lowStockProducts->count() ?? 0 }} stok rendah</p>
                </div>

                <!-- Active Suppliers -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <x-lucide-users class="w-6 h-6 text-white" />
                        </div>
                        <span class="text-sm text-purple-600 font-semibold bg-purple-50 px-2 py-1 rounded-full">{{ $supplierGrowth ?? '+0' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Supplier Aktif</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSuppliers ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $recentPurchases ?? 0 }} pembelian baru</p>
                </div>

                <!-- Monthly Growth -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <x-lucide-bar-chart-3 class="w-6 h-6 text-white" />
                        </div>
                        <span class="text-sm text-orange-600 font-semibold bg-orange-50 px-2 py-1 rounded-full">{{ $monthlyGrowth ?? '0%' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Pertumbuhan Bulan Ini</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1">+{{ $monthlyGrowth ?? '0' }}%</p>
                    <p class="text-sm text-gray-500 mt-2">vs bulan lalu</p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-12 gap-6">

                <!-- Left Column: Charts and Analytics -->
                <div class="col-span-12 lg:col-span-8 space-y-6">

                    <!-- Sales Chart -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">Analisis Penjualan</h2>
                                    <p class="text-gray-500 text-sm">Tren penjualan 7 hari terakhir</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">7H</button>
                                    <button class="px-3 py-1 text-sm text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">30H</button>
                                    <button class="px-3 py-1 text-sm text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">3B</button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <canvas id="salesChart" class="w-full h-64"></canvas>
                        </div>
                    </div>

                    <!-- Category Performance -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200/50">
                            <h2 class="text-xl font-bold text-gray-800">Performa Kategori</h2>
                            <p class="text-gray-500 text-sm">Kategori produk terlaris</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($categoryPerformance as $category)
                                    <div class="flex items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                                        <div class="w-12 h-12 {{ $category['color'] }} rounded-xl flex items-center justify-center mr-4">
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
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200/50">
                            <h2 class="text-xl font-bold text-gray-800">Aksi Cepat</h2>
                            <p class="text-gray-500 text-sm">Fitur yang sering digunakan</p>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('pos.index') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-xl hover:from-blue-100 hover:to-green-100 transition-all group">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-green-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <x-lucide-calculator class="w-6 h-6 text-white" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Point of Sale</p>
                                    <p class="text-sm text-gray-500">Mulai transaksi penjualan</p>
                                </div>
                            </a>

                            <a href="{{ route('products.create') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-all group">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <x-lucide-plus class="w-6 h-6 text-white" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Tambah Produk</p>
                                    <p class="text-sm text-gray-500">Tambah produk baru</p>
                                </div>
                            </a>

                            <a href="{{ route('purchases.create') }}" class="flex items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-all group">
                                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
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
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">Stok Rendah</h2>
                                    <p class="text-gray-500 text-sm">Produk yang perlu di-restock</p>
                                </div>
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-semibold">{{ $lowStockProducts->count() ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @forelse($lowStockProducts as $product)
                                    <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-lucide-alert-triangle class="w-5 h-5 text-red-600" />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $product->stock }} stok tersisa</p>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Restock
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-400 py-6">Semua stok aman</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-200/50">
                            <h2 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h2>
                            <p class="text-gray-500 text-sm">Log aktivitas sistem</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-lg flex items-center justify-center flex-shrink-0">
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
    <script>
        // Sales Chart Configuration (Dynamic)
        const revenueProfit = @json($revenueProfitChart ?? ['labels'=>[], 'revenue'=>[], 'profit'=>[]]);
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueProfit.labels,
                datasets: [
                    {
                        label: 'Penjualan (Rp)',
                        data: revenueProfit.revenue,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Keuntungan (Rp)',
                        data: revenueProfit.profit,
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderDash: [5, 5],
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
                    {{-- <!-- Chart Navigation -->
                    <div x-data="{ chart: 'revenue' }" class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-1">Analytics Dashboard</h2>
                                <p class="text-gray-600 text-sm">Visualisasi data bisnis Anda</p>
                            </div>
                            <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
                                <button
                                    @click="chart = 'revenue'"
                                    :class="chart === 'revenue' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                                    Pendapatan
                                </button>
                                <button
                                    @click="chart = 'stock'"
                                    :class="chart === 'stock' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg shadow-green-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                                    Stok
                                </button>
                                <button
                                    @click="chart = 'top'"
                                    :class="chart === 'top' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg shadow-purple-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                                    Terlaris
                                </button>
                                <button
                                    @click="chart = 'transaksi'"
                                    :class="chart === 'transaksi' ? 'bg-gradient-to-r from-orange-600 to-orange-700 text-white shadow-lg shadow-orange-500/25' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                    class="px-4 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                                    Transaksi
                                </button>
                            </div>
                        </div>

                        <!-- Chart Container -->
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

                <!-- Top Products Table -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Produk Terlaris</h3>
                                    <p class="text-sm text-gray-600">7 hari terakhir</p>
                                </div>
                            </div>
                            <a href="{{ route('products.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                Lihat Semua →
                            </a>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-gray-200">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($topProducts as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $item->product->name }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-600">Rp {{ number_format($item->product->selling_price) }}</td>
                                            <td class="px-4 py-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $item->total_quantity }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    Belum ada data penjualan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section: Metrics and Quick Actions -->
            <div class="col-span-12 xl:col-span-4 space-y-6">

                <!-- Key Metrics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-4">
                    <!-- Today's Revenue -->
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-xl border border-blue-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-blue-200">Hari Ini</div>
                                <div class="text-2xl font-bold">Rp {{ number_format($todaysRevenue) }}</div>
                                <div class="text-sm text-blue-200">Pendapatan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Profit -->
                    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-6 text-white shadow-xl border border-green-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-green-200">Hari Ini</div>
                                <div class="text-2xl font-bold">Rp {{ number_format($todaysProfit) }}</div>
                                <div class="text-sm text-green-200">Keuntungan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Transactions -->
                    <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-6 text-white shadow-xl border border-purple-500/20">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4l1-12z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-purple-200">Hari Ini</div>
                                <div class="text-2xl font-bold">{{ $todaysTransactions }}</div>
                                <div class="text-sm text-purple-200">Transaksi</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 text-white shadow-xl border border-slate-700/50">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Quick Actions</h3>
                            <p class="text-slate-400 text-sm">Akses cepat ke fitur utama</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('products.create') }}" class="block w-full bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl p-3 transition-all duration-300 hover:scale-105">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Tambah Produk</div>
                                    <div class="text-xs text-slate-400">Produk baru ke katalog</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('pos.index') }}" class="block w-full bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl p-3 transition-all duration-300 hover:scale-105">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4l1-12z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Buka POS</div>
                                    <div class="text-xs text-slate-400">Mulai penjualan</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('purchases.create') }}" class="block w-full bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl p-3 transition-all duration-300 hover:scale-105">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-600/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Input Pembelian</div>
                                    <div class="text-xs text-slate-400">Catat pembelian stok</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

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

