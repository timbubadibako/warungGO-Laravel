@props(['active'])

@php
// Tentukan kelas CSS berdasarkan apakah link sedang aktif atau tidak
$classes = ($active ?? false)
            ? 'flex items-center p-3 my-4 text-white bg-gradient-to-r from-blue-600 to-green-600 rounded-lg shadow-lg border-l-4 border-blue-400 transition-all duration-300'
            : 'flex items-center p-3 my-4 text-slate-300 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Slot ini akan diisi oleh ikon SVG --}}
    <span class="mr-8">
        {{ $icon }}
    </span>
    {{-- Slot ini untuk teks link --}}
    {{ $slot }}

</a>
