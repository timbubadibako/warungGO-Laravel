<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background-color: #f2f2f2;">
                            <tr>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Invoice</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Pelanggan</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Alamat</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Status</th>
                                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deliveries as $delivery)
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $delivery->invoice_number }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $delivery->customer_notes }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $delivery->customer_address }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">{{ $delivery->delivery_status }}</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">
                                    <form action="{{ route('deliveries.updateStatus', $delivery) }}" method="POST">
                                        @csrf
                                        <select name="delivery_status">
                                            <option value="pending" @if($delivery->delivery_status == 'pending') selected @endif>Pending</option>
                                            <option value="preparing" @if($delivery->delivery_status == 'preparing') selected @endif>Preparing</option>
                                            <option value="out_for_delivery" @if($delivery->delivery_status == 'out_for_delivery') selected @endif>Out for Delivery</option>
                                            <option value="delivered" @if($delivery->delivery_status == 'delivered') selected @endif>Delivered</option>
                                            <option value="cancelled" @if($delivery->delivery_status == 'cancelled') selected @endif>Cancelled</option>
                                        </select>
                                        <button type="submit">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
