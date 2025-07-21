@props(['icon' => null, 'text' => '', 'class' => ''])

<span class="inline-block font-semibold bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm border border-white/20 hover:bg-white/30 transition-colors duration-300 {{ $class }}">
    {{ $icon ?? '' }}
    {{ $text ?? '' }}
</span>

