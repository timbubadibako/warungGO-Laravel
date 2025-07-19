<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'w-full bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl group'
    ]) }}
>
    <span class="flex items-center justify-center">
        {{ $icon ?? '' }}
        {{ $slot }}
    </span>
</button>
