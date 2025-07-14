<h1>Tambah Produk Baru</h1>

{{-- Tampilkan error validasi jika ada --}}
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div><label>Nama Produk: <input type="text" name="name" value="{{ old('name') }}"></label></div>
    <div>
        <label>Kategori:
            <select name="category_id">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
    </div>
    <div><label>Harga Beli: <input type="number" name="purchase_price" value="{{ old('purchase_price') }}"></label></div>
    <div><label>Harga Jual: <input type="number" name="selling_price" value="{{ old('selling_price') }}"></label></div>
    <div><label>Stok Awal: <input type="number" name="stock" value="{{ old('stock') }}"></label></div>
    <br>
    <button type="submit">Simpan</button>
</form>
