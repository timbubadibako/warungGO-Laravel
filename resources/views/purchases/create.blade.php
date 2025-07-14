<h1>Catat Pembelian Baru</h1>
<form action="{{ route('purchases.store') }}" method="POST">
    @csrf
    <div>
        <label>Supplier:
            <select name="supplier_id" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </label>
    </div>
    <div>
        <label>Tanggal Pembelian:
            <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" required>
        </label>
    </div>
    <br>
    <button type="submit">Lanjut & Tambah Item</button>
</form>
