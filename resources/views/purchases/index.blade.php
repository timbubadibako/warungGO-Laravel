<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6" x-data="purchaseModal()">
        <!-- Header Section -->
        <x-secondary-header
            title="Daftar Pembelian"
            description="Kelola pembelian produk dari supplier"
            buttonText="Tambah Pembelian"
            />

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <x-lucide-shopping-bag class="w-6 h-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Pembelian</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $purchases->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <x-lucide-dollar-sign class="w-6 h-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Nilai</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($purchases->sum('total_amount'), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <x-lucide-clock class="w-6 h-6 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Pending</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $purchases->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <x-lucide-check-circle class="w-6 h-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $purchases->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <x-lucide-search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                    <input
                        type="text"
                        placeholder="Cari pembelian..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                    >
                </div>
                <select class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm">
                    <option>Semua Supplier</option>
                    @foreach($purchases->pluck('supplier')->unique() as $supplier)
                        <option>{{ $supplier->name }}</option>
                    @endforeach
                </select>
                <select class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm">
                    <option>Semua Status</option>
                    <option>Pending</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
                <input
                    type="date"
                    class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm"
                >
            </div>
        </div>

        <!-- Purchases Table -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200/50">
                <h2 class="text-xl font-bold text-gray-800">Daftar Pembelian</h2>
            </div>

            @if($purchases->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Supplier</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Item</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Total</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50">
                            @foreach($purchases as $purchase)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-lucide-calendar class="w-5 h-5 text-blue-600" />
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</p>
                                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-xs font-semibold text-gray-700">{{ substr($purchase->supplier->name, 0, 2) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $purchase->supplier->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $purchase->supplier->phone_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <x-lucide-package class="w-4 h-4 text-gray-400 mr-2" />
                                            <span class="text-gray-600">{{ $purchase->items_count ?? 0 }} item</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-lg text-green-600">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @switch($purchase->status)
                                            @case('pending')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                                    Pending
                                                </span>
                                                @break
                                            @case('completed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                    Selesai
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                    Dibatalkan
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('purchases.show', $purchase) }}"
                                                class="flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors duration-150">
                                                <x-lucide-eye class="w-4 h-4 mr-1" />
                                                Detail
                                            </a>
                                            @if($purchase->status == 'pending')
                                                <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus pembelian ini?')"
                                                        class="flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors duration-150">
                                                        <x-lucide-trash-2 class="w-4 h-4 mr-1" />
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <x-lucide-shopping-bag class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mb-2">Belum Ada Pembelian</h3>
                    <p class="text-gray-400 mb-6">Mulai dengan mencatat pembelian pertama Anda</p>
                    <button @click="openCreateModal()"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl hover:shadow-lg transition-all">
                        <x-lucide-plus class="w-5 h-5 mr-2" />
                        Catat Pembelian
                    </button>
                </div>
            @endif
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
                @include('purchases.partials.form')
            </div>
        </div>
    </div>

    <script>
        function purchaseModal() {
            return {
                showModal: false,
                editMode: false,
                currentPurchase: {},
                products: @json($products),
                formData: {
                    supplier_id: '',
                    purchase_date: new Date().toISOString().split('T')[0],
                    status: 'pending',
                    total_amount: 0,
                    items: []
                },

                openCreateModal() {
                    this.editMode = false;
                    this.formData = {
                        supplier_id: '',
                        purchase_date: new Date().toISOString().split('T')[0],
                        status: 'pending',
                        total_amount: 0,
                        items: [{ product_id: '', quantity: 1, cost_price: 0, subtotal: 0 }]
                    };
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditModal(purchase) {
                    this.editMode = true;
                    this.currentPurchase = purchase;
                    this.formData = {
                        supplier_id: purchase.supplier_id || '',
                        purchase_date: purchase.purchase_date || '',
                        status: purchase.status || 'pending',
                        total_amount: purchase.total_amount || 0,
                        items: purchase.items && purchase.items.length > 0
                            ? purchase.items.map(item => ({
                                product_id: item.product_id,
                                quantity: item.quantity,
                                cost_price: item.cost_price,
                                subtotal: item.quantity * item.cost_price
                            }))
                            : [{ product_id: '', quantity: 1, cost_price: 0, subtotal: 0 }]
                    };
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.showModal = false;
                    document.body.style.overflow = 'auto';
                    this.currentPurchase = {};
                    this.formData = {
                        supplier_id: '',
                        purchase_date: new Date().toISOString().split('T')[0],
                        status: 'pending',
                        total_amount: 0,
                        items: []
                    };
                },

                addPurchaseItem() {
                    this.formData.items.push({
                        product_id: '',
                        quantity: 1,
                        cost_price: 0,
                        subtotal: 0
                    });
                },

                removePurchaseItem(index) {
                    if (this.formData.items.length > 1) {
                        this.formData.items.splice(index, 1);
                        this.calculateTotal();
                    }
                },

                onProductChange(index) {
                    const item = this.formData.items[index];
                    const selectedProduct = this.products.find(p => p.id == item.product_id);

                    if (selectedProduct) {
                        // Auto-fill cost price with product's purchase price
                        item.cost_price = parseFloat(selectedProduct.purchase_price);
                    } else {
                        item.cost_price = 0;
                    }

                    this.updateItemCalculation(index);
                },

                updateItemCalculation(index) {
                    const item = this.formData.items[index];
                    item.subtotal = (item.quantity || 0) * (item.cost_price || 0);
                    this.calculateTotal();
                },

                calculateTotal() {
                    this.formData.total_amount = this.formData.items.reduce((total, item) => {
                        return total + (item.subtotal || 0);
                    }, 0);
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(amount);
                }
            }
        }
    </script>
</x-app-layout>
