@props(['href' => '#', 'variant' => 'default'])

@php
$classes = match($variant) {
    'danger' => 'flex items-center px-6 py-3 border border-red-300 text-red-700 bg-red-50 rounded-xl hover:bg-red-100 hover:border-red-400 transition-all duration-200',
    'secondary' => 'flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-gray-50 rounded-xl hover:bg-gray-100 hover:border-gray-400 transition-all duration-200',
    default => 'flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200'
};
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $icon ?? '' }}
    <span class="font-medium">{{ $slot }}</span>
</a>
