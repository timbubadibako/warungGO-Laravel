<div class="hidden lg:block transform transition-all duration-1000 ease-out delay-700"
     :class="loaded ? 'translate-x-0 opacity-100 rotate-0' : 'translate-x-8 opacity-0 rotate-12'">
    <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-500 hover:scale-110 hover:rotate-6 group">
        <x-lucide-store class="w-16 h-16 text-white group-hover:scale-110 transition-transform duration-300" />
        <!-- Pulsing ring -->
        <div class="absolute inset-0 rounded-full border-2 border-white/30 animate-ping"></div>
        <div class="absolute inset-2 rounded-full border border-white/20 animate-pulse"></div>
    </div>
</div>
