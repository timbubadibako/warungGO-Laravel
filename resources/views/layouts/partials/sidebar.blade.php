{{-- Tambahkan flex flex-col dan justify-between agar grup bawah menempel --}}
<aside class="w-20 lg:w-64 bg-white flex flex-col justify-between flex-shrink-0 border-r border-gray-200 p-4">

    {{-- Grup Navigasi Atas --}}
    <div>
        <!-- Logo -->
        <div class="flex items-center justify-center h-24 border-b mb-4">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto" />
            </a>
        </div>

        <!-- Navigasi Utama -->
        <nav>
            {{-- Link untuk semua user (Admin & Kasir) --}}
            <x-side-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-slot name="icon">
                    <x-lucide-blocks class="w-8 h-8" />
                </x-slot>
                <span class="hidden lg:inline">Dashboard</span>
            </x-side-nav-link>

            <x-side-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.*')">
                <x-slot name="icon">
                    <x-lucide-shopping-bag class="w-8 h-8" />
                </x-slot>
                <span class="hidden lg:inline">POS Kasir</span>
            </x-side-nav-link>

            <x-side-nav-link :href="route('deliveries.index')" :active="request()->routeIs('deliveries.*')">
                <x-slot name="icon">
                    <x-lucide-package class="w-8 h-8" />
                </x-slot>
                <span class="hidden lg:inline">Delivery</span>
            </x-side-nav-link>

            <x-side-nav-link :href="route('debts.index')" :active="request()->routeIs('debts.*')">
                <x-slot name="icon">
                    <x-lucide-scroll-text class="w-8 h-8" />
                </x-slot>
                <span class="hidden lg:inline">Hutang</span>
            </x-side-nav-link>

            {{-- Link Khusus Admin --}}
            @hasrole('Admin')
                <p class="px-3 mt-6 mb-2 text-xs uppercase text-gray-400 hidden lg:block">Manajemen</p>

                <x-side-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    <x-slot name="icon">
                        <x-lucide-gallery-horizontal-end class="w-8 h-8" />
                    </x-slot>
                    <span class="hidden lg:inline">Kategori</span>
                </x-side-nav-link>

                <x-side-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    <x-slot name="icon">
                        <x-lucide-shopping-cart class="w-8 h-8" />
                    </x-slot>
                    <span class="hidden lg:inline">Produk</span>
                </x-side-nav-link>

                <x-side-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                    <x-slot name="icon">
                        <x-lucide-truck class="w-8 h-8" />
                    </x-slot>
                    <span class="hidden lg:inline">Supplier</span>
                </x-side-nav-link>

                 <x-side-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                    <x-slot name="icon">
                        <x-lucide-clipboard-check class="w-8 h-8" />
                    </x-slot>
                    <span class="hidden lg:inline">Pembelian</span>
                </x-side-nav-link>

                <x-side-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    <x-slot name="icon">
                        <x-lucide-user class="w-8 h-8" />
                    </x-slot>
                    <span class="hidden lg:inline">Users</span>
                </x-side-nav-link>
            @endhasrole
        </nav>
    </div>

    {{-- Grup Navigasi Bawah --}}
    <div>
        <nav>
            <x-side-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                <x-slot name="icon">
                    <x-lucide-settings class="w-8 h-8" />
                </x-slot>
                <span class="hidden lg:inline">Settings</span>
            </x-side-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-side-nav-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <x-slot name="icon">
                        <x-lucide-log-out class="w-8 h-8" />
                    </x-slot>
                    <span class="hidden lg:inline">Log Out</span>
                </x-side-nav-link>
            </form>
        </nav>
    </div>
</aside>
