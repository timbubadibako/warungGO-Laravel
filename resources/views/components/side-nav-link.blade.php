@props(['active'])

@php
// Tentukan kelas CSS berdasarkan apakah link sedang aktif atau tidak
$classes = ($active ?? false)
            ? 'flex items-center p-3 my-4 text-orange-500 bg-orange-100 rounded-lg transition-colors duration-200'
            : 'flex items-center p-3 my-4 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Slot ini akan diisi oleh ikon SVG --}}
    <span class="mr-8">
        {{ $icon }}
    </span>
    {{-- Slot ini untuk teks link --}}
    {{ $slot }}
</a>
