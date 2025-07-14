<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Hutang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Daftar Hutang Belum Lunas</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead style="background-color: #f2f2f2;">
                            <tr>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Tanggal</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Invoice</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Nama Pelanggan</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: right;">Jumlah</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unpaidDebts as $debt)
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $debt->created_at->format('d M Y') }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $debt->order->invoice_number }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $debt->customer_name }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">Rp {{ number_format($debt->amount, 0, ',', '.') }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">
                                    <form action="{{ route('debts.pay', $debt) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Tandai hutang ini sebagai lunas?')">
                                            Tandai Lunas
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 8px; border: 1px solid #ddd; text-align: center;">Tidak ada data hutang.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
