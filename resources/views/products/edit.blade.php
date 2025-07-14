<h1>Edit Produk: {{ $product->name }}</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')
    <div><label>Nama Produk: <input type="text" name="name" value="{{ old('name', $product->name) }}"></label></div>
    <div>
        <label>Kategori:
            <select name="category_id">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == old('category_id', $product->category_id)) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </label>
    </div>
    <div><label>Harga Beli: <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"></label></div>
    <div><label>Harga Jual: <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"></label></div>
    <div><label>Stok: <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"></label></div>
    <br>
    <button type="submit">Update</button>
</form>
