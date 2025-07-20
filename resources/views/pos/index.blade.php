<x-app-layout>
    <div
        x-data="posCart({
            initialCart: @js($cart ?? []),
            initialProducts: @js($products),
            initialCategories: @js($categories),
            initialSelectedCategory: @js($selectedCategory ?? 'all')
        })"
        x-init="init()"
        class="h-screen font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50"
    >
        <div class="flex font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 h-full">

            <!-- Kolom Utama: Katalog & Produk (2/3) -->
            <div class="w-2/3 flex flex-col h-full">
                <!-- Header Konten -->
                <x-page-header
                    :title="'Katalog Produk'"
                    :subtitle="'Pilih produk untuk menambahkan ke keranjang'">
                    <x-slot name="search">
                        <x-icon-field
                            name="scannedBarcode"
                            type="text"
                            placeholder="Scan barcode atau cari produk..."
                            {{-- x-model="scannedBarcode" --}}
                            autofocus
                        >
                            <x-slot name="icon">
                                <x-lucide-scan class="w-5 h-5 text-gray-400 transition-all duration-300" />
                            </x-slot>
                        </x-icon-field>
                        @if (session()->has('error'))
                            <x-input-error :messages="session('error')" class="mt-2" />
                        @endif
                    </x-slot>
                </x-page-header>

                <main class="flex-1 flex flex-col min-h-0">
                    <!-- Kategori -->
                    <x-category-list :categories="$categories" :selectedCategory="$selectedCategory" />
                    <!-- Grid Produk -->
                    <div class="flex-1 overflow-y-auto custom-scrollbar ml-4 pr-1">
                        <x-product-grid
                            :products="$products" :categories="$categories"
                            :selectedCategory="$selectedCategory"
                        />
                    </div>
                </main>
            </div>

            <!-- Sidebar Cart (1/3) -->
            <aside class="w-1/3 flex flex-col bg-white/80 backdrop-blur-sm border-l border-gray-200/50 shadow-xl h-screen">
                <!-- Cart Header -->
                <x-cart-header />

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    <x-cart-item
                        :cart="$cart"
                        updateCartItem="updateCartItem"
                        item="item"
                        id="id"
                     />

                    <div x-show="Object.keys(cart).length === 0" class="text-center py-16">
                        <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <x-lucide-shopping-cart class="w-10 h-10 text-gray-400" />
                        </div>
                        <p class="text-gray-500 font-medium">Keranjang masih kosong</p>
                        <p class="text-gray-400 text-sm mt-1">Pilih produk untuk memulai transaksi</p>
                    </div>
                </div>

                <!-- Cart Summary -->
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
                    <div class="space-y-2">
                        <button @click="checkout()" x-show="Object.keys(cart).length > 0" class="w-full bg-gradient-to-r from-blue-600 to-green-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-200">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </aside>
        </div>
        <!-- Modal Pilihan Pembayaran -->
        <div x-show="showPaymentModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black backdrop-blur-sm  bg-opacity-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
                <h3 class="text-xl font-bold mb-4">Pilih Metode Pembayaran</h3>
                <div class="space-y-3">
                    <button @click="processPayment('cash')" class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition-colors">
                        💰 Tunai
                    </button>
                    <button @click="processPayment('qris')" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        📱 QRIS (Simulasi)
                    </button>
                    <button @click="processPayment('debit')" class="w-full bg-purple-600 text-white py-3 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                        💳 Kartu Debit (Simulasi)
                    </button>
                </div>
                <button @click="showPaymentModal = false" class="w-full mt-4 bg-gray-200 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                    Batal
                </button>
            </div>
        </div>

        <!-- Modal Pembayaran Tunai -->
        <div x-show="showCashModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
                <h3 class="text-xl font-bold mb-4">Pembayaran Tunai</h3>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Total Pembayaran:</p>
                        <p class="text-2xl font-bold text-blue-600">Rp <span x-text="total().toLocaleString('id-ID')"></span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Uang Diterima:</label>
                        <input
                            type="number"
                            x-model="cashPaid"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="0"
                            min="0"
                        >
                    </div>

                    <div x-show="cashPaid && parseFloat(cashPaid) >= total()" class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-sm text-green-600">Kembalian:</p>
                        <p class="text-xl font-bold text-green-700">Rp <span x-text="calculateChange().toLocaleString('id-ID')"></span></p>
                    </div>

                    <div x-show="cashPaid && parseFloat(cashPaid) < total()" class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <p class="text-sm text-red-600">Uang kurang:</p>
                        <p class="text-lg font-semibold text-red-700">Rp <span x-text="(total() - parseFloat(cashPaid)).toLocaleString('id-ID')"></span></p>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button @click="showCashModal = false; showPaymentModal = true" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        Kembali
                    </button>
                    <button
                        @click="submitCashPayment()"
                        x-show="cashPaid && parseFloat(cashPaid) >= total()"
                        class="flex-1 bg-green-600 text-white py-2 rounded-lg font-medium hover:bg-green-700 transition-colors"
                    >
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')

