@props(['title' => null, 'description' => null])

<div>
    <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-1">
        {{ $title ?? 'Metrics Header' }}
    </h2>
    <p class="text-gray-600 text-sm group-hover:text-gray-600 transition-colors duration-300">
        {{ $description ?? 'Visualisasi data bisnis Anda' }}
    </p>
</div>

