<h1>Detail Pembelian</h1>
<p><strong>Supplier:</strong> {{ $purchase->supplier->name }}</p>
<p><strong>Tanggal:</strong> {{ $purchase->purchase_date }}</p>
<p><strong>Status:</strong> {{ $purchase->status }}</p>

<hr>

{{-- Hanya tampilkan form jika status masih 'pending' --}}
@if($purchase->status == 'pending')
    <h3>Tambah Item</h3>
    <form action="{{ route('purchases.addItem', $purchase) }}" method="POST">
        @csrf
        <label>Produk:
            <select name="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Jumlah: <input type="number" name="quantity" required min="1"></label>
        <label>Harga Beli/Modal: <input type="number" name="cost_price" required min="0"></label>
        <button type="submit">Tambah</button>
    </form>
    <hr>
@endif

<h3>Item Pembelian</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga Modal</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchase->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->cost_price, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->quantity * $item->cost_price, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" style="text-align:right;">Total</th>
            <th>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>

<br>

{{-- Hanya tampilkan tombol jika status masih 'pending' dan sudah ada item --}}
@if($purchase->status == 'pending' && $purchase->items->count() > 0)
    <form action="{{ route('purchases.complete', $purchase) }}" method="POST">
        @csrf
        <button type="submit" onclick="return confirm('Selesaikan pembelian ini? Stok akan diperbarui dan tidak bisa diubah lagi.')">
            Selesaikan Pembelian & Update Stok
        </button>
    </form>
@endif