<style>
    [x-cloak] { display: none !important; }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #3b82f6, #10b981);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #2563eb, #059669);
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
function posCart({ initialCart, initialProducts, initialCategories, initialSelectedCategory }) {
    return {
        cart: initialCart || {},
        products: initialProducts || [],
        categories: initialCategories || [],
        filteredProducts: [],
        selectedCategory: initialSelectedCategory || 'all',
        search: '',
        showPaymentModal: false,
        showCashModal: false,
        cashPaid: '',

        init() {
            this.filterProducts();
        },

        selectCategory(categoryId) {
            this.selectedCategory = categoryId;
            this.filterProducts();
        },

        searchProducts() {
            this.filterProducts();
        },

        filterProducts() {
            this.filteredProducts = this.products.filter(product => {
                // Filter by category
                const categoryMatch = this.selectedCategory === 'all' || product.category_id == this.selectedCategory;

                // Filter by search
                const searchMatch = !this.search || product.name.toLowerCase().includes(this.search.toLowerCase());

                return categoryMatch && searchMatch;
            });
        },

        addItem(id, name, price, purchase_price, stock) {
            // Validasi input
            if (!id || !name || !price) {
                console.error('Invalid product data:', { id, name, price, purchase_price, stock });
                return;
            }

            const productId = String(id); // Pastikan ID adalah string

            if (!this.cart[productId]) {
                this.cart[productId] = {
                    product_id: parseInt(id),
                    name: String(name),
                    price: parseFloat(price),
                    purchase_price: parseFloat(purchase_price || 0),
                    quantity: 1,
                    stock: parseInt(stock || 0)
                };
            } else if (this.cart[productId].quantity < parseInt(stock)) {
                this.cart[productId].quantity++;
            } else {
                alert('Stok tidak mencukupi!');
                return;
            }

            console.log('Item added to cart:', this.cart[productId]);
            this.saveCartToSession();
        },

        updateCartItem(id, action) {
            const productId = String(id);
            if (!this.cart[productId]) return;

            if (action === "plus") {
                if (this.cart[productId].quantity < this.cart[productId].stock) {
                    this.cart[productId].quantity++;
                } else {
                    alert('Stok tidak mencukupi!');
                    return;
                }
            } else if (action === "minus") {
                if (this.cart[productId].quantity > 1) {
                    this.cart[productId].quantity--;
                } else {
                    delete this.cart[productId];
                }
            } else if (action === "remove") {
                delete this.cart[productId];
            }

            this.saveCartToSession();
        },

        clearCart() {
            this.cart = {};
            this.saveCartToSession();
        },

        subtotal() {
            return Object.values(this.cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        tax() {
            return Math.round(this.subtotal() * 0.11);
        },

        total() {
            return this.subtotal() + this.tax();
        },

        saveCartToSession() {
            // Filter cart untuk menghapus item yang tidak valid
            const validCart = {};
            Object.keys(this.cart).forEach(key => {
                const item = this.cart[key];
                if (item && item.name && item.price && item.quantity > 0) {
                    validCart[key] = item;
                }
            });

            this.cart = validCart;

            // Simpan cart ke session via AJAX
            fetch('/pos/update-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ cart: this.cart })
            }).catch(error => {
                console.error('Error saving cart:', error);
            });
        },

        checkout() {
            if (Object.keys(this.cart).length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            // Tampilkan modal pilihan pembayaran
            this.showPaymentModal = true;
        },

        processPayment(method) {
            if (method === 'cash') {
                this.showCashModal = true;
                this.showPaymentModal = false;
            } else {
                // Untuk debit dan QRIS, langsung proses (simulasi)
                this.submitPayment(method);
            }
        },

        calculateChange() {
            const total = this.total();
            const paid = parseFloat(this.cashPaid) || 0;
            return paid >= total ? paid - total : 0;
        },

        submitCashPayment() {
            const total = this.total();
            const paid = parseFloat(this.cashPaid) || 0;

            if (paid < total) {
                alert('Uang yang dibayarkan kurang!');
                return;
            }

            this.submitPayment('cash');
        },

        submitPayment(method) {
            // Buat form untuk submit ke checkout
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/pos/checkout';

            // CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfToken);

            // Payment method
            const paymentMethod = document.createElement('input');
            paymentMethod.type = 'hidden';
            paymentMethod.name = 'paymentMethod';
            paymentMethod.value = method;
            form.appendChild(paymentMethod);

            // Jika cash, tambahkan info pembayaran
            if (method === 'cash' && this.cashPaid) {
                const cashPaidInput = document.createElement('input');
                cashPaidInput.type = 'hidden';
                cashPaidInput.name = 'cashPaid';
                cashPaidInput.value = this.cashPaid;
                form.appendChild(cashPaidInput);

                const changeInput = document.createElement('input');
                changeInput.type = 'hidden';
                changeInput.name = 'change';
                changeInput.value = this.calculateChange();
                form.appendChild(changeInput);
            }

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>
@endpush

</x-app-layout>
