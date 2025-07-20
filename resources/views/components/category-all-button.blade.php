@props(['selected' => false])

<button
    wire:click.prevent="$set('selectedCategory', 'all')"
    class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200
        {{ $selected ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105'
           : 'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50' }}"
>
    <div class="flex items-center space-x-2">
        <x-lucide-grid-3x3 class="w-4 h-4" />
        <span>Semua Kategori</span>
    </div>
</button>
