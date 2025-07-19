<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6" x-data="productModal()">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Manajemen Produk
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola produk dan inventori toko Anda</p>
                </div>
                <button @click="openCreateModal()"
                    class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <x-lucide-plus class="w-5 h-5 mr-2" />
                    Tambah Produk
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <x-lucide-package class="w-6 h-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="filteredProducts.length"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <x-lucide-trending-up class="w-6 h-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Stok Tersedia</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="filteredProducts.reduce((sum, product) => sum + product.stock, 0)"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <x-lucide-alert-triangle class="w-6 h-6 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Stok Rendah</p>
                        <p class="text-2xl font-bold text-gray-800" x-text="filteredProducts.filter(product => product.stock > 0 && product.stock <= 10).length"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <x-lucide-dollar-sign class="w-6 h-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Nilai Inventori</p>
                        <p class="text-xl font-bold text-gray-800" x-text="`Rp ${new Intl.NumberFormat('id-ID').format(filteredProducts.reduce((sum, product) => sum + (product.stock * product.purchase_price), 0))}`"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <x-lucide-search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input
                            type="text"
                            placeholder="Cari produk..."
                            x-model="searchKeyword"
                            @input="filterProducts()"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                        >
                    </div>
                </div>
                <div class="flex gap-3">
                    <select x-model="selectedCategory" @change="filterProducts()" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($products->pluck('category')->unique() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select x-model="selectedStock" @change="filterProducts()" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm">
                        <option value="">Semua Stok</option>
                        <option value="low">Stok Rendah</option>
                        <option value="empty">Stok Habis</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200/50">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
                    <span x-text="`Menampilkan ${filteredProducts.length} dari ${allProducts.length} produk`" class="text-sm text-gray-500"></span>
                </div>
            </div>

            <div x-show="filteredProducts.length > 0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Produk</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Kategori</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Harga</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Stok</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50">
                            <template x-for="product in filteredProducts" :key="product.id">
                                <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-green-100 rounded-xl flex items-center justify-center mr-3 overflow-hidden">
                                                <img
                                                    :src="`https://placehold.co/48x48/3b82f6/ffffff?text=${product.name.substr(0, 2)}`"
                                                    :alt="product.name"
                                                    class="w-full h-full object-cover"
                                                >
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800" x-text="product.name"></p>
                                                <p class="text-sm text-gray-500" x-text="product.barcode || 'N/A'"></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800" x-text="product.category.name">
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-500">Beli: <span class="font-medium text-gray-700" x-text="`Rp ${new Intl.NumberFormat('id-ID').format(product.purchase_price)}`"></span></p>
                                            <p class="text-sm font-semibold text-green-600" x-text="`Jual: Rp ${new Intl.NumberFormat('id-ID').format(product.selling_price)}`"></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <template x-if="product.stock <= 5">
                                                <x-lucide-alert-triangle class="w-4 h-4 text-red-500 mr-2" />
                                            </template>
                                            <template x-if="product.stock > 5 && product.stock <= 20">
                                                <x-lucide-alert-circle class="w-4 h-4 text-yellow-500 mr-2" />
                                            </template>
                                            <template x-if="product.stock > 20">
                                                <x-lucide-check-circle class="w-4 h-4 text-green-500 mr-2" />
                                            </template>
                                            <span
                                                :class="{
                                                    'text-red-600': product.stock <= 5,
                                                    'text-yellow-600': product.stock > 5 && product.stock <= 20,
                                                    'text-green-600': product.stock > 20
                                                }"
                                                class="font-semibold"
                                                x-text="product.stock">
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <template x-if="product.stock > 0">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                Tersedia
                                            </span>
                                        </template>
                                        <template x-if="product.stock <= 0">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                Habis
                                            </span>
                                        </template>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button @click="openEditModal(product)"
                                                class="flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors duration-150">
                                                <x-lucide-edit class="w-4 h-4 mr-1" />
                                                Edit
                                            </button>
                                            <form :action="`/products/${product.id}`" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                                    class="flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors duration-150">
                                                    <x-lucide-trash-2 class="w-4 h-4 mr-1" />
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- No Products Found State -->
            <div x-show="filteredProducts.length === 0" class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <x-lucide-search class="w-12 h-12 text-gray-400" />
                </div>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-400 mb-6">Coba ubah kata kunci pencarian atau filter yang digunakan</p>
                <button @click="resetFilters()"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl hover:shadow-lg transition-all">
                    <x-lucide-refresh-cw class="w-5 h-5 mr-2" />
                    Reset Filter
                </button>
            </div>

            <!-- Empty State (No Products at all) -->
            <div x-show="allProducts.length === 0" class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <x-lucide-package class="w-12 h-12 text-gray-400" />
                </div>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Belum Ada Produk</h3>
                <p class="text-gray-400 mb-6">Mulai dengan menambahkan produk pertama Anda</p>
                <button @click="openCreateModal()"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl hover:shadow-lg transition-all">
                    <x-lucide-plus class="w-5 h-5 mr-2" />
                    Tambah Produk
                </button>
            </div>
        </div>

        <!-- Modal Popup -->
        <div
            x-show="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            @click.self="closeModal()"
        >
            <div
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white/90 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto"
                @click.stop
            >
                @include('products.partials.form')
            </div>
        </div>
    </div>

    <script>
        function productModal() {
            return {
                showModal: false,
                editMode: false,
                currentProduct: {},
                formData: {
                    name: '',
                    category_id: '',
                    barcode: '',
                    purchase_price: '',
                    selling_price: '',
                    stock: '',
                    description: ''
                },

                // Filtering & Search
                searchKeyword: '',
                selectedCategory: '',
                selectedStock: '',
                allProducts: @json($products),
                filteredProducts: @json($products),

                init() {
                    this.allProducts = @json($products);
                    this.filteredProducts = [...this.allProducts];
                },

                filterProducts() {
                    let filtered = [...this.allProducts];

                    // Filter by search keyword
                    if (this.searchKeyword.trim() !== '') {
                        const keyword = this.searchKeyword.toLowerCase();
                        filtered = filtered.filter(product =>
                            product.name.toLowerCase().includes(keyword) ||
                            (product.barcode && product.barcode.toLowerCase().includes(keyword)) ||
                            (product.description && product.description.toLowerCase().includes(keyword)) ||
                            product.category.name.toLowerCase().includes(keyword)
                        );
                    }

                    // Filter by category
                    if (this.selectedCategory !== '') {
                        filtered = filtered.filter(product =>
                            product.category_id == this.selectedCategory
                        );
                    }

                    // Filter by stock status
                    if (this.selectedStock !== '') {
                        if (this.selectedStock === 'low') {
                            filtered = filtered.filter(product => product.stock > 0 && product.stock <= 10);
                        } else if (this.selectedStock === 'empty') {
                            filtered = filtered.filter(product => product.stock <= 0);
                        }
                    }

                    this.filteredProducts = filtered;
                },

                resetFilters() {
                    this.searchKeyword = '';
                    this.selectedCategory = '';
                    this.selectedStock = '';
                    this.filteredProducts = [...this.allProducts];
                },

                openCreateModal() {
                    this.editMode = false;
                    this.formData = {
                        name: '',
                        category_id: '',
                        barcode: '',
                        purchase_price: '',
                        selling_price: '',
                        stock: '',
                        description: ''
                    };
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditModal(product) {
                    this.editMode = true;
                    this.currentProduct = product;
                    this.formData = {
                        name: product.name || '',
                        category_id: product.category_id || '',
                        barcode: product.barcode || '',
                        purchase_price: product.purchase_price || '',
                        selling_price: product.selling_price || '',
                        stock: product.stock || '',
                        description: product.description || ''
                    };
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.showModal = false;
                    document.body.style.overflow = 'auto';
                    this.currentProduct = {};
                    this.formData = {
                        name: '',
                        category_id: '',
                        barcode: '',
                        purchase_price: '',
                        selling_price: '',
                        stock: '',
                        description: ''
                    };
                }
            }
        }
    </script>
</x-app-layout>
