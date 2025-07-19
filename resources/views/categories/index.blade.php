<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6" x-data="categoryModal()">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Manajemen Kategori
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola kategori produk untuk mengorganisir inventori</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <x-lucide-grid-3x3 class="w-6 h-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $categories->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <x-lucide-package class="w-6 h-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Kategori Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $categories->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <x-lucide-archive class="w-6 h-6 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Produk Total</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $categories->sum('products_count') ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <x-lucide-trending-up class="w-6 h-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Terpopuler</p>
                        <p class="text-xl font-bold text-gray-800">{{ $categories->first()?->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200/50">
                <h2 class="text-xl font-bold text-gray-800">Daftar Kategori</h2>
            </div>

            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Kategori</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Jumlah Produk</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Dibuat</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50">
                            @foreach($categories as $category)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-green-100 rounded-lg flex items-center justify-center mr-3">
                                                <img
                                                    src="https://placehold.co/40x40/3b82f6/ffffff?text={{ substr($category->name, 0, 2) }}"
                                                    alt="{{ $category->name }}"
                                                    class="w-6 h-6 object-cover rounded"
                                                >
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                                                <p class="text-sm text-gray-500">ID: {{ $category->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <x-lucide-package class="w-4 h-4 text-gray-400 mr-2" />
                                            <span class="text-gray-600">{{ $category->products_count ?? 0 }} produk</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            Aktif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $category->created_at?->format('d M Y') ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button @click="openEditModal({{ $category }})"
                                                class="flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors duration-150">
                                                <x-lucide-edit class="w-4 h-4 mr-1" />
                                                Edit
                                            </button>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                                    class="flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors duration-150">
                                                    <x-lucide-trash-2 class="w-4 h-4 mr-1" />
                                                    Hapus
                                                </button>
                                            </form>
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
                        <x-lucide-grid-3x3 class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mb-2">Belum Ada Kategori</h3>
                    <p class="text-gray-400 mb-6">Mulai dengan menambahkan kategori pertama Anda</p>
                    <button @click="openCreateModal()"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl hover:shadow-lg transition-all">
                        <x-lucide-plus class="w-5 h-5 mr-2" />
                        Tambah Kategori
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
                class="bg-white/90 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
                @click.stop
            >
                @include('categories.partials.form')
            </div>
        </div>
    </div>

    <script>
        function categoryModal() {
            return {
                showModal: false,
                editMode: false,
                currentCategory: {},
                formData: {
                    name: '',
                    description: '',
                    is_active: true
                },

                openCreateModal() {
                    this.editMode = false;
                    this.formData = {
                        name: '',
                        description: '',
                        is_active: true
                    };
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditModal(category) {
                    this.editMode = true;
                    this.currentCategory = category;
                    this.formData = {
                        name: category.name || '',
                        description: category.description || '',
                        is_active: category.is_active !== undefined ? category.is_active : true
                    };
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.showModal = false;
                    document.body.style.overflow = 'auto';
                    this.currentCategory = {};
                    this.formData = {
                        name: '',
                        description: '',
                        is_active: true
                    };
                }
            }
        }
    </script>
</x-app-layout>
