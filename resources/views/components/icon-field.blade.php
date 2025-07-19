<div class="form-group space-y-2">
    @if($label ?? false)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif
    <div class="input-with-icon relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            {!! $icon ?? '' !!}
        </div>
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type ?? 'text' }}"
            value="{{ $value ?? old($name) }}"
            {{ $attributes->merge([
                'class' => 'block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-gray-50 focus:bg-white'
            ]) }}
        />
    </div>
    {{ $slot }}
</div>
