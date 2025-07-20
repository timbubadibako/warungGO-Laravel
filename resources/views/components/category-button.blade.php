@props(['category', 'selected' => false])

<button
    wire:click.prevent="$set('selectedCategory', {{ $category->id }})"
    class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200
        {{ $selected ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105'
           : 'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50' }}"
>
    {{ $category->name }}
</button>
