{{-- filepath: resources/views/components/checkbox.blade.php --}}
<label class="flex items-center cursor-pointer hover:text-gray-700 transition-colors duration-200">
    <input
        type="checkbox"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-200'
        ]) }}
        @checked(old($name, $checked ?? false))
    />
    <span class="ml-2 text-sm text-gray-600">{{ $slot }}</span>
</label>
