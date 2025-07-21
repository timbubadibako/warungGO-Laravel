@props([
    'iconBg',           // Tailwind background class for icon
    'title',            // Judul/stat label
    'value',            // Value utama/statistik
    'desc' => '',       // Optional deskripsi/subtext
    'badge' => '',      // Optional badge (growth, dsb)
    'badgeBg' => '',    // Background class badge
    'badgeText' => '',  // Text color badge
    'effectBg' => '',   // Optional background effect class
    'hoverMain' => '',  // Main text hover color
    'transitionDelay' => '', // For animation delay, e.g. '100ms'
])

<div class="relative group bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm p-6 hover:shadow-md transition-all duration-200"
    style="transition-delay: {{ $transitionDelay }};">
    <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 {{ $iconBg }} rounded-xl flex items-center justify-center transition-all duration-200 group-hover:scale-105">
            {{-- Icon slot dengan animasi ringan (sedikit scale saat hover) --}}
            {{ $icon }}
        </div>
        @if($badge)
            <span class="text-sm font-semibold px-2 py-1 rounded-full transition-colors duration-150 {{ $badgeBg }} {{ $badgeText }}">
                {!! $badge !!}
            </span>
        @endif
    </div>
    <h3 class="text-gray-500 text-sm font-medium">{{ $title }}</h3>
    <p class="text-3xl font-bold text-gray-800 mt-1 transition-colors duration-200">{{ $value }}</p>
    @if($desc)
        <p class="text-sm text-gray-500 mt-2 transition-colors duration-150">{{ $desc }}</p>
    @endif
    @if($effectBg)
        <div class="absolute inset-0 {{ $effectBg }} rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
    @endif
</div>
