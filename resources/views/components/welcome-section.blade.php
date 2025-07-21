<div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-green-600 rounded-3xl p-8 text-white shadow-2xl">

    <!-- Soft background overlay (no pulse) -->
    <div class="absolute inset-0 bg-black/10"></div>

    <!-- Simple decorative elements, NO bounce animation, just circles -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute w-2 h-2 bg-white/20 rounded-full" style="top: 22%; left: 12%;"></div>
        <div class="absolute w-1 h-1 bg-white/30 rounded-full" style="top: 59%; left: 24%;"></div>
        <div class="absolute w-3 h-3 bg-white/15 rounded-full" style="top: 34%; right: 28%;"></div>
        <div class="absolute w-1.5 h-1.5 bg-white/25 rounded-full" style="top: 72%; right: 10%;"></div>
    </div>

    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div class="space-y-4">
                <!-- Title, subtitle, stats pills: no translate/opacity/animate-pulse -->
                <h1 class="text-4xl font-bold mb-2">
                    Selamat Datang di Warung GO!
                </h1>

                <p class="text-blue-100 text-lg">
                    {{ now()->locale('id')->format('l, d F Y') }}
                    <span class="mx-2">-</span>
                    <x-dashboard.glass-span text="Kelola warung Anda dengan mudah" />
                </p>
                <div class="flex flex-wrap gap-3 mt-4">
                    <x-dashboard.glass-span text="System Online" />
                    <x-dashboard.glass-span text="Powered by Laravel" />
                </div>
            </div>
            <x-dashboard.animated-icon />
        </div>
    </div>

    <!-- Decorative circles, no animation -->
    <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-white/5 rounded-full"></div>

    <!-- Subtle shimmer gradient overlay, NO animate-shimmer -->
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
</div>
