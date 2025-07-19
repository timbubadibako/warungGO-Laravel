@props(['active' => false, 'variant' => 'default'])

@php
// Base classes untuk semua link
$baseClasses = 'group relative overflow-hidden rounded-xl transition-all duration-300 flex items-center space-x-3 p-3 border';

// Tentukan styling berdasarkan variant dan status active
$isActive = $active ?? false;

$variantClasses = match($variant) {
    'logout' => $isActive
        ? 'bg-red-700/50 text-red-100 border-red-600/50 shadow-lg shadow-red-500/20'
        : 'bg-red-900/20 hover:bg-red-700/30 text-red-300 hover:text-red-200 border-red-800/30 hover:border-red-600/50 hover:shadow-lg hover:shadow-red-500/10',
    'settings' => $isActive
        ? 'bg-slate-600/70 text-white border-slate-500/70'
        : 'bg-slate-700/30 hover:bg-slate-600/50 text-slate-300 hover:text-slate-100 border-slate-600/30 hover:border-slate-500/50',
    default => $isActive
        ? 'bg-gradient-to-r from-blue-600/40 to-green-600/40 text-white border-blue-500/70 shadow-lg shadow-blue-500/20'
        : 'bg-slate-700/50 hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-green-600/20 text-slate-400 hover:text-slate-100 border-slate-600/50 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10'
};

$classes = $baseClasses . ' ' . $variantClasses;
@endphp<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Icon slot dengan animasi --}}
    {{ $icon ?? '' }}

    {{-- Text content dengan ukuran yang lebih kecil --}}
    <span class="sidebar-text text-sm font-medium">{{ $slot }}</span>

    {{-- Background gradient overlay untuk hover effect --}}
    @if($variant === 'default')
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/0 to-green-600/0 group-hover:from-blue-600/10 group-hover:to-green-600/10 transition-all duration-300"></div>
    @elseif($variant === 'logout')
        <div class="absolute inset-0 bg-gradient-to-r from-red-600/0 to-red-800/0 group-hover:from-red-600/10 group-hover:to-red-800/10 transition-all duration-300"></div>
    @endif
</a>
