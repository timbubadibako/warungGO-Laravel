<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                <div style="background: white; padding: 20px; border-radius: 8px;">
                    <h4>Pendapatan Hari Ini</h4>
                    <h3>Rp {{ number_format($todaysRevenue, 0, ',', '.') }}</h3>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px;">
                    <h4>Keuntungan Hari Ini</h4>
                    <h3>Rp {{ number_format($todaysProfit, 0, ',', '.') }}</h3>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px;">
                    <h4>Transaksi Hari Ini</h4>
                    <h3>{{ $todaysTransactions }} Transaksi</h3>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div style="background: white; padding: 20px; border-radius: 8px;">
                    <h4>Pergerakan Stok (7 Hari Terakhir)</h4>
                    <canvas id="stockChart"></canvas>
                </div>

                <div style="background: white; padding: 20px; border-radius: 8px;">
                    <h4>Produk Terlaris (7 Hari Terakhir)</h4>
                    <ol>
                        @forelse($topProducts as $item)
                            <li>{{ $item->product->name }} ({{ $item->total_quantity }} terjual)</li>
                        @empty
                            <li>Belum ada data.</li>
                        @endforelse
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('stockChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Barang Masuk',
                    data: {!! json_encode($stockIn->values()) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Barang Keluar',
                    data: {!! json_encode($stockOut->values()) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
