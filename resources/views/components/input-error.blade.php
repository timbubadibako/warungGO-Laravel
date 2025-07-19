@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'mt-2']) }}>
        @foreach ((array) $messages as $message)
            <div class="flex items-center space-x-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                <x-lucide-alert-circle class="w-4 h-4 text-red-500 flex-shrink-0" />
                <span>{{ $message }}</span>
            </div>
        @endforeach
    </div>
@endif
