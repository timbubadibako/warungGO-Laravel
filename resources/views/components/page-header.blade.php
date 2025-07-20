<header class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 px-6 h-28 flex-shrink-0 flex items-center shadow-sm">
    <div class="flex justify-between items-center w-full">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">{{ $title }}</h1>
            @if(!empty($subtitle))
                <p class="text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
        @if(!empty($search))
            <div class="w-1/2 max-w-md">
                {{ $search }}
            </div>
        @endif
        @if(!empty($button))
            <div>
                {{ $button }}
            </div>
        @endif
    </div>
</header>
