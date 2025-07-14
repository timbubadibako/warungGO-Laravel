<h1>Riwayat Pembelian</h1>
<a href="{{ route('purchases.create') }}">Catat Pembelian Baru</a>
<br><br>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
        <tr>
            <td>{{ $purchase->purchase_date }}</td>
            <td>{{ $purchase->supplier->name }}</td>
            <td>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
            <td>{{ $purchase->status }}</td>
            <td>
                <a href="{{ route('purchases.show', $purchase) }}">Detail</a>
                @if($purchase->status == 'pending')
                <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
