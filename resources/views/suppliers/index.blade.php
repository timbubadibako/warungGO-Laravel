<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Manajemen Supplier
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola daftar supplier dan mitra bisnis</p>
                </div>
                <a href="{{ route('suppliers.create') }}"
                    class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                    <x-lucide-plus class="w-5 h-5 mr-2" />
                    Tambah Supplier
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <x-lucide-users class="w-6 h-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Supplier</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $suppliers->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <x-lucide-check-circle class="w-6 h-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Supplier Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $suppliers->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <x-lucide-shopping-bag class="w-6 h-6 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Pembelian</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $suppliers->sum('purchases_count') ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-all duration-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <x-lucide-star class="w-6 h-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Top Supplier</p>
                        <p class="text-xl font-bold text-gray-800">{{ $suppliers->first()?->name ?? 'N/A' }}</p>
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
                            placeholder="Cari supplier..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm transition-all duration-200"
                        >
                    </div>
                </div>
                <div class="flex gap-3">
                    <select class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/70 backdrop-blur-sm">
                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Nonaktif</option>
                    </select>
                    <button class="flex items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        <x-lucide-filter class="w-5 h-5 text-gray-600" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Suppliers Grid -->
        @if($suppliers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($suppliers as $supplier)
                    <div class="group bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                Aktif
                            </span>
                        </div>

                        <!-- Supplier Avatar -->
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:shadow-md transition-shadow">
                            <img
                                src="https://placehold.co/64x64/3b82f6/ffffff?text={{ substr($supplier->name, 0, 2) }}"
                                alt="{{ $supplier->name }}"
                                class="w-10 h-10 object-cover rounded-lg"
                            >
                        </div>

                        <!-- Supplier Info -->
                        <div class="mb-4">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $supplier->name }}
                            </h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                @if($supplier->phone_number)
                                    <p class="flex items-center">
                                        <x-lucide-phone class="w-4 h-4 mr-2 text-gray-400" />
                                        {{ $supplier->phone_number }}
                                    </p>
                                @endif
                                @if($supplier->email)
                                    <p class="flex items-center">
                                        <x-lucide-mail class="w-4 h-4 mr-2 text-gray-400" />
                                        {{ $supplier->email }}
                                    </p>
                                @endif
                                @if($supplier->address)
                                    <p class="flex items-start">
                                        <x-lucide-map-pin class="w-4 h-4 mr-2 text-gray-400 mt-0.5" />
                                        <span class="line-clamp-2">{{ $supplier->address }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Supplier Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4 pt-4 border-t border-gray-100">
                            <span class="flex items-center">
                                <x-lucide-shopping-bag class="w-4 h-4 mr-1" />
                                {{ $supplier->purchases_count ?? 0 }} Pembelian
                            </span>
                            <span class="flex items-center">
                                <x-lucide-calendar class="w-4 h-4 mr-1" />
                                {{ $supplier->created_at?->format('M Y') ?? 'N/A' }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('suppliers.edit', $supplier) }}"
                                class="flex-1 flex items-center justify-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">
                                <x-lucide-edit class="w-4 h-4 mr-1" />
                                Edit
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus supplier ini?')"
                                    class="w-full flex items-center justify-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                                    <x-lucide-trash-2 class="w-4 h-4 mr-1" />
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm">
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <x-lucide-users class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mb-2">Belum Ada Supplier</h3>
                    <p class="text-gray-400 mb-6">Mulai dengan menambahkan supplier pertama Anda</p>
                    <a href="{{ route('suppliers.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl hover:shadow-lg transition-all">
                        <x-lucide-plus class="w-5 h-5 mr-2" />
                        Tambah Supplier
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
