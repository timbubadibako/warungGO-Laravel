@props(['categories', 'selectedCategory'])

<div class="flex items-center space-x-3 pl-5 my-4 overflow-x-auto scrollbar-hide">
    <button
        @click="selectCategory('all')"
        :class="selectedCategory === 'all' ?
            'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105' :
            'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50'"
        class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200"
    >
        Semua Kategori
    </button>
    <template x-for="category in categories" :key="category.id">
        <button
            @click="selectCategory(category.id)"
            :class="selectedCategory == category.id ?
                'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg shadow-blue-500/25 scale-105' :
                'bg-white/70 backdrop-blur-sm text-gray-700 shadow-sm hover:bg-white hover:shadow-md border border-gray-200/50'"
            class="flex-shrink-0 px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-200"
            x-text="category.name"
        >
        </button>
    </template>
</div>
