<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">
        <!-- Main Dashboard Content -->
        <div class="p-6 space-y-6">

            <!-- Welcome Section -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-green-600 rounded-3xl p-8 text-white transform hover:scale-[1.02] transition-all duration-700 ease-out shadow-2xl hover:shadow-blue-500/25"
                 x-data="{ loaded: false }"
                 x-init="setTimeout(() => loaded = true, 100)">

                <!-- Animated background overlay -->
                <div class="absolute inset-0 bg-black/10 animate-pulse"></div>

                <!-- Floating particles animation -->
                <div class="absolute inset-0">
                    <div class="absolute w-2 h-2 bg-white/20 rounded-full animate-bounce" style="top: 20%; left: 10%; animation-delay: 0s; animation-duration: 3s;"></div>
                    <div class="absolute w-1 h-1 bg-white/30 rounded-full animate-bounce" style="top: 60%; left: 20%; animation-delay: 1s; animation-duration: 4s;"></div>
                    <div class="absolute w-3 h-3 bg-white/15 rounded-full animate-bounce" style="top: 30%; right: 30%; animation-delay: 2s; animation-duration: 3.5s;"></div>
                    <div class="absolute w-1.5 h-1.5 bg-white/25 rounded-full animate-bounce" style="top: 70%; right: 15%; animation-delay: 0.5s; animation-duration: 2.8s;"></div>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="space-y-4">
                            <!-- Animated title -->
                            <h1 class="text-4xl font-bold mb-2 transform transition-all duration-1000 ease-out"
                                :class="loaded ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                                <span class="inline-block animate-pulse">Selamat Datang di</span>
                                <span class="inline-block bg-gradient-to-r from-yellow-300 to-yellow-100 bg-clip-text text-transparent font-extrabold animate-bounce">Warung GO!</span>
                                <span class="inline-block animate-bounce" style="animation-delay: 0.2s;">👋</span>
                            </h1>

                            <!-- Animated subtitle -->
                            <p class="text-blue-100 text-lg transform transition-all duration-1000 ease-out delay-300"
                               :class="loaded ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                                <span class="inline-block animate-pulse" style="animation-delay: 1s;">{{ now()->format('l, d F Y') }}</span>
                                <span class="mx-2">-</span>
                                <span class="inline-block font-semibold bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm border border-white/20 hover:bg-white/30 transition-colors duration-300">
                                    Kelola warung Anda dengan mudah
                                </span>
                            </p>

                            <!-- Animated stats pills -->
                            <div class="flex flex-wrap gap-3 mt-4 transform transition-all duration-1000 ease-out delay-500"
                                 :class="loaded ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                                <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-3 py-2 rounded-full border border-white/20 hover:bg-white/30 transition-all duration-300 hover:scale-105">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-medium">System Online</span>
                                </div>
                                <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-3 py-2 rounded-full border border-white/20 hover:bg-white/30 transition-all duration-300 hover:scale-105">
                                    <x-lucide-zap class="w-4 h-4 text-yellow-300 animate-pulse" />
                                    <span class="text-sm font-medium">Powered by Laravel</span>
                                </div>
                            </div>
                        </div>

                        <!-- Animated store icon -->
                        <div class="hidden lg:block transform transition-all duration-1000 ease-out delay-700"
                             :class="loaded ? 'translate-x-0 opacity-100 rotate-0' : 'translate-x-8 opacity-0 rotate-12'">
                            <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-500 hover:scale-110 hover:rotate-6 group">
                                <x-lucide-store class="w-16 h-16 text-white group-hover:scale-110 transition-transform duration-300" />
                                <!-- Pulsing ring -->
                                <div class="absolute inset-0 rounded-full border-2 border-white/30 animate-ping"></div>
                                <div class="absolute inset-2 rounded-full border border-white/20 animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced decorative elements with animation -->
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/5 rounded-full animate-pulse hover:bg-white/10 transition-colors duration-500"></div>
                <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-white/5 rounded-full animate-pulse hover:bg-white/10 transition-colors duration-700" style="animation-delay: 1s;"></div>

                <!-- Moving gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent transform -skew-x-12 animate-shimmer"></div>
            </div>

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                 x-data="{ cardsLoaded: false }"
                 x-init="setTimeout(() => cardsLoaded = true, 300)">
                <!-- Today's Sales -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 transform"
                     :class="cardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 0ms;">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg group-hover:shadow-green-500/25">
                            <x-lucide-trending-up class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                        </div>
                        <span class="text-sm text-green-600 font-semibold bg-green-50 px-2 py-1 rounded-full group-hover:bg-green-100 transition-colors duration-300 animate-pulse">{{ $salesGrowth ?? '0%' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium group-hover:text-gray-600 transition-colors duration-300">Penjualan Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1 group-hover:text-green-600 transition-colors duration-300">Rp {{ number_format($todaysRevenue ?? 0) }}</p>
                    <p class="text-sm text-gray-500 mt-2 group-hover:text-gray-600 transition-colors duration-300">{{ $todaysTransactions ?? 0 }} transaksi</p>
                    <!-- Animated background effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-green-600/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

                <!-- Total Products -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 transform"
                     :class="cardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 100ms;">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg group-hover:shadow-blue-500/25">
                            <x-lucide-package class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                        </div>
                        <span class="text-sm text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded-full group-hover:bg-blue-100 transition-colors duration-300 animate-pulse" style="animation-delay: 0.2s;">{{ $productGrowth ?? '+0' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium group-hover:text-gray-600 transition-colors duration-300">Total Produk</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1 group-hover:text-blue-600 transition-colors duration-300">{{ $totalProducts ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2 group-hover:text-gray-600 transition-colors duration-300">{{ $lowStockProducts->count() ?? 0 }} stok rendah</p>
                    <!-- Animated background effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-blue-600/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

                <!-- Active Suppliers -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 transform"
                     :class="cardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 200ms;">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg group-hover:shadow-purple-500/25">
                            <x-lucide-users class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                        </div>
                        <span class="text-sm text-purple-600 font-semibold bg-purple-50 px-2 py-1 rounded-full group-hover:bg-purple-100 transition-colors duration-300 animate-pulse" style="animation-delay: 0.4s;">{{ $supplierGrowth ?? '+0' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium group-hover:text-gray-600 transition-colors duration-300">Supplier Aktif</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1 group-hover:text-purple-600 transition-colors duration-300">{{ $totalSuppliers ?? 0 }}</p>
                    <p class="text-sm text-gray-500 mt-2 group-hover:text-gray-600 transition-colors duration-300">{{ $recentPurchases ?? 0 }} pembelian baru</p>
                    <!-- Animated background effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-purple-600/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

                <!-- Monthly Growth -->
                <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 transform"
                     :class="cardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 300ms;">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg group-hover:shadow-orange-500/25">
                            <x-lucide-bar-chart-3 class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" />
                        </div>
                        <span class="text-sm text-orange-600 font-semibold bg-orange-50 px-2 py-1 rounded-full group-hover:bg-orange-100 transition-colors duration-300 animate-pulse" style="animation-delay: 0.6s;">{{ $monthlyGrowth ?? '0%' }}</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium group-hover:text-gray-600 transition-colors duration-300">Pertumbuhan Bulan Ini</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1 group-hover:text-orange-600 transition-colors duration-300">+{{ $monthlyGrowth ?? '0' }}%</p>
                    <p class="text-sm text-gray-500 mt-2 group-hover:text-gray-600 transition-colors duration-300">vs bulan lalu</p>
                    <!-- Animated background effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-500/5 to-orange-600/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-12 gap-6"
                x-data="{ mainCardsLoaded: false, chart: 'revenue' }"
                x-init="setTimeout(() => mainCardsLoaded = true, 600)">

                <!-- Left Column: Charts and Analytics -->
                <div class="col-span-12 lg:col-span-8 space-y-6">

                    <!-- Sales Chart Dashboard Card (Aktif & Responsive) -->
                    <div
                        class="relative bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 transform group"
                        :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        style="transition-delay: 0ms;"
                    >
                        <!-- Header -->
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-blue-50/50 group-hover:to-green-50/50 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-1">
                                        Analytics Dashboard
                                    </h2>
                                    <p class="text-gray-600 text-sm group-hover:text-gray-600 transition-colors duration-300">
                                        Visualisasi data bisnis Anda
                                    </p>
                                </div>
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
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none bg-gradient-to-r from-blue-500/5 to-green-500/5"></div>
                    </div>

                    <!-- Category Performance -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 transform group"
                         :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 200ms;">
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-purple-50/50 group-hover:to-pink-50/50 transition-all duration-300">
                            <h2 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300">Performa Kategori</h2>
                            <p class="text-gray-500 text-sm group-hover:text-gray-600 transition-colors duration-300">Kategori produk terlaris</p>
                        </div>
                        <div class="p-6 group-hover:bg-gradient-to-br group-hover:from-white group-hover:to-purple-50/30 transition-all duration-300">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($categoryPerformance as $category)
                                    <div class="flex items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-all duration-300 hover:scale-105 hover:shadow-md transform hover:-translate-y-1 group/item">
                                        <div class="w-12 h-12 {{ $category['color'] }} rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 shadow-lg">
                                            <x-lucide-bar-chart-3 class="w-6 h-6 text-white group-hover/item:scale-110 transition-transform duration-300" />
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 group-hover/item:text-purple-600 transition-colors duration-300">{{ $category['name'] }}</p>
                                            <p class="text-sm text-gray-500 group-hover/item:text-gray-600 transition-colors duration-300">{{ $category['sales'] }} penjualan - Rp {{ number_format($category['revenue']) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none bg-gradient-to-r from-purple-500/5 to-pink-500/5"></div>
                    </div>
                </div>

                <!-- Right Column: Quick Actions and Status -->
                <div class="col-span-12 lg:col-span-4 space-y-6">

                    <!-- Quick Actions -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 transform group"
                         :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 100ms;">
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-blue-50/50 group-hover:to-green-50/50 transition-all duration-300">
                            <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">Aksi Cepat</h2>
                            <p class="text-gray-500 text-sm group-hover:text-gray-600 transition-colors duration-300">Fitur yang sering digunakan</p>
                        </div>
                        <div class="p-6 space-y-3 group-hover:bg-gradient-to-br group-hover:from-white group-hover:to-blue-50/30 transition-all duration-300">
                            <a href="{{ route('pos.index') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-xl hover:from-blue-100 hover:to-green-100 transition-all duration-300 group/item hover:scale-105 hover:-translate-y-1 transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-green-500 rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 shadow-lg">
                                    <x-lucide-calculator class="w-6 h-6 text-white group-hover/item:scale-110 transition-transform duration-300" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 group-hover/item:text-blue-600 transition-colors duration-300">Point of Sale</p>
                                    <p class="text-sm text-gray-500 group-hover/item:text-gray-600 transition-colors duration-300">Mulai transaksi penjualan</p>
                                </div>
                            </a>

                            <a href="{{ route('products.create') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-all duration-300 group/item hover:scale-105 hover:-translate-y-1 transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 shadow-lg">
                                    <x-lucide-plus class="w-6 h-6 text-white group-hover/item:scale-110 transition-transform duration-300" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 group-hover/item:text-purple-600 transition-colors duration-300">Tambah Produk</p>
                                    <p class="text-sm text-gray-500 group-hover/item:text-gray-600 transition-colors duration-300">Tambah produk baru</p>
                                </div>
                            </a>

                            <a href="{{ route('purchases.create') }}" class="flex items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-all duration-300 group/item hover:scale-105 hover:-translate-y-1 transform hover:shadow-lg">
                                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 shadow-lg">
                                    <x-lucide-shopping-bag class="w-6 h-6 text-white group-hover/item:scale-110 transition-transform duration-300" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 group-hover/item:text-orange-600 transition-colors duration-300">Catat Pembelian</p>
                                    <p class="text-sm text-gray-500 group-hover/item:text-gray-600 transition-colors duration-300">Tambah pembelian stok</p>
                                </div>
                            </a>
                        </div>
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none bg-gradient-to-r from-blue-500/5 to-green-500/5"></div>
                    </div>

                    <!-- Low Stock Alert -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 transform group"
                         :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 300ms;">
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-red-50/50 group-hover:to-orange-50/50 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-red-600 transition-colors duration-300">Stok Rendah</h2>
                                    <p class="text-gray-500 text-sm group-hover:text-gray-600 transition-colors duration-300">Produk yang perlu di-restock</p>
                                </div>
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-semibold group-hover:bg-red-200 group-hover:scale-110 transition-all duration-300 animate-pulse">{{ $allLowStockProductsCount ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="p-6 group-hover:bg-gradient-to-br group-hover:from-white group-hover:to-red-50/30 transition-all duration-300">
                            <div class="space-y-3">
                                @forelse($lowStockProducts as $product)
                                    <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-lg hover:bg-red-50 transition-all duration-300 hover:scale-105 hover:shadow-md transform hover:-translate-y-1 group/item">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300">
                                                <x-lucide-alert-triangle class="w-5 h-5 text-red-600 group-hover/item:scale-110 transition-transform duration-300" />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm group-hover/item:text-red-600 transition-colors duration-300">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500 group-hover/item:text-gray-600 transition-colors duration-300">{{ $product->stock }} stok tersisa</p>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:scale-110 transition-all duration-300 hover:bg-blue-50 px-3 py-1 rounded-lg">
                                            Restock
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-400 py-6 animate-pulse">
                                        <x-lucide-check-circle class="w-12 h-12 mx-auto mb-2 text-green-400" />
                                        Semua stok aman
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none bg-gradient-to-r from-red-500/5 to-orange-500/5"></div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1 transform group"
                         :class="mainCardsLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: 500ms;">
                        <div class="p-6 border-b border-gray-200/50 group-hover:bg-gradient-to-r group-hover:from-indigo-50/50 group-hover:to-purple-50/50 transition-all duration-300">
                            <h2 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors duration-300">Aktivitas Terbaru</h2>
                            <p class="text-gray-500 text-sm group-hover:text-gray-600 transition-colors duration-300">Log aktivitas sistem</p>
                        </div>
                        <div class="p-6 group-hover:bg-gradient-to-br group-hover:from-white group-hover:to-indigo-50/30 transition-all duration-300">
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-3 hover:bg-gray-50/50 p-2 rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-sm transform hover:-translate-y-0.5 group/item">
                                        <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300">
                                            <x-lucide-{{ $activity['icon'] }} class="w-4 h-4 text-{{ $activity['color'] }}-600 group-hover/item:scale-110 transition-transform duration-300" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-800 text-sm group-hover/item:text-indigo-600 transition-colors duration-300">{{ $activity['action'] }}</p>
                                            <p class="text-gray-500 text-xs group-hover/item:text-gray-600 transition-colors duration-300">{{ $activity['desc'] }}</p>
                                            <p class="text-gray-400 text-xs mt-1 group-hover/item:text-gray-500 transition-colors duration-300">{{ $activity['time'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none bg-gradient-to-r from-indigo-500/5 to-purple-500/5"></div>
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
