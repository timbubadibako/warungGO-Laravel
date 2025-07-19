<div {{ $attributes->merge(['class' => 'bg-blue-50 border border-blue-200 rounded-lg p-4']) }}>
    <div class="flex items-center justify-center mb-2">
        {{-- Icon slot, default info --}}
        <span class="mr-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </span>
        <h4 class="text-sm font-semibold {{ $titleColor ?? 'text-blue-800' }}">
            {{ $title ?? 'Informasi' }}
        </h4>
    </div>
    <div class="text-xs {{ $textColor ?? 'text-blue-700' }} leading-relaxed">
        {{ $slot }}
    </div>
</div>
