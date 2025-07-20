@props(['title', 'description', 'buttonText' ])

<header class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                {{ $title ?? 'Daftar Produk' }}
            </h1>
            <p class="text-gray-600 mt-2">
                {{ $description ?? 'Kelola produk dan inventori toko Anda' }}
            </p>
        </div>
        <button @click="openCreateModal()"
            class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <x-lucide-plus class="w-5 h-5 mr-2" />
            {{ $buttonText ?? 'Null' }}
        </button>
    </div>
</header>
