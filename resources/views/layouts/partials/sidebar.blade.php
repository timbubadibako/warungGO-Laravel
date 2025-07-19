{{-- Modern Sidebar dengan Gradient Background --}}
<aside id="sidebar" class="w-64 h-full bg-gradient-to-b from-slate-800 via-slate-900 to-slate-800 flex flex-col justify-between flex-shrink-0 shadow-2xl relative overflow-hidden transition-all duration-300 ease-in-out">

    {{-- Background Pattern --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-transparent to-green-600/10"></div>
    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -translate-y-16 translate-x-16"></div>
    <div class="absolute bottom-20 left-0 w-24 h-24 bg-green-500/5 rounded-full -translate-x-12"></div>

    <style>
        .sidebar-text {
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
    </style>

    {{-- Grup Navigasi Atas --}}
    <div class="relative z-10 p-4">
        <!-- Logo Section dengan Hamburger -->
        <div class="flex items-center justify-between h-20 mb-8 group">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 transition-transform duration-300 hover:scale-105">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <x-lucide-shopping-cart class="w-6 h-6 text-white" />
                </div>
                <div class="sidebar-text">
                    <h1 class="text-xl font-bold text-white">
                        Warung<span class="text-green-400">GO</span>
                    </h1>
                    <p class="text-xs text-slate-400 -mt-1">POS System</p>
                </div>
            </a>

            <!-- Hamburger Button - Tampil di semua ukuran layar -->
            <button id="sidebarToggle" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white transition-colors duration-200 hover:bg-slate-700 rounded-lg">
                <x-lucide-menu class="w-5 h-5" />
            </button>
        </div>

        <!-- Navigasi Utama -->
        <nav class="space-y-3">
            {{-- Link untuk semua user (Admin & Kasir) --}}
            <x-side-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-slot name="icon">
                    <x-lucide-layout-dashboard class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                </x-slot>
                Dashboard
            </x-side-nav-link>

            <x-side-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.*')">
                <x-slot name="icon">
                    <x-lucide-shopping-bag class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                </x-slot>
                POS Kasir
            </x-side-nav-link>

            <x-side-nav-link :href="route('deliveries.index')" :active="request()->routeIs('deliveries.*')">
                <x-slot name="icon">
                    <x-lucide-package class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                </x-slot>
                Delivery
            </x-side-nav-link>

            <x-side-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')">
                <x-slot name="icon">
                    <x-lucide-scroll-text class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                </x-slot>
                Hutang
            </x-side-nav-link>

            {{-- Link Khusus Admin --}}
            @hasrole('Admin')
                <!-- Admin Section Divider -->
                <div class="sidebar-text mt-8 mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-slate-600 to-transparent"></div>
                        <span class="px-3 text-xs uppercase text-slate-400 font-semibold tracking-wider">Manajemen</span>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-slate-600 to-transparent"></div>
                    </div>
                </div>

                <div class="space-y-2">
                    <x-side-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        <x-slot name="icon">
                            <x-lucide-grid-3x3 class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                        </x-slot>
                        Kategori
                    </x-side-nav-link>

                    <x-side-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        <x-slot name="icon">
                            <x-lucide-package-2 class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                        </x-slot>
                        Produk
                    </x-side-nav-link>

                    <x-side-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                        <x-slot name="icon">
                            <x-lucide-truck class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                        </x-slot>
                        Supplier
                    </x-side-nav-link>

                    <x-side-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                        <x-slot name="icon">
                            <x-lucide-clipboard-check class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" />
                        </x-slot>
                        Pembelian
                    </x-side-nav-link>
                </div>
            @endhasrole
        </nav>
    </div>

    {{-- Grup Navigasi Bawah --}}
    <div class="relative z-10 p-4 border-t border-slate-600/50">
        <nav class="space-y-2">
            <x-side-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" variant="settings">
                <x-slot name="icon">
                    <x-lucide-settings class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" />
                </x-slot>
                Settings
            </x-side-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-side-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" variant="logout">
                    <x-slot name="icon">
                        <x-lucide-log-out class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" />
                    </x-slot>
                    Log Out
                </x-side-nav-link>
            </form>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-text mt-6 pt-4 border-t border-slate-600/30">
            <div class="flex items-center space-x-3 text-slate-500 text-xs">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span>v1.0 - Online</span>
            </div>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    let isCollapsed = false;

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (isCollapsed) {
                // Expand sidebar
                sidebar.style.width = '256px'; // w-64 = 16rem = 256px

                // Show text after animation starts with fade in
                setTimeout(() => {
                    sidebarTexts.forEach(text => {
                        text.style.opacity = '1';
                        text.style.visibility = 'visible';
                    });
                }, 150);

                // Change icon to X
                const icon = toggleBtn.querySelector('svg');
                icon.setAttribute('data-lucide', 'x');

                isCollapsed = false;
            } else {
                // Collapse sidebar
                sidebar.style.width = '80px'; // w-20 = 5rem = 80px

                // Hide text immediately with fade out
                sidebarTexts.forEach(text => {
                    text.style.opacity = '0';
                    text.style.visibility = 'hidden';
                });

                // Change icon to menu
                const icon = toggleBtn.querySelector('svg');
                icon.setAttribute('data-lucide', 'menu');

                isCollapsed = true;
            }

            // Reinitialize lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
});
</script>
